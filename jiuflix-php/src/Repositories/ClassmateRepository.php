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
}