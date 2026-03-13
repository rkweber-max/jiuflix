<?php

namespace App\Repository;

use App\DTO\Response\ClassmateResponseDTO;

interface AlunoRepository {
    public function createAluno (array $array): ClassmateResponseDTO;
}