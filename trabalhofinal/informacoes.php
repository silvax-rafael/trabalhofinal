<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: loginform.php");
    exit;
}

$host = "localhost";
$db   = "controle_medicamento";
$user = "root";
$pass = "";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) { die("Conexão falhou: " . $conn->connect_error); }

$usuario_id = $_SESSION['usuario_id'];
$stmt = $conn->prepare("SELECT nome, data_nascimento, email FROM users WHERE id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
$conn->close();

// Calcula idade
$idade = '';
if (!empty($usuario['data_nascimento'])) {
    $data_nascimento = new DateTime($usuario['data_nascimento']);
    $hoje = new DateTime();
    $idade = $hoje->diff($data_nascimento)->y;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Informações Pessoais</title>
<link rel="stylesheet" href="informacoes.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<aside class="sidebar">
  <img src="fundo.png" alt="Logo Sistema">
  <nav class="menu">
    <a href="home.php">🏠 HOME</a>
    <a href="informacoes.php" class="active">👤 INFORMAÇÕES PESSOAIS</a>
    <a href="relatorio.php">📊 RELATÓRIO</a>
    <a href="sobre.php">ℹ️ SOBRE</a>
    <form action="logout.php" method="POST">
      <button type="submit" class="btn-sair">Sair</button>
    </form>
  </nav>
</aside>

<main>
  <div class="box">
    <h2>Informações Pessoais</h2>
    
    <div class="linha">
      <span><i class="fas fa-id-badge"></i> Nome:</span>
      <span><?= htmlspecialchars($usuario['nome']); ?></span>
    </div>
    
    <div class="linha">
      <span><i class="fas fa-birthday-cake"></i> Idade:</span>
      <span><?= $idade ?> anos</span>
    </div>
    
    <div class="linha">
      <span><i class="fas fa-calendar-alt"></i> Data de Nascimento:</span>
      <span><?= !empty($usuario['data_nascimento']) ? date("d/m/Y", strtotime($usuario['data_nascimento'])) : ''; ?></span>
    </div>

    <div class="linha">
      <span><i class="fas fa-envelope"></i> Email:</span>
      <span><?= htmlspecialchars($usuario['email']); ?></span>
    </div>
  </div>
</main>

</body>
</html>
