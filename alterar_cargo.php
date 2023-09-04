<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>alterar_cargo</title>
</head>
<body>
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $cargo_id = $_POST["cargo_id"];
            $nova_descricao = $_POST["nova_descricao"];

            $dbPath = 'C:\xampp\htdocs\projeto3ml\GerenciamentoFuncionarios.db';

            try {
                $db = new PDO("sqlite:$dbPath");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro ao conectar ao banco de dados: " . $e->getMessage());
            }

            $query = "UPDATE cargos SET descricao = :nova_descricao WHERE id = :cargo_id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':nova_descricao', $nova_descricao, PDO::PARAM_STR);
            $stmt->bindParam(':cargo_id', $cargo_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo "Cargo atualizado com sucesso!";
            } else {
                echo "Erro ao atualizar o cargo.";
            }

            $db = null;
        }
    ?>
</body>
</html>