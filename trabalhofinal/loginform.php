<?php
session_start();

// Se já estiver logado, redireciona para home
if (isset($_SESSION['usuario_id'])) {
    header("Location: home.php");
    exit;
}

// Conexão com banco
$conn = new mysqli("localhost", "root", "", "controle_medicamento");
if ($conn->connect_error) { die("Erro de conexão: " . $conn->connect_error); }

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['nomedeusuario'];
    $senha   = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE usuario='$usuario' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['usuario_nome'] = $user['nome'];
            header("Location: home.php");
            exit;
        } else {
            $erro = "Senha incorreta!";
        }
    } else {
        $erro = "Usuário não encontrado!";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Sistema de Controle de Medicação</title>
<link rel="stylesheet" href="login.css">
</head>
<body>
<div class="container">
    <img class="img" src="fundo.png" alt="Logo">
    <div class="box">
        <h2 class="titulo2">Login</h2>
        <?php if($erro) echo "<p style='color:red;'>$erro</p>"; ?>
        <form method="POST" action="">
            <label><input type="text" name="nomedeusuario" placeholder="NOME DE USUÁRIO" required></label>
            <label><input type="password" name="senha" placeholder="SENHA" required></label>
            <button type="submit">ENTRAR</button>
        </form>
        <a href="index.php">Criar nova conta</a>
    </div>
</div>
</body>
</html>
