<?php
session_start();

// Verifica login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: loginform.php");
    exit;
}

// Conexão com o banco
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "controle_medicamento";

$conn = new mysqli($host, $user, $pass, $dbname);

// Testa a conexão
if ($conn->connect_error) {
    die("Erro de conexão com o banco: " . $conn->connect_error);
}

// Se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_id = $_SESSION['usuario_id'];
    $nome = $_POST['nomedomedicamento'];
    $dose = $_POST['dose'];
    $horario = $_POST['horario'];

    $sql_insert = "INSERT INTO medicamentos (nome, dose, horario, usuario_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param("sssi", $nome, $dose, $horario, $usuario_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Medicamento cadastrado com sucesso!";
        header("Location: home.php");
        exit;
    } else {
        echo "Erro ao cadastrar medicamento: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

