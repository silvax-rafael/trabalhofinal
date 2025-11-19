<?php
session_start();

if (!isset($_SESSION['usuario_id']) || empty($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

date_default_timezone_set('America/Sao_Paulo');

$conn = new mysqli("localhost", "root", "", "controle_medicamento");
if ($conn->connect_error) die("Erro: " . $conn->connect_error);

if (!empty($_POST['id'])) {  // recebe o ID enviado pela home
    $medicamento_id = intval($_POST['id']); 
    $usuario_id = $_SESSION['usuario_id'];

    // Atualiza o campo ultima_tomada para marcar como TOMADO
    $stmt = $conn->prepare("
        UPDATE medicamentos 
        SET ultima_tomada = NOW() 
        WHERE medicamento_id = ? AND usuario_id = ?
    ");

    $stmt->bind_param("ii", $medicamento_id, $usuario_id);
    $stmt->execute();
    $stmt->close();
}

$conn->close();

header("Location: home.php");
exit;
?>
