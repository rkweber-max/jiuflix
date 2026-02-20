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
        $pdo =  connectionDatabase();
    
        $sql = "SELECT * FROM aluno WHERE id = ?";
    
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);                                   
    }

    public function delete ($id) {
        $pdo = connectionDatabase();


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
}