<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>processar_cadastro_funcionario</title>
</head>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST["nome"];
        $sobrenome = $_POST["sobrenome"];
        $data_nascimento = $_POST["data_nascimento"];
        $salario = $_POST["salario"];
        $cargo_id = $_POST["cargo_id"];

        try {
            $dbPath = 'C:\xampp\htdocs\projeto3ml\GerenciamentoFuncionarios.db';
            $db = new PDO("sqlite:$dbPath");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT descricao FROM cargos WHERE id = :cargo_id";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':cargo_id', $cargo_id, PDO::PARAM_INT);
            $stmt->execute();
            $cargo = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($cargo) {
                $insertQuery = "INSERT INTO funcionarios (nome, sobrenome, cargo_id, data_nascimento, salario) 
                                VALUES (:nome, :sobrenome, :cargo_id, :data_nascimento, :salario)";
                $insertStmt = $db->prepare($insertQuery);
                $insertStmt->bindValue(':nome', $nome, PDO::PARAM_STR);
                $insertStmt->bindValue(':sobrenome', $sobrenome, PDO::PARAM_STR);
                $insertStmt->bindValue(':cargo_id', $cargo_id, PDO::PARAM_INT);
                $insertStmt->bindValue(':data_nascimento', $data_nascimento, PDO::PARAM_STR);
                $insertStmt->bindValue(':salario', $salario, PDO::PARAM_STR);

                if ($insertStmt->execute()) {
                    // Funcionário cadastrado com sucesso
                    header("Location: index.php"); // Redireciona de volta para a página inicial
                    exit();
                } else {
                    echo "Erro ao cadastrar o funcionário.";
                }
            } else {
                echo "Cargo não encontrado.";
            }

            $db = null;
        } catch (PDOException $e) {
            die("Erro ao conectar ao banco de dados: " . $e->getMessage());
        }
    }
    ?>
</body>
</html>
