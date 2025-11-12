<?php
// 1. INICIA A SESSÃO NO TOPO
session_start();

// 2. VERIFICA SE O USUÁRIO ESTÁ LOGADO ANTES DE TUDO
if (!isset($_SESSION['usuario_id'])) {
    // Se não estiver logado, redireciona para o login.
    header("Location: loginform.php");
    exit;
}

// ... Código de Conexão com o Banco de Dados (se não estiver em um arquivo separado) ...

// O seu bloco POST:
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 3. RECUPERA O ID DO USUÁRIO DA SESSÃO
    $usuario_id = $_SESSION['usuario_id']; // <-- USE ESTA LINHA SIMPLES

    $nome    = $_POST['nomedomedicamento'];
    $dose    = $_POST['dose'];
    $horario = $_POST['horario'];

    // 4. CONSULTA SQL CORRIGIDA
    $sql_insert = "INSERT INTO medicamentos (nome, dose, horario, usuario_id) VALUES (?, ?, ?, ?)"; 
    $stmt = $conn->prepare($sql_insert);
    
    // 5. BIND PARAM (Se 'usuario_id' for INT)
    $stmt->bind_param("sssi", $nome, $dose, $horario, $usuario_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = 'Medicamento cadastrado com sucesso!';
        header("Location: home.php");
        exit;
    } else {
        $_SESSION['error_message'] = 'Erro ao cadastrar: ' . $stmt->error;
        header("Location: novomedicamento.php"); 
        exit;
    }

    $stmt->close();
}
// ... Restante do HTML do formulário de cadastro ...
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Controle de Medicação</title>
    <link rel="stylesheet" href="novomedicamento.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">
        <img src="fundo.png" alt="Logo">
        <h2>Cadastro de Medicamento</h2>

        <!-- Formulário que envia os dados para o PHP -->
        <form action="cadastro_medicamento.php" method="POST">
            <label>
                <input type="text" name="nomedomedicamento" placeholder="Nome do Medicamento" required>
            </label>

            <label>
                <input type="text" name="dose" placeholder="Dose (ex: 500 mg)" required>
            </label>

            <!-- datetime-local envia data + hora -->
            <label>
                <h6>Data e Hora que ira tomar o remedio</h6>
                <input type="datetime-local" name="horario" required>
            </label>

            <button type="submit">Cadastrar Medicamento</button>
        </form>
    </div>

</body>
</html>

