<?php

$body = json_decode(file_get_contents('php://input'), true);

class AlunosRepository
{
    public static function created($name, $typeGraduation)
    {
        $pdo = connectionDatabase();
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

    public static function getAll()
    {
        $pdo = connectionDatabase();
        $sql = "SELECT * FROM aluno";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $array = $stmt->fetchALL(PDO::FETCH_ASSOC);

        http_response_code(200);
        echo json_encode(['Alunos' => $array, 'message' => 'Alunos retornados com sucesso!']);
        exit;
    }

    public static function updated($name, $typeGraduation, $id)
    {
        $pdo = connectionDatabase();

        $sql = "UPDATE aluno SET name = :name, type_graduation = :type_graduation WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':type_graduation', $typeGraduation, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $sqlId = "SELECT * FROM aluno WHERE id = :id";
        $stmt = $pdo->prepare($sqlId);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_OBJ);

        return $result;
    }

    public static function getById($id)
    {
        $pdo =  connectionDatabase();
    
        $sql = "SELECT * FROM aluno WHERE id = ?";
    
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function deleted($id)
    {
        $pdo = connectionDatabase();
    
        $sql = "DELETE FROM aluno WHERE id = ?";
    
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}