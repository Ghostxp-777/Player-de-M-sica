<?php
    // Inclui o arquivo de conexão com o banco de dados
    require_once('../config/database.php');
    // Define o cabeçalho para indicar que a resposta será em JSON
    header('Content-Type: application/json');
    try {
        // Comando SQL para selecionar todas as músicas
        $sql = "SELECT id, titulo, artista, album, caminho_arquivo FROM songs ORDER BY data_adicao DESC";
        // Executa a query e pega todos os resultados
        $stmt = $pdo->query($sql);
        $songs = $stmt->fetchAll();
        // Retorna a lista de músicas em formato JSON
        echo json_encode(['status' => 'sucesso', 'data' => $songs]);
    } catch (\PDOException $e) {
        http_response_code(500);
        echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao listar as músicas: ' . $e->getMessage()]);
    }
?>
