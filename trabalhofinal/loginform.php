<?php
session_start();

// Se já estiver logado, redireciona para home
if (isset($_SESSION['usuario_id'])) {
    header("Location: home.php");
    exit;
}

// Conexão com banco
$conn = new mysqli("localhost", "root", "", "controle_medicamento");
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Usa prepared statement para evitar SQL injection
    $stmt = $conn->prepare("SELECT id, nome, email, senha FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifica senha
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

    $stmt->close();
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
            <label><input type="text" name="email" placeholder="EMAIL" required></label>
            <label><input type="password" name="senha" placeholder="SENHA" required></label>
            <button type="submit">ENTRAR</button>
        </form>
        <a href="../index.php">Criar nova conta</a>
    </div>
</div>
</body>
</html>
