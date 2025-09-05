<?php
// Configuração do banco
$host = "localhost";
$db   = "controle_medicamento";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST['nome']);
    $data = $_POST['data'];
    $usuario = trim($_POST['nomedeusuario']);
    $senha = $_POST['senha'];
    $confirmarsenha = $_POST['confirmarsenha'];

    // Valida senha
    if ($senha !== $confirmarsenha) {
        die("Erro: as senhas não coincidem. <a href='index.php'>Voltar</a>");
    }

    // Criptografa a senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Prepara inserção
    $stmt = $conn->prepare("INSERT INTO usuarios (nome, data_nascimento, usuario, senha) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nome, $data, $usuario, $senhaHash);

    if ($stmt->execute()) {
        // Cadastro OK -> redireciona para home
        header("Location: home.php");
        exit;
    } else {
        echo "Erro ao cadastrar: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
