<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifique se o ID do funcionário foi enviado via POST
    if (isset($_POST["funcionario_id"]) && !empty($_POST["funcionario_id"])) {
        // Recupere o ID do funcionário da solicitação POST
        $funcionario_id = $_POST["funcionario_id"];

        // Recupere os dados atualizados do formulário
        $nome = $_POST["nome"];
        $sobrenome = $_POST["sobrenome"];
        $data_nascimento = $_POST["data_nascimento"];
        $salario = $_POST["salario"];
        $cargo_id = $_POST["cargo_id"];

        try {
            // Conexão com o banco de dados SQLite
            $dbPath = 'C:\xampp\htdocs\projeto3ml\GerenciamentoFuncionarios.db';
            $db = new PDO("sqlite:$dbPath");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Execute uma consulta para atualizar os dados do funcionário
            $query = "UPDATE funcionarios SET nome = :nome, sobrenome = :sobrenome, data_nascimento = :data_nascimento, salario = :salario, cargo_id = :cargo_id WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':sobrenome', $sobrenome, PDO::PARAM_STR);
            $stmt->bindParam(':data_nascimento', $data_nascimento, PDO::PARAM_STR);
            $stmt->bindParam(':salario', $salario, PDO::PARAM_STR);
            $stmt->bindParam(':cargo_id', $cargo_id, PDO::PARAM_INT);
            $stmt->bindParam(':id', $funcionario_id, PDO::PARAM_INT);

            // Verifique se a atualização foi bem-sucedida
            if ($stmt->execute()) {
                // Atualização bem-sucedida, defina a mensagem de sucesso em uma variável de sessão
                session_start();
                $_SESSION['success_message'] = "Funcionário editado com sucesso";

                // Redirecione de volta para a página de edição
                header("Location: processar_edicao_funcionario.php");
                exit();
            } else {
                // Erro na atualização
                echo "Erro ao atualizar o funcionário.";
            }
        } catch (PDOException $e) {
            die("Erro ao conectar ao banco de dados: " . $e->getMessage());
        }
    } else {
        echo "ID do funcionário não fornecido.";
    }
}
?>

