<?php
$host = "localhost";
$db   = "controle_medicamento";
$user = "root";
$pass = "";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) { die("Conexão falhou: " . $conn->connect_error); }

$sql = "SELECT * FROM medicamentos ORDER BY data_cadastro DESC";
$result = $conn->query($sql);

$hora_atual = new DateTime(); // hora atual
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Home - Controle de Medicação</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<aside class="sidebar">
  <img src="fundo.png" alt="Logo Sistema">
  <nav class="menu">
    <a href="home.php" class="active">🏠 HOME</a>
    <a href="informacoes.php" class="active">👤 INFORMAÇÕES PESSOAIS</a>
    <a href="relatorio.php" class="active">📊 RELATÓRIO</a>
    <a href="#" class="active">ℹ️ SOBRE</a>
    <a href="logout.php" class="btn-sair">🚪 SAIR</a>
  </nav>
</aside>

<main class="main">
  <div class="card">
    <div class="header">
      <div class="title">Controle de Medicação</div>
      <a href="novomedicamento.php" class="btn btn-primary">+ Novo Medicamento</a>
    </div>

    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Nome do medicamento</th>
            <th>Dosagem</th>
            <th>Próxima dose</th>
            <th>Status</th>
            <th style="width: 280px;">Ação</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                  $horario_medicamento = new DateTime($row['horario']);

                  // Lógica de status considerando ultima_tomada e horario
                  if($row['status'] == 'Em dia') {
                      $status_class = 'ok';
                      $status_text = 'Em dia';
                  } elseif ($row['ultima_tomada']) {
                      $ultima = new DateTime($row['ultima_tomada']);
                      if ($ultima >= $horario_medicamento) {
                          $status_class = 'ok';
                          $status_text = 'Em dia';
                      } elseif ($hora_atual > $horario_medicamento) {
                          $status_class = 'atrasado';
                          $status_text = 'Atrasado';
                      } else {
                          $status_class = 'pendente';
                          $status_text = 'Pendente';
                      }
                  } else {
                      // Ainda não foi tomado
                      if ($hora_atual > $horario_medicamento) {
                          $status_class = 'atrasado';
                          $status_text = 'Atrasado';
                      } else {
                          $status_class = 'pendente';
                          $status_text = 'Pendente';
                      }
                  }

                  echo "<tr>
                    <td>{$row['nome']}</td>
                    <td>{$row['dose']}</td>
                    <td>".date("d/m/Y H:i", strtotime($row['horario']))."</td>
                    <td><span class='badge $status_class'>$status_text</span></td>
                    <td>
                      <div class='actions'>
                        <form action='tomar_medicamento.php' method='GET' style='display:inline;'>
                          <input type='hidden' name='id' value='{$row['id']}'>
                          <button type='submit' class='btn btn-primary'>Tomar</button>
                        </form>
                        <form action='editar_medicamento.php' method='GET' style='display:inline;'>
                          <input type='hidden' name='id' value='{$row['id']}'>
                          <button type='submit' class='btn'>Editar</button>
                        </form>
                        <form action='excluir_medicamento.php' method='GET' style='display:inline;'>
                          <input type='hidden' name='id' value='{$row['id']}'>
                          <button type='submit' class='btn btn-danger'>Excluir</button>
                        </form>
                      </div>
                    </td>
                  </tr>";
              }
          } else {
              // Mensagem quando não há medicamentos
              echo "<tr>
                      <td colspan='5' style='text-align:center; color: var(--muted); padding: 20px;'>
                          Nenhum medicamento cadastrado
                      </td>
                    </tr>";
          }
          $conn->close();

          
          ?>

          <!-- Conteúdo principal -->
<main class="conteudo">
  

<!-- ✅ Script de lembrete -->
<script>
function verificarHorario() {
  const agora = new Date();
  const hora = agora.getHours();
  const minuto = agora.getMinutes();

  // Exemplo: alerta às 14:30
  if (hora === 14 && minuto === 30) {
    document.getElementById("alerta").innerText = "💊 Hora do seu remédio!";
    alert("Hora de tomar o remédio!");
  }
}

// Verifica a cada 1 minuto
setInterval(verificarHorario, 60000);
</script>

</body>
</html>

        </tbody>
      </table>
    </div>
  </div>
</main>
</body>
</html>
