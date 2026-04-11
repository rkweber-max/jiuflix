<?php

namespace Test;

use App\DTOs\ClassmateResponseDTO;
use App\DTOs\ClassmateRequestDTO;
use App\Repositories\ClassmateRepository;
use App\Services\ClassmateService;
use PHPUnit\Framework\TestCase;

class CreateClassmateTest extends TestCase
{
    public function test_happy_path(): void
    {
        $dto = new ClassmateRequestDTO(
            "Rodrigo",
            "BRANCA",
            23,
            "M",
            "ML"
        );

        $response = new ClassmateResponseDTO();
        $response->id = '11231';
        $response->name = 'Rodrigo';
        $response->typeGraduation = 'BRANCA';
        $response->age = '23';
        $response->gender = 'M';
        $response->category = 'ML';

        // Criando mock do repositorio aluno
        $repository = $this->createMock(ClassmateRepository::class);
        $repository
            ->method('create')
            ->willReturn($response);

        $service = new ClassmateService($repository);

        $aluno = $service->create($dto);

        $this->assertEquals($response, $aluno);
    }
}
