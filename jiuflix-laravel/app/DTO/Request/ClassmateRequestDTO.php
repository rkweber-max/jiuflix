<?php

namespace App\DTO\Request;

use App\Http\Requests\ClassmateRequest;
use App\Enums\Strips;

class ClassmateRequestDTO {

    public function __construct(
        public readonly string $name,
        public readonly Strips $typeGraduation,
        public readonly int $age,
        public readonly string $gender,
        public readonly string $category,
        public readonly ?int $id = null,
    ){}
    
    public static function fromRequest(ClassmateRequest $request): self {
        return new self(
            name: $request->input('name'),
            typeGraduation: Strips::from($request->input('type_graduation')),
            age: $request->input('age'),
            gender: $request->input('gender'),
            category: $request->input('category'),
            id: $request->input('id')
        );
    }
}
