<?php

namespace App\Repositories;

use App\Databases\Database;
use App\DTOs\ClassmateRequestDTO;
use App\DTOs\ClassmateResponseDTO;
use PDO;

class ClassmateRepository {
    public function getAll()
    {
        $database = new Database();
        $pdo = $database->connectionDatabase();

        $sql = "SELECT * FROM aluno";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $array = $stmt->fetchALL(PDO::FETCH_ASSOC);

        return $array;
    }

    public function getById($id) {
        $database = new Database();
        $pdo = $database->connectionDatabase();
    
        $sql = "SELECT * FROM aluno WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete ($id) {
        $database = new Database();
        $pdo = $database->connectionDatabase();


        $sqlId = "SELECT * FROM aluno WHERE id = :id";
        $stmt = $pdo->prepare($sqlId);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$result) {
            return null;
        }
    
        $sql = "DELETE FROM aluno WHERE id = ?";
    
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        return $result;
    }

    public function create (ClassmateRequestDTO $dto): ClassmateResponseDTO {
        $database = new Database();
        $pdo = $database->connectionDatabase();
        $sql = "INSERT INTO aluno (name, type_graduation, age, gender, category) VALUES (:name, :type_graduation, :age, :gender, :category)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':name', $dto->name);
        $stmt->bindValue(':type_graduation', $dto->typeGraduation);
        $stmt->bindValue(':age', $dto->age);
        $stmt->bindValue(':gender', $dto->gender);
        $stmt->bindValue(':category', $dto->category);
        $stmt->execute();

        $id = $pdo->lastInsertId();

        $sqlId = "SELECT * FROM aluno WHERE id = :id";
        $stmt = $pdo->prepare($sqlId);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $responseDto = new ClassmateResponseDTO();
        $responseDto->id = trim( $result[0]['id']);
        $responseDto->name = trim( $result[0]['name']);
        $responseDto->typeGraduation = trim( $result[0]['type_graduation']);
        $responseDto->age = trim( $result[0]['age']);
        $responseDto->gender = trim( $result[0]['gender']);
        $responseDto->category = trim( $result[0]['category']);

        return $responseDto;
    }

    public function updated($name, $typeGraduation, $id)
    {
        $database = new Database();
        $pdo = $database->connectionDatabase();

        $sqlId = "SELECT * FROM aluno WHERE id = :id";
        $stmt = $pdo->prepare($sqlId);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$result) {
            return null;
        }

        $sql = "UPDATE aluno SET name = :name, type_graduation = :type_graduation WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':type_graduation', $typeGraduation, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $result;
    }
}