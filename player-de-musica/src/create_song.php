<?php
// Inclui o arquivo de conexão com o banco de dados
require_once('../config/database.php');
// Define o cabeçalho para indicar que a resposta será em JSON
header('Content-Type: application/json');
// Pega os dados do corpo da requisição (JSON)
$data = json_decode(file_get_contents('php://input'), true);

// Verifica se os campos obrigatórios foram enviados
if (!isset($data['titulo'], $data['artista'], $data['caminho_arquivo'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['mensagem' => 'Dados incompletos.']);
    exit;
}

// Validar extensão do arquivo
$allowedExtensions = ['.mp3', '.wav', '.ogg', '.m4a', '.aac', '.flac', '.wma'];
$fileExtension = strtolower(strrchr($data['caminho_arquivo'], '.'));
if (!in_array($fileExtension, $allowedExtensions)) {
    http_response_code(400);
    echo json_encode(['mensagem' => 'Tipo de arquivo não permitido. Use: .mp3, .wav, .ogg, .m4a, .aac, .flac ou .wma']);
    exit;
}

try {
    // Comando SQL para inserir dados
    $sql = "INSERT INTO songs (titulo, artista, album, caminho_arquivo) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $data['titulo'],
        $data['artista'],
        $data['album'] ?? null,
        $data['caminho_arquivo']
    ]);
    
    echo json_encode(['mensagem' => 'Música adicionada com sucesso!', 'id' => $pdo->lastInsertId()]);
} catch (\PDOException $e) {
    http_response_code(500);
    echo json_encode(['mensagem' => 'Erro ao adicionar a música: ' . $e->getMessage()]);
}
?>