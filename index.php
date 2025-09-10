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




if ($_SERVER['REQUEST_METHOD'] ==
 'POST') {
    $nome = $_POST['nome'];
    $data_nascimento = $_POST['data_nascimento'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    // Validação simples
    if ($senha !== $confirmar_senha) {
        echo "As senhas não coincidem!";
        exit;
    }

    // Hash da senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Inserir no banco
    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, data_nascimento, email, senha) 
                               VALUES ( ?, ?, ?, ?)");
        $stmt->execute([$nome, $data_nascimento, $email, $senhaHash]);
        echo "Usuário cadastrado com sucesso! <a href='login.php'>Fazer login</a>";
        header("Location: trabalhofinal/login.php");
    } catch (PDOException $e) {
        echo "Erro ao cadastrar: " . $e->getMessage();
    }
}
?>








<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="index.css">
  <title>Sistema de Controle de Medicação - Cadastro</title>
</head>
<body>

  <!-- Cabeçalho -->
  <header>
    <img src="trabalhofinal/fundo.png" alt="Logo do Sistema" class="img">
    <h1 class="titulo">Sistema de Controle de Medicação</h1>
  </header>

  <!-- Cadastro -->
  <main>
    <h2 class="titulo2">Cadastro</h2>
    <form class="box" method="POST">

      <label>
        <input type="text" name="nome" placeholder="NOME" required>
      </label>

      <label>
        <input type="date" name="data_nascimento" required>
      </label>

      <label>
        <input type="email" name="email" placeholder="EMAIL" required>
      </label>

      <label>
        <input type="password" name="senha" placeholder="SENHA" required>
      </label>

      <label>
        <input type="password" name="confirmar_senha" placeholder="CONFIRMAR SENHA" required>
      </label>

      <button type="submit" >ENVIAR</button>

      <button type="button" onclick="window.location.href='trabalhofinal/login.php'">Ja tenho uma conta</button>

    </form>
  </main>

</body>
</html>
