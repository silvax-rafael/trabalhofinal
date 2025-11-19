<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// Verifica se recebeu o ID correto
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("<p style='color:red; text-align:center;'>Erro: ID do medicamento não informado.</p>");
}

$medicamento_id = intval($_GET['id']);
$usuario_id = $_SESSION['usuario_id'];

// Conexão com o banco
$conn = new mysqli("localhost", "root", "", "controle_medicamento");
if ($conn->connect_error) die("Erro: " . $conn->connect_error);

// Exclui SOMENTE se o medicamento pertence ao usuário logado
$stmt = $conn->prepare("DELETE FROM medicamentos WHERE medicamento_id = ? AND usuario_id = ?");
$stmt->bind_param("ii", $medicamento_id, $usuario_id);
$stmt->execute();
$stmt->close();

$conn->close();

header("Location: home.php");
exit;
?>
