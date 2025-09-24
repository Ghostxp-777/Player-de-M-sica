<?php
require_once('../config/database.php');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Permitir requisições OPTIONS (CORS)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

$id = $_GET['id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(['status' => 'erro', 'mensagem' => 'ID não fornecido']);
    exit;
}

try {
    $sql = "SELECT * FROM songs WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $song = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($song) {
        echo json_encode(['status' => 'sucesso', 'data' => $song]);
    } else {
        http_response_code(404);
        echo json_encode(['status' => 'erro', 'mensagem' => 'Música não encontrada']);
    }
} catch (\PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao buscar música: ' . $e->getMessage()]);
}
?>