<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>visualizar_funcionarios</title>
</head>
<body>
    <?php
        $dbPath = 'C:\xampp\htdocs\projeto3ml\GerenciamentoFuncionarios.db';

        try {
            $db = new PDO("sqlite:$dbPath");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro ao conectar ao banco de dados: " . $e->getMessage());
        }

        $query = "SELECT id, nome, sobrenome, data_nascimento, salario FROM funcionarios";
        $stmt = $db->query($query);
    ?>
</body>
</html>