<?php

namespace App\OpenTelemetry;

use GuzzleHttp\Client;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use OpenTelemetry\API\Logs\LoggerProviderInterface;

class ElasticsearchDirectHandler extends AbstractProcessingHandler
{
    private Client $client;
    private string $index;
    private string $serviceName;

    public function __construct(
        string $endpoint,
        string $index,
        string $serviceName,
        $level = Logger::DEBUG,
        bool $bubble = true
    ) {
        parent::__construct($level, $bubble);

        $this->client = new Client([
            'base_uri' => rtrim($endpoint, '/'),
            'timeout' => 2.0,
        ]);

        $this->index = $index;
        $this->serviceName = $serviceName;
    }

    protected function write(\Monolog\LogRecord $record): void
    {
        $document = [
            'service' => $this->serviceName,
            'level' => $record->level->getName(),
            'message' => $record->message,
            'context' => $record->context ?? [],
            'timestamp' => $record->datetime->format('Y-m-d\TH:i:s'),
        ];

        try {
            error_log("ElasticsearchDirectHandler: Tentando enviar log para {$this->index}");
            
            $response = $this->client->post(sprintf('/%s/_doc', $this->index), [
                'json' => $document,
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]);
            
            error_log("ElasticsearchDirectHandler: Log enviado com sucesso! Status: " . $response->getStatusCode());
        } catch (\Throwable $e) {
            error_log("Failed to send log to Elasticsearch: " . $e->getMessage());
        }
    }
}

class OpenTelemetryBootstrap
{
    public static function createElasticsearchHandler(): ElasticsearchDirectHandler
    {
        $endpoint = env('ELASTIC_ENDPOINT', 'http://localhost:9200');
        $index = env('ELASTIC_LOG_INDEX', 'logs');
        $serviceName = env('OTEL_SERVICE_NAME', config('app.name', 'laravel'));

        return new ElasticsearchDirectHandler(
            $endpoint,
            $index,
            $serviceName,
            Logger::DEBUG
        );
    }
}
