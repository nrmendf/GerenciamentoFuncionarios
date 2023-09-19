<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifique se a descrição do cargo foi enviada via POST
    if (isset($_POST["descricao"]) && !empty($_POST["descricao"])) {
        // Recupere a descrição do cargo da solicitação POST
        $descricao = $_POST["descricao"];

        try {
            // Conexão com o banco de dados SQLite
            $dbPath = 'C:\xampp\htdocs\projeto3ml\GerenciamentoFuncionarios.db';
            $db = new PDO("sqlite:$dbPath");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare a consulta de inserção
            $query = "INSERT INTO cargos (descricao) VALUES (:descricao)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);

            // Execute a consulta de inserção
            if ($stmt->execute()) {
            // Cargo cadastrado com sucesso
            header("Location: index.php"); // Redireciona de volta para a página inicial
            exit();
            } else {
                echo "Erro ao cadastrar o cargo.";
            }

            $db = null; // Fechar a conexão com o banco de dados
        } catch (PDOException $e) {
            die("Erro ao conectar ao banco de dados: " . $e->getMessage());
        }
    } else {
        echo "Descrição do cargo não fornecida.";
    }
}
?>
