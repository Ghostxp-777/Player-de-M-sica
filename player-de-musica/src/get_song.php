<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Sua lógica para conectar ao banco e buscar a música pelo ID
$id = $_GET['id'] ?? null;

if ($id) {
    // Buscar música do banco
    // Retornar JSON com os dados
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'ID não fornecido']);
}
?>