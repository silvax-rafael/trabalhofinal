<?php
// Conexão com o banco
$conn = new mysqli("localhost", "root", "", "controle_medicamento");
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $data_nascimento = $_POST['data_nascimento'];
    $senha = $_POST['senha'];
    $confirmar = $_POST['confirmarsenha'];

    // Verifica se as senhas coincidem
    if ($senha !== $confirmar) {
        $erro = "As senhas não conferem!";
    } else {
        // Verifica se já existe um usuário com este e-mail
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $erro = "Já existe uma conta com este e-mail!";
        } else {
            // Cria o hash da senha
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

            // Insere o novo usuário
            $stmt = $conn->prepare("INSERT INTO users (nome, email, data_nascimento, senha) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nome, $email, $data_nascimento, $senha_hash);

            if ($stmt->execute()) {
                // Redireciona após cadastro bem-sucedido
                header("Location: loginform.php");
                exit;
            } else {
                $erro = "Erro ao cadastrar: " . $stmt->error;
            }
        }
        $stmt->close();
    }
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- truque do cache busting -->
  <link rel="stylesheet" href="index.css?v=<?php echo time(); ?>">
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

      <?php if ($erro): ?>
      <p style="color:red;"><?= htmlspecialchars($erro) ?></p>
  <?php endif; ?>
  
    <form class="box" method="POST">

      <label>
        <input type="text" name="nome" placeholder="NOME" required>
      </label>
h
      
      <label>
        <input type="email" name="email" placeholder="EMAIL" required>
      </label>

      <label>
        <input type="date" name="data_nascimento" required>
      </label>

      <label>
        <input type="password" name="senha" placeholder="SENHA" required>
      </label>

      <label>
        <input type="password" name="confirmarsenha" placeholder="CONFIRME A SENHA" required>
      </label>


      <button type="submit">ENVIAR</button>
      <a href="trabalhofinal/loginform.php">Já tenho uma conta</a>
    </form>
  </main>

</body>
</html>
