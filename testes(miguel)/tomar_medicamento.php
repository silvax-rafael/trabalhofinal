<?php
if(isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $host = "localhost";
    $db   = "controle_medicamento";
    $user = "root";
    $pass = "";
    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) { die("Conexão falhou: " . $conn->connect_error); }

    // Atualiza o status e registra a hora atual
    $agora = date('Y-m-d H:i:s');
    $sql = "UPDATE medicamentos SET status='Em dia', ultima_tomada='$agora' WHERE id = $id";
    $conn->query($sql);
    $conn->close();

    header("Location: home.php");
    exit;
}
?>
