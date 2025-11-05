<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: loginform.php");
    exit;
}

if(isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $host = "localhost";
    $db   = "controle_medicamento";
    $user = "root";
    $pass = "";
    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) { die("Conexão falhou: " . $conn->connect_error); }

    $agora = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("UPDATE medicamentos 
                            SET status='Em dia', ultima_tomada=? 
                            WHERE id=? AND usuario_id=?");
    $stmt->bind_param("sii", $agora, $id, $_SESSION['usuario_id']);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    header("Location: home.php");
    exit;
}
?>
