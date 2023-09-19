<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gerenciamento de Funcionários</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<div class="container mb-3 screen-login">
    <h1>Cadastro de Funcionários</h1>
    <form action="processar_cadastro_funcionario.php" method="POST">
        Nome: <input type="text" name="nome" required><br>
        Sobrenome: <input type="text" name="sobrenome" required><br>
        Data de Nascimento: <input type="date" name="data_nascimento" required><br>
        Salário: <input type="text" name="salario" required><br>
        Cargo:
        <select name="cargo_id" required>
            <option value="">Selecione um cargo</option>
            <?php
            try {
                // Conexão com o banco de dados SQLite
                $dbPath = 'C:\xampp\htdocs\projeto3ml\GerenciamentoFuncionarios.db';
                $db = new PDO("sqlite:$dbPath");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Consulta para obter a lista de cargos
                $query = "SELECT id, descricao FROM cargos";
                $stmt = $db->query($query);

                while ($cargo = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $cargo['id'] . '">' . $cargo['descricao'] . '</option>';
                }

                $db = null; // Fechar a conexão com o banco de dados
            } catch (PDOException $e) {
                die("Erro ao conectar ao banco de dados: " . $e->getMessage());
            }
            ?>
        </select><br>
        <input type="submit" value="Inserir">
    </form>

    <h1></h1>
    <form action="alterar_funcionario.php" method="POST">
        Funcionário a ser editado:
        <select name="funcionario_id" required>
            <option value="">Selecione um funcionário</option>
            <?php
            // Conexão com o banco de dados SQLite (altere o caminho conforme necessário)
            $dbPath = 'C:\xampp\htdocs\projeto3ml\GerenciamentoFuncionarios.db';
            try {
                $db = new PDO("sqlite:$dbPath");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro ao conectar ao banco de dados: " . $e->getMessage());
            }
            // Consulta para obter a lista de funcionários
            $query = "SELECT id, nome, sobrenome FROM funcionarios";
            $stmt = $db->query($query);
            while ($funcionario = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value=" . $funcionario['id'] . ">" . $funcionario['nome'] . " " . $funcionario['sobrenome'] . "</option>";
            }
            $db = null; // Fechar a conexão com o banco de dados
            ?>
        </select>
        <input type="submit" value="Editar Funcionário">
    </form>

    <h1></h1>
    <form action="excluir_funcionario.php" method="POST">
        Funcionário a ser excluído:
        <select name="funcionario_id" required>
            <option value="">Selecione um funcionário</option>
            <?php
            // Conexão com o banco de dados SQLite (altere o caminho conforme necessário)
            $dbPath = 'C:\xampp\htdocs\projeto3ml\GerenciamentoFuncionarios.db';
            try {
                $db = new PDO("sqlite:$dbPath");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro ao conectar ao banco de dados: " . $e->getMessage());
            }
            // Consulta para obter a lista de funcionários
            $query = "SELECT id, nome, sobrenome FROM funcionarios";
            $stmt = $db->query($query);
            while ($funcionario = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value=" . $funcionario['id'] . ">" . $funcionario['nome'] . " " . $funcionario['sobrenome'] . "</option>";
            }
            $db = null; // Fechar a conexão com o banco de dados
            ?>
        </select>
        <label for="confirmacao">Confirmação: </label>
        <input type="checkbox" id="confirmacao" name="confirmacao" required>
        <input type="submit" value="Excluir Funcionário">
    </form>

    <h1>Relatório de Funcionários</h1>

    <button id="btnVisualizar">Visualizar Relatório</button>
    <button id="btnAtualizarTabela" onclick="location.reload();">Atualizar Tabela</button> <!-- Botão para atualizar a tabela -->

    <div id="tabelaContainer" style="display: none;">
        <table border="1">
            <tr>
                <th>Nome</th>
                <th>Sobrenome</th>
                <th>Data de Nascimento</th>
                <th>Salário</th>
                <th>Mensagem</th>
            </tr>
            <?php
                require_once('conexao_bancodedados.php'); // Inclui o arquivo de conexão

                // Caminho para o arquivo do banco de dados SQLite
                $dbPath = 'C:\xampp\htdocs\projeto3ml\GerenciamentoFuncionarios.db';

                try {
                    // Conexão com o banco de dados SQLite
                    $db = new PDO("sqlite:$dbPath");
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    } catch (PDOException $e) {
                    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
                }

                // Agora você pode executar consultas no banco de dados
                $query = "SELECT id, nome, sobrenome, data_nascimento, salario FROM funcionarios";
                $stmt = $db->query($query);

                while ($funcionario = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $funcionario['nome'] . "</td>";
                    echo "<td>" . $funcionario['sobrenome'] . "</td>";
                    echo "<td>" . $funcionario['data_nascimento'] . "</td>";
                    echo "<td>" . $funcionario['salario'] . "</td>";

                    // Verifique o mês de aniversário
                    $dataNascimento = new DateTime($funcionario['data_nascimento']);
                    $mesAniversario = $dataNascimento->format('m');
                    $mesAtual = date('m');

                    // Exiba a mensagem de "Parabéns" se for o mês de aniversário
                    if ($mesAniversario == $mesAtual) {
                        echo "<td>Parabéns por mais um ano de vida. Tenhas um dia repleto de felicidades.</td>";
                    } else {
                        echo "<td></td>"; // Deixe a célula em branco se não for o mês de aniversário
                    }

                    echo "</tr>";
                }
            ?>
        </table>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const btnVisualizar = document.getElementById("btnVisualizar");
            const tabelaContainer = document.getElementById("tabelaContainer");
            btnVisualizar.addEventListener("click", function () {
                tabelaContainer.style.display = "block";
                btnVisualizar.style.display = "none";
            });
        });
    </script>
</div>

<div class="container mb-3 screen-login">
    <h1>Cadastro de Cargos</h1>
    <form action="processar_cadastro_cargo.php" method="POST">
        Descrição do Cargo: <input type="text" name="descricao" required>
        <input type="submit" value="Inserir / Cadastrar">
    </form>

    <h1></h1>
    <form action="alterar_cargo.php" method="POST">
        Cargo a ser editado:
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
                    echo '<option value="' . $cargo['id'] . '">' . $cargo['descricao'] . '</option>';
                }

                $db = null; // Fechar a conexão com o banco de dados
            } catch (PDOException $e) {
                die("Erro ao conectar ao banco de dados: " . $e->getMessage());
            }
            ?>
        </select>
        Nova Descrição: <input type="text" name="nova_descricao" required>
        <input type="submit" value="Editar Cargo">
        
    </form>

    <h1></h1>
    <form action="excluir_cargo.php" method="POST">
        Cargo a ser excluído:
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
                    echo '<option value="' . $cargo['id'] . '">' . $cargo['descricao'] . '</option>';
                }

                $db = null; // Fechar a conexão com o banco de dados
            } catch (PDOException $e) {
                die("Erro ao conectar ao banco de dados: " . $e->getMessage());
            }
            ?>
        </select>
        <label for="confirmacao">Confirmação: </label>
        <input type="checkbox" id="confirmacao" name="confirmacao" required>
        <input type="submit" value="Excluir Cargo">
    </form>
</div>
