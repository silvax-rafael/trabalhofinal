<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: loginform.php");
    exit;
}

if(isset($_GET['id'])) {

    $id = intval($_GET['id']);
    $usuario_id = $_SESSION['usuario_id'];

    $conn = new mysqli("localhost", "root", "", "controle_medicamento");
    if ($conn->connect_error) die("Erro: " . $conn->connect_error);

    $stmt = $conn->prepare("DELETE FROM medicamentos WHERE id = ? AND usuario_id = ?");
    $stmt->bind_param("ii", $id, $usuario_id);
    $stmt->execute();
    $stmt->close();

    header("Location: home.php");
    exit;
}
?>
