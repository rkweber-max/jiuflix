<?php

namespace App\Repositories;

use App\Databases\Database;
use App\DTOs\ClassmateRequestDTO;
use App\DTOs\ClassmateResponseDTO;
use App\Exceptions\NotFoundException;
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
        $responseDto->id = trim((string) $result[0]['id']);
        $responseDto->name = trim((string) $result[0]['name']);
        $responseDto->typeGraduation = trim((string) $result[0]['type_graduation']);
        $responseDto->age = trim((string) ($result[0]['age']));
        $responseDto->gender = trim((string) ($result[0]['gender']));
        $responseDto->category = trim(($result[0]['category']));

        return $responseDto;
    }

    public function updated(ClassmateRequestDTO $dto): ClassmateResponseDTO
    {
        $database = new Database();
        $pdo = $database->connectionDatabase();

        $sqlId = "SELECT * FROM aluno WHERE id = :id";
        $stmt = $pdo->prepare($sqlId);
        $stmt->bindValue(':id', $dto->id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            throw new NotFoundException('Aluno não encontrado');
        }

        $sql = "UPDATE aluno SET name = :name, type_graduation = :type_graduation, age = :age, gender = :gender, category = :category WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':name', $dto->name, PDO::PARAM_STR);
        $stmt->bindValue(':type_graduation', $dto->typeGraduation, PDO::PARAM_STR);
        $stmt->bindValue(':age', $dto->age, PDO::PARAM_STR);
        $stmt->bindValue(':gender', $dto->gender, PDO::PARAM_STR);
        $stmt->bindValue(':category', $dto->category, PDO::PARAM_STR);
        $stmt->bindValue(':id', $dto->id, PDO::PARAM_INT);
        $stmt->execute();

        $sqlUpdated = "SELECT * FROM aluno WHERE id = :id";
        $stmt = $pdo->prepare($sqlUpdated);
        $stmt->bindValue(':id', $dto->id, PDO::PARAM_INT);
        $stmt->execute();

        $updated = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$updated) {
            throw new NotFoundException('Aluno não encontrado');
        }

        $responseDto = new ClassmateResponseDTO();
        $responseDto->id = trim($updated['id']);
        $responseDto->name = trim($updated['name']);
        $responseDto->typeGraduation = trim($updated['type_graduation']);
        $responseDto->age = trim(($updated['age']));
        $responseDto->gender = trim(($updated['gender']));
        $responseDto->category = trim(($updated['category']));

        return $responseDto;
    }
}