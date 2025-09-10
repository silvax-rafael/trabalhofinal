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

// Busca os dados do usuário
$stmt = $conn->prepare("SELECT nome, data_nascimento, usuario FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
$conn->close();

// Calcula idade
$dataNascimento = new DateTime($usuario['data_nascimento']);
$hoje = new DateTime();
$idade = $hoje->diff($dataNascimento)->y;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Informações Pessoais - Sistema de Controle de Medicação</title>
  <link rel="stylesheet" href="informacoes.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <!-- Sidebar -->
  <aside class="sidebar">
    <img src="fundo.png" alt="Logo Sistema">
    <nav class="menu">
      <a href="home.php">🏠 HOME</a>
      <a href="informacoes.php" class="active">👤 INFORMAÇÕES PESSOAIS</a>
      <a href="relatorio.php">📊 RELATÓRIO</a>
      <a href="sobre.php">ℹ️ SOBRE</a>
      <a href="logout.php" class="btn-sair">🚪 SAIR</a>
    </nav>
  </aside>

  <!-- Conteúdo -->
  <main>
    <div class="box">
      <h2>Informações Pessoais</h2>
      
      <div class="linha">
        <span><i class="fas fa-id-badge"></i> Nome:</span>
        <span><?= htmlspecialchars($usuario['nome']) ?></span>
      </div>
      
      <div class="linha">
        <span><i class="fas fa-birthday-cake"></i> Idade:</span>
        <span><?= $idade ?> anos</span>
      </div>
      
      <div class="linha">
        <span><i class="fas fa-calendar-alt"></i> Data de Nascimento:</span>
        <span><?= date("d/m/Y", strtotime($usuario['data_nascimento'])) ?></span>
      </div>

      <div class="linha">
        <span><i class="fas fa-envelope"></i> Email:</span>
        <span><?= htmlspecialchars($usuario['usuario']) ?></span>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="footer">
    &copy; 2025 - Sistema de Controle de Medicação
  </footer>
</body>
</html>
