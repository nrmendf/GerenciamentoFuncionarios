<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifique se o ID do funcionário foi enviado via POST
    if (isset($_POST["funcionario_id"]) && !empty($_POST["funcionario_id"])) {
        // Verifique se a caixa de confirmação foi marcada
        if (isset($_POST["confirmacao"]) && $_POST["confirmacao"] === "on") {
            // Recupere o ID do funcionário da solicitação POST
            $funcionario_id = $_POST["funcionario_id"];

            try {
                // Conexão com o banco de dados SQLite
                $dbPath = 'C:\xampp\htdocs\projeto3ml\GerenciamentoFuncionarios.db';
                $db = new PDO("sqlite:$dbPath");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Execute a exclusão do funcionário
                $query = "DELETE FROM funcionarios WHERE id = :id";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':id', $funcionario_id, PDO::PARAM_INT);
                
                
                // Execute a consulta de inserção
                if ($stmt->execute()) {
                // Cargo cadastrado com sucesso
                header("Location: index.php"); // Redireciona de volta para a página inicial
                exit();
                } else {
                    echo "Erro ao excluir funcioário.";
                }

                // Feche a conexão com o banco de dados
                $db = null;
            } catch (PDOException $e) {
                die("Erro ao conectar ao banco de dados: " . $e->getMessage());
            }
        } else {
            echo "Confirmação não marcada. O funcionário não foi excluído.";
        }
    } else {
        echo "ID do funcionário não fornecido.";
    }
}
?>
