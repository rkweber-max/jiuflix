<?php

namespace Tests\Unit;

use App\DTO\Response\ClassmateResponseDTO;
use App\Enums\Strips;
use App\Repository\AlunoRepository;
use App\Services\AlunoService;
use PHPUnit\Framework\TestCase;

class CreateClassmateTest extends TestCase
{
    public function test_happy_path(): void
    {
        $arrayClassmate = [
            'name' => 'Rodrigo',
            'type_graduation' => 'BRANCA',
            'age' => 21,
            'gender' => "M",
            'category' => "ML"
        ];

        $response = new ClassmateResponseDTO(
            "Rodrigo", 
            Strips::from("branca"),
            23,
            "M",
            "ML"
        );

        // Criando mock do repositorio aluno
        $repository = $this->createMock(AlunoRepository::class);
        $repository
            ->method('createAluno')
            ->willReturn($response);

        $service = new AlunoService();

        $service->setRepository($repository);
        $aluno = $service->createAluno($arrayClassmate);

        $this->assertEquals($aluno, $response);
    }
}