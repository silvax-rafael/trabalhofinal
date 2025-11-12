<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: loginform.php");
    exit;
}

if(isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $host = "localhost";
    $db   = "controle_medicamento";
    $user = "root";
    $pass = "";
    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) { die("Conexão falhou: " . $conn->connect_error); }

    $stmt = $conn->prepare("DELETE FROM medicamentos WHERE id=? AND id=?");
    $stmt->bind_param("ii", $id, $_SESSION['usuario_id']);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: home.php");
    exit;
}
?>
