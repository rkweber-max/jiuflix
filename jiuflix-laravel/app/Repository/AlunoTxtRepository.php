<?php

namespace App\Repository;

use App\DTO\Response\ClassmateResponseDTO;
use App\Enums\Strips;

class AlunoTxtRepository implements AlunoRepository
{
    public function createAluno(array $array): ClassmateResponseDTO
    {
        $classmateResponse = new ClassmateResponseDTO(
                $array['name'],
                Strips::from($array['type_graduation']),
                $array['age'],
                $array['gender'],
                $array['category'],
                32
            );

        $data = [
            $classmateResponse->toArray()
        ];

        $filePath = storage_path('app/classmate.txt');

        file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));
        
        return $classmateResponse;
    }

    public function updateAluno(int $id, array $array): ClassmateResponseDTO
    {
        throw new \Exception('Not implemented');
    }
}
