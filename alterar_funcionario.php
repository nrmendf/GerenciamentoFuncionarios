<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifique se o ID do funcionário foi enviado via POST
    if (isset($_POST["funcionario_id"]) && !empty($_POST["funcionario_id"])) {
        // Recupere o ID do funcionário da solicitação POST
        $funcionario_id = $_POST["funcionario_id"];

        try {
            // Conexão com o banco de dados SQLite
            $dbPath = 'C:\xampp\htdocs\projeto3ml\GerenciamentoFuncionarios.db';
            $db = new PDO("sqlite:$dbPath");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Execute uma consulta para obter os detalhes do funcionário
            $query = "SELECT * FROM funcionarios WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $funcionario_id, PDO::PARAM_INT);
            $stmt->execute();

            $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($funcionario) {
                // Os detalhes do funcionário foram recuperados com sucesso
                // Agora você pode preencher o formulário de edição com os dados do funcionário
                $nome = $funcionario['nome'];
                $sobrenome = $funcionario['sobrenome'];
                $data_nascimento = $funcionario['data_nascimento'];
                $salario = $funcionario['salario'];
                $cargo_id = $funcionario['cargo_id'];

                // Feche a conexão com o banco de dados
                $db = null;
            } else {
                // Funcionário não encontrado
                echo "Funcionário não encontrado.";
            }
        } catch (PDOException $e) {
            die("Erro ao conectar ao banco de dados: " . $e->getMessage());
        }
    } else {
        echo "ID do funcionário não fornecido.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Funcionário</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container mb-3 screen-login">
    <h1>Editar Funcionário</h1>
    <form action="processar_atualizacao_funcionario.php" method="POST">
        <input type="hidden" name="funcionario_id" value="<?php echo $funcionario_id; ?>">
        Nome: <input type="text" name="nome" value="<?php echo $nome; ?>" required><br>
        Sobrenome: <input type="text" name="sobrenome" value="<?php echo $sobrenome; ?>" required><br>
        Data de Nascimento: <input type="date" name="data_nascimento" value="<?php echo $data_nascimento; ?>" required><br>
        Salário: <input type="text" name="salario" value="<?php echo $salario; ?>" required><br>
        Cargo:
        <select name="cargo_id" required>
            <option value="">Selecione um cargo</option>
            <?php
            // Conexão com o banco de dados SQLite (altere o caminho conforme necessário)
            $dbPath = 'C:\xampp\htdocs\projeto3ml\GerenciamentoFuncionarios.db';
            try {
                $db = new PDO("sqlite:$dbPath");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Consulta para obter a lista de cargos
                $query = "SELECT id, descricao FROM cargos";
                $stmt = $db->query($query);

                while ($cargo = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $selected = ($cargo_id == $cargo['id']) ? "selected" : "";
                    echo '<option value="' . $cargo['id'] . '" ' . $selected . '>' . $cargo['descricao'] . '</option>';
                }

                $db = null; // Fechar a conexão com o banco de dados
            } catch (PDOException $e) {
                die("Erro ao conectar ao banco de dados: " . $e->getMessage());
            }
            ?>
        </select><br>
        <input type="submit" value="Atualizar">
    </form>
</div>
</body>
</html>
