<?php

function connectionDatabase () {
    try {
        return new PDO('pgsql:host=127.0.0.1;port=5432;dbname=jiuflix', 'maxter', 'admin', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal server error']);
        exit;
    }
}
