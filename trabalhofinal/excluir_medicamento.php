<?php
if(isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $host = "localhost";
    $db   = "controle_medicamento";
    $user = "root";
    $pass = "";
    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) { die("Conexão falhou: " . $conn->connect_error); }

    $sql = "DELETE FROM medicamentos WHERE id = $id";
    $conn->query($sql);
    $conn->close();

    header("Location: home.php"); // volta para a home
    exit;
}
?>
