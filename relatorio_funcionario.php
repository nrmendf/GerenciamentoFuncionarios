<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>relatorio_funcionario</title>
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

        $query = "SELECT nome, sobrenome, data_nascimento, salario FROM funcionarios";
        $stmt = $db->query($query);

            while ($funcionario = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $funcionario['nome'] . "</td>";
                echo "<td>" . $funcionario['sobrenome'] . "</td>";
                echo "<td>" . $funcionario['data_nascimento'] . "</td>";
                echo "<td>" . $funcionario['salario'] . "</td>";

                $mesAtual = date('m');
                $dataNascimentoMes = date('m', strtotime($funcionario['data_nascimento']));
                
                echo "<td>";
                if ($mesAtual == $dataNascimentoMes) {
                    echo "PARABÉNS!";
                }
                echo "</td>";
                
                echo "</tr>";
            }

        $db = null;
    ?>

</body>
</html>