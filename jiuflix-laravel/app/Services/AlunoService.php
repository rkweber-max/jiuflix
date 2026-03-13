<?php

namespace App\Services;

use App\DTO\Response\ClassmateResponseDTO;
use App\Repository\AlunoRepository;

class AlunoService
{
    private AlunoRepository $repository;

    public function setRepository(AlunoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createAluno(array $array): ClassmateResponseDTO
    {
        $aluno = $this->repository->createAluno($array);

        return $aluno;
    }

    public function updateAluno(int $id, array $array): ClassmateResponseDTO
    {
        $aluno = $this->repository->updateAluno($id, $array);

        return $aluno;
    }
}
