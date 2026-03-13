<?php

namespace App\Repository;

use App\DTO\Response\ClassmateResponseDTO;
use App\Models\Aluno;

class AlunoEloquentRepository implements AlunoRepository
{
    public function createAluno(array $array): ClassmateResponseDTO
    {
        $aluno = Aluno::create($array);
        $response = ClassmateResponseDTO::fromModel($aluno);
        return $response;
    }

    public function updateAluno(int $id, array $array): ClassmateResponseDTO
    {
        $aluno = Aluno::findOrFail($id);
        $aluno->update($array);

        $response = ClassmateResponseDTO::fromModel($aluno);
        return $response;
    }
}
