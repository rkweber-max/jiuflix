<?php

namespace App\DTOs;

class ClassmateRequestDTO {
    public $name;
    public $typeGraduation;
    public $age;
    public $gender;
    public $category;
    public ?int $id;

    public function __construct($name, $typeGraduation, $age, $gender, $category, ?int $id = null)
    {
        $this->name = $name;
        $this->typeGraduation = $typeGraduation;
        $this->age = $age;
        $this->gender = $gender;
        $this->category = $category;
        $this->id = $id;
    }
}