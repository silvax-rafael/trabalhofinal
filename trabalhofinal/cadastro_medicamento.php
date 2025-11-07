<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: loginform.php");
    exit;
}

// Configurações do banco de dados
$host = "localhost";
$db   = "controle_medicamento";
$user = "root";
$pass = "";

// Conexão
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome   = $_POST['nomedomedicamento'];
    $dose   = $_POST['dose'];
    $horario = $_POST['horario'];
    $usuario_id = $_SESSION['id'];

    // Insere medicamento vinculado ao usuário
    $stmt = $conn->prepare("INSERT INTO medicamentos (nome, dose, horario, id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $nome, $dose, $horario, $usuario_id);

    if ($stmt->execute()) {
        echo "<script>alert('Medicamento cadastrado com sucesso!'); window.location.href='home.php';</script>";
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
