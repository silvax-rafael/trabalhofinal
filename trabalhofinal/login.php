<?php
$host = 'localhost';
$db = 'controle_medicamento';
$user = 'root';
$pass = ''; // altere se necessário

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
session_start();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Buscar usuário
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario'] = $usuario['nome'];
        header('Location: home.php');
        exit;
    } else {
        echo "Email ou senha incorretos!";
    }
}
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema de Controle de Medicação - Login</title>
<link rel="stylesheet" href="login.css">

</head>
<body>
  <div class="container">
    <img class="img" src="fundo.png" alt="Fundo do sistema">  

    <div class="box">
      <h2 class="titulo2">Login</h2>

    <form method="POST">
    Email: <input type="email" name="email" required><br><br>
    Senha: <input type="password" name="senha" required><br><br>
    <button type="submit">Entrar</button>
    </form>

      <a href="../index.php">Criar nova conta</a>
    </div>
  </div>
</body>
</html>
