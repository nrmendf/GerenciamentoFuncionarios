<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>processar_cadastro_cargo</title>
</head>
<body>
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $descricao = $_POST["descricao"];

            $dbPath = 'C:\xampp\htdocs\projeto3ml\GerenciamentoFuncionarios.db';

            try {
                $db = new PDO("sqlite:$dbPath");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro ao conectar ao banco de dados: " . $e->getMessage());
            }

            $query = "INSERT INTO cargos (descricao) VALUES (:descricao)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);

            if ($stmt->execute()) {
                echo "Cargo cadastrado com sucesso!";
            } else {
                echo "Erro ao cadastrar o cargo.";
            }

            $db = null;
        }
    ?>
</body>
</html>
