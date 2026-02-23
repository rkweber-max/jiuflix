<?php

namespace App\Repositories;

use App\Databases\Database;
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

    public function create ($name, $typeGraduation) {
        $database = new Database();
        $pdo = $database->connectionDatabase();
        $sql = "INSERT INTO aluno (name, type_graduation) VALUES (:name, :type_graduation)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':type_graduation', $typeGraduation);
        $stmt->execute();

        $id = $pdo->lastInsertId();

        $sqlId = "SELECT * FROM aluno WHERE id = :id";
        $stmt = $pdo->prepare($sqlId);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
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