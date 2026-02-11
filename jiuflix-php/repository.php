<?php

$body = json_decode(file_get_contents('php://input'), true);

function created ($name, $typeGraduation) {
    $pdo = connectionDatabase();
    $sql = "INSERT INTO aluno (name, type_graduation) VALUES (:name, :type_graduation)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':type_graduation', $typeGraduation);
    $stmt->execute();
}

function updated ($name, $typeGraduation, $id) {
    $pdo = connectionDatabase();

    $sql = "UPDATE aluno SET name = :name, type_graduation = :type_graduation WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':type_graduation', $typeGraduation, PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

