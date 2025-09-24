<?php
require_once('../config/database.php');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, PUT, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Permitir requisições OPTIONS (CORS)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

// Os dados vêm do corpo da requisição
$data = json_decode(file_get_contents('php://input'), true);

// Verificar se todos os dados necessários estão presentes
if (!isset($data['id'], $data['titulo'], $data['artista'], $data['caminho_arquivo'])) {
    http_response_code(400);
    echo json_encode(['status' => 'erro', 'mensagem' => 'Dados inválidos. ID, título, artista e caminho_arquivo são obrigatórios.']);
    exit;
}

$id = $data['id'];

try {
    // Comando SQL para atualizar uma música
    $sql = "UPDATE songs SET titulo = ?, artista = ?, album = ?, caminho_arquivo = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $data['titulo'],
        $data['artista'],
        $data['album'] ?? null,
        $data['caminho_arquivo'],
        $id
    ]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => 'sucesso', 'mensagem' => 'Música atualizada com sucesso!']);
    } else {
        http_response_code(404);
        echo json_encode(['status' => 'erro', 'mensagem' => 'Música não encontrada ou nenhum dado alterado.']);
    }
} catch (\PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao atualizar a música: ' . $e->getMessage()]);
}
?>