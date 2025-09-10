<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema de Controle de Medicação</title>
  <link rel="stylesheet" href="informacoes.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <!-- Sidebar -->
  <aside class="sidebar">
    <img src="fundo.png" alt="Logo Sistema">
    <nav class="menu">
      <a href="home.php" class="active">🏠 HOME</a>
      <a href="informacoes.php" class="active">👤 INFORMAÇÕES PESSOAIS</a>
      <a href="relatorio.php" class="active">📊 RELATÓRIO</a>
      <a href="sobre.php" class="active">ℹ️ SOBRE</a>
      <a href="logout.php" class="btn-sair">🚪 SAIR</a>
    </nav>
  </aside>

  <!-- Conteúdo -->
  <main>
    <div class="box">
      <h2>Informações Pessoais</h2>
      
      <div class="linha">
        <span><i class="fas fa-id-badge"></i> Nome:</span>
        <span>Rafael Silva</span>
      </div>
      
      <div class="linha">
        <span><i class="fas fa-birthday-cake"></i> Idade:</span>
        <span>25 anos</span>
      </div>
      
      <div class="linha">
        <span><i class="fas fa-calendar-alt"></i> Data de Nascimento:</span>
        <span>29/08/2000</span>
      </div>

      <div class="linha">
        <span><i class="fas fa-envelope"></i> Email:</span>
        <span>rafael@email.com</span>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="footer">
    &copy; 2025 - Sistema de Controle de Medicação
  </footer>
</body>
</html>
