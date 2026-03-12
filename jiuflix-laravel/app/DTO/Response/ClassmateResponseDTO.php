<?php

namespace App\DTO\Response;

use App\Enums\Strips;
use App\Models\Aluno;

class ClassmateResponseDTO {
    public function __construct(
        public readonly string $name,
        public readonly Strips $typeGraduation,
        public readonly int $age,
        public readonly string $gender,
        public readonly string $category,
        public readonly ?int $id = null,
    ){}

    public static function fromModel(Aluno $aluno): self
    {
        return new self(
            id: $aluno->id,
            name: $aluno->name,
            typeGraduation: Strips::from($aluno->type_graduation),
            age: $aluno->age,
            gender: $aluno->gender,
            category: $aluno->category
        );
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type_graduation' => $this->typeGraduation->value,
            'age' => $this->age,
            'gender' => $this->gender,
            'category' => $this->category
        ];
    }

}