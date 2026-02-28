<?php

namespace App\Logging;

use GuzzleHttp\Client;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class ElasticsearchHandler extends AbstractProcessingHandler
{
    private Client $client;
    private string $index;

    public function __construct(string $endpoint, string $index, $level = Logger::DEBUG, bool $bubble = true)
    {
        parent::__construct($level, $bubble);

        $this->client = new Client([
            'base_uri' => rtrim($endpoint, '/'),
            'timeout' => 2.0,
        ]);

        $this->index = $index;
    }

    protected function write($record): void
    {
        $document = [
            'service' => config('app.name'),
            'level' => $record['level_name'],
            'message' => $record['message'],
            'context' => $record['context'],
            'extra' => $record['extra'],
            'timestamp' => $record['datetime']->format('c'),
        ];

        try {
            $this->client->post(sprintf('/%s/_doc', $this->index), [
                'json' => $document,
            ]);
        } catch (\Throwable $e) {
        }
    }
}

class ElasticsearchLogger
{
    public function __invoke(array $config): Logger
    {
        $endpoint = $config['endpoint'] ?? env('ELASTIC_ENDPOINT', 'http://localhost:9200');
        $index = $config['index'] ?? env('ELASTIC_LOG_INDEX', 'logs');
        $level = Logger::toMonologLevel($config['level'] ?? env('LOG_LEVEL', 'debug'));

        $logger = new Logger($config['name'] ?? 'elasticsearch');
        $logger->pushHandler(new ElasticsearchHandler($endpoint, $index, $level));

        return $logger;
    }
}

