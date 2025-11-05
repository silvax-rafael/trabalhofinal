<?php
// Conexão com o banco
$conn = new mysqli("localhost", "root", "", "controle_medicamento");
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome      = $_POST['nome'];
    $data      = $_POST['data']; // data de nascimento
    $usuario   = $_POST['nomedeusuario'];
    $senha     = $_POST['senha'];
    $confirma  = $_POST['confirmarsenha'];

    if ($senha !== $confirma) {
        die("As senhas não conferem!");
    }

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Usando prepared statement
    $stmt = $conn->prepare("INSERT INTO usuarios (nome, data_nascimento, usuario, senha) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nome, $data, $usuario, $senha_hash);

    if ($stmt->execute()) {
        // Cadastro realizado → redireciona para loginform.php
        header("Location: loginform.php");
        exit;
    } else {
        echo "Erro ao cadastrar: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
