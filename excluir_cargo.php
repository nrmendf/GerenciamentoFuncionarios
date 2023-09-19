<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["cargo_id"]) && !empty($_POST["cargo_id"])) {
        $cargo_id = $_POST["cargo_id"];

        // Verifique a confirmação
        if (isset($_POST["confirmacao"]) && $_POST["confirmacao"] == "on") {
            try {
                // Conexão com o banco de dados SQLite
                $dbPath = 'C:\xampp\htdocs\projeto3ml\GerenciamentoFuncionarios.db';
                $db = new PDO("sqlite:$dbPath");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Consulta para excluir o cargo
                $query = "DELETE FROM cargos WHERE id = :cargo_id";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':cargo_id', $cargo_id, PDO::PARAM_INT);
                
                // Execute a consulta de inserção
                if ($stmt->execute()) {
                    // Cargo excluido com sucesso
                    header("Location: index.php"); // Redireciona de volta para a página inicial
                    exit();
                } else {
                    echo "Erro ao excluir o cargo.";
                }

                    $db = null; // Fechar a conexão com o banco de dados
                } catch (PDOException $e) {
                    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
                }
                } else {
                    echo "Por favor, confirme a exclusão do cargo marcando a caixa de seleção de confirmação.";
                }
    } else {
        echo "ID do cargo não fornecido.";
    }
}
?>
