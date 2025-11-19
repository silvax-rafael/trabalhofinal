<?php
// 1️⃣ INICIA A SESSÃO NO TOPO
session_start();

// 2️⃣ VERIFICA SE O USUÁRIO ESTÁ LOGADO
if (!isset($_SESSION['usuario_id'])) {
    header("Location: loginform.php");
    exit;
}

// 3️⃣ CONEXÃO COM O BANCO DE DADOS
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "controle_medicamento";

$conn = new mysqli($host, $user, $pass, $dbname);

// Verifica erro na conexão
if ($conn->connect_error) {
    die("ERRO DE CONEXÃO: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_id = $_SESSION['usuario_id'];
    $nome    = $_POST['nomedomedicamento'];
    $dose    = $_POST['dose'];
    $horario = $_POST['horario'];

    $sql_insert = "INSERT INTO medicamentos (nome, dose, horario, usuario_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_insert);

    if ($stmt === false) {
        die("Erro ao preparar SQL: " . $conn->error);
    }

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

$conn->close();
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
        <form action="novomedicamento.php" method="POST">
            <label>
                <input type="text" name="nomedomedicamento" placeholder="Nome do Medicamento" required>
            </label>

            <label>
                <input type="text" name="dose" placeholder="Dose (ex: 500 mg)" required>
            </label>

            <!-- datetime-local envia data + hora -->
            <label>
                <h6>Data e Hora que irá tomar o remédio</h6>
                <input type="datetime-local" name="horario" required>
            </label>

            <button type="submit">Cadastrar Medicamento</button>
        </form>
    </div>

</body>
</html>
