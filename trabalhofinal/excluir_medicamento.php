<?php
session_start();

// --- checagem de login ---
if (!isset($_SESSION['usuario_id']) || empty($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

date_default_timezone_set('America/Sao_Paulo');

// --- pegar ID vindo do formulário (suporta GET ou POST, campos 'id' ou 'medicamento_id') ---
$input_id = null;
if (!empty($_GET['id'])) {
    $input_id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
} elseif (!empty($_GET['medicamento_id'])) {
    $input_id = filter_var($_GET['medicamento_id'], FILTER_VALIDATE_INT);
} elseif (!empty($_POST['id'])) {
    $input_id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
} elseif (!empty($_POST['medicamento_id'])) {
    $input_id = filter_var($_POST['medicamento_id'], FILTER_VALIDATE_INT);
}

if ($input_id === false || $input_id === null) {
    // mensagem amigável (pode personalizar)
    die("<p style='color:red; text-align:center;'>Erro: ID do medicamento não informado ou inválido.</p>");
}


$medicamento_id = intval($input_id);
$usuario_id = intval($_SESSION['usuario_id']);

// --- conexão ---
$host = "localhost";
$user = "root";
$pass = "";
$db   = "controle_medicamento";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("<p style='color:red; text-align:center;'>Erro na conexão com o banco: " . htmlspecialchars($conn->connect_error) . "</p>");
}

// --- detectar qual coluna de ID a tabela usa: 'medicamento_id' ou 'id' ---
$id_col = null;
$res = $conn->query("SHOW COLUMNS FROM medicamentos LIKE 'medicamento_id'");
if ($res && $res->num_rows > 0) {
    $id_col = 'medicamento_id';
} else {
    // se não existe 'medicamento_id', verifica 'id'
    $res2 = $conn->query("SHOW COLUMNS FROM medicamentos LIKE 'id'");
    if ($res2 && $res2->num_rows > 0) {
        $id_col = 'id';
    } else {
        // fallback: não encontrou coluna de id conhecida
        $conn->close();
        die("<p style='color:red; text-align:center;'>Erro: coluna de identificação do medicamento não encontrada na tabela (procurado 'medicamento_id' ou 'id').</p>");
    }
}

// --- Preparar e executar exclusão somente se o medicamento pertencer ao usuário ---
$sql = "DELETE FROM medicamentos WHERE {$id_col} = ? AND usuario_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    $err = $conn->error;
    $conn->close();
    die("<p style='color:red; text-align:center;'>Erro ao preparar a query: " . htmlspecialchars($err) . "</p>");
}

$stmt->bind_param("ii", $medicamento_id, $usuario_id);

if (!$stmt->execute()) {
    $err = $stmt->error;
    $stmt->close();
    $conn->close();
    die("<p style='color:red; text-align:center;'>Erro ao excluir medicamento: " . htmlspecialchars($err) . "</p>");
}

$affected = $stmt->affected_rows;
$stmt->close();
$conn->close();

if ($affected > 0) {
    // sucesso — redireciona para home (pode adicionar ?msg=ok se quiser)
    header("Location: home.php");
    exit;
} else {
    // nada foi excluído — ou não existe, ou não pertence ao usuário
    die("<p style='color:red; text-align:center;'>Operação não efetuada: medicamento não encontrado ou não pertence a você.</p>");
}
