<?php
session_start();

if (!isset($_SESSION['usuario_id']) || empty($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

date_default_timezone_set('America/Sao_Paulo');

$conn = new mysqli("localhost", "root", "", "controle_medicamento");
if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

// Checa se foi enviado via POST e se o id existe
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
    $medicamento_id = intval($_POST['id']);
    $usuario_id = intval($_SESSION['usuario_id']);

    // Atualiza ultima_tomada = NOW() para o medicamento do usuário
    $sql = "UPDATE medicamentos SET ultima_tomada = NOW() WHERE id = ? AND usuario_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        // debug útil se prepare falhar
        die("Prepare falhou: (" . $conn->errno . ") " . $conn->error);
    }
    $stmt->bind_param("ii", $medicamento_id, $usuario_id);
    $stmt->execute();

    // Opcional: checar linhas afetadas pra confirmar atualização
    if ($stmt->affected_rows > 0) {
        // sucesso
    } else {
        // não atualizou: pode ser que o id não pertença ao usuário ou já esteja marcado
        // você pode gravar um log ou uma mensagem de erro aqui se quiser
    }

    $stmt->close();
}

$conn->close();
// Volta pra home
header("Location: home.php");
exit;
?>
