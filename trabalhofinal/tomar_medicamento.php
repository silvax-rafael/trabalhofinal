<?php
session_start();

if (!isset($_SESSION['usuario_id']) || empty($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

date_default_timezone_set('America/Sao_Paulo');

$host = "localhost";
$username = "root";
$password = "";
$dbname = "controle_medicamento";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = intval($_POST['id']);
    $usuario_id = $_SESSION['usuario_id'];

    // Atualiza ultima_tomada para marcar como Tomado
    $sql = "UPDATE medicamentos SET ultima_tomada = NOW() WHERE id = ? AND usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id, $usuario_id);
    $stmt->execute();
    $stmt->close();
}

// Redireciona de volta para home
header("Location: home.php");
exit;
?>
