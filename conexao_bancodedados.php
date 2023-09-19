<?php
// Caminho para o arquivo do banco de dados SQLite
$dbPath = 'C:\xampp\htdocs\projeto3ml\GerenciamentoFuncionarios.db';

try {
    // Crie uma nova conexão com o banco de dados SQLite
    $db = new PDO("sqlite:$dbPath");

    // Configure o modo de erro para lançar exceções em caso de erros
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Em caso de erro na conexão, exiba uma mensagem de erro e encerre o script
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>