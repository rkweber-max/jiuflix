<?php

namespace App\Repository;

use App\DTO\Response\ClassmateResponseDTO;
use App\Enums\Strips;

class AlunoCsvRepository implements AlunoRepository
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

        $filePath = storage_path('app/classmate.csv');

        $file = fopen($filePath, 'w');

        fputcsv($file, array_keys($data[0]));

        foreach ($data as $rows) {
            fputcsv($file, $rows);
        }

        fclose($file);
        return $classmateResponse;
    }
}
