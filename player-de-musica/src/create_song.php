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
        try {
        // Comando SQL para inserir dados
        // Usamos '?' para preparar a query, prevenindo SQL Injection
        $sql = "INSERT INTO songs (titulo, artista, album, caminho_arquivo) VALUES (?, ?, ?, ?)";
        // Prepara a query para execução
        $stmt = $pdo->prepare($sql);
        // Executa a query com os valores do formulário
        $stmt->execute([
            $data['titulo'],
            $data['artista'],
            $data['album'] ?? null, // O álbum pode ser nulo
            $data['caminho_arquivo']
        ]);
        // Retorna uma resposta de sucesso
        echo json_encode(['mensagem' => 'Música adicionada com sucesso!', 'id' => $pdo->lastInsertId()]);
    } catch (\PDOException $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(['mensagem' => 'Erro ao adicionar a música: ' . $e->getMessage()]);
    }
?>