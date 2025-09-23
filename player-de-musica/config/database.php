<?php
// Arquivo de conexão com o banco de dados.
    // Configurações de conexão
    $host = 'localhost';
    $db = 'music_player';
    $user = 'root'; // O usuário do seu banco de dados (geralmente 'root')
    $pass = ''; // A senha do seu banco de dados (geralmente vazio)
    $charset = 'utf8mb4';
    // Data Source Name (DSN)
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        // Opções de configuração do PDO
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    try {
        // Cria uma nova instância do PDO para a conexão
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
    // Se a conexão falhar, exibe uma mensagem de erro
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>