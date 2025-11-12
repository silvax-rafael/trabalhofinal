<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id']) || empty($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

// Dados de conexão com o banco
$host = "localhost";
$username = "root";
$password = "";
$dbname = "controle_medicamento";

// Tentativa de conexão
$conn = new mysqli($host, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die('ERRO FATAL NA CONEXÃO COM O BANCO DE DADOS: ' . $conn->connect_error);
}

// Obtém o ID do usuário da sessão
$usuario_id = $_SESSION['usuario_id'];

// Consulta medicamentos do usuário logado
$sql = "SELECT * FROM medicamentos WHERE usuario_id = ? ORDER BY horario ASC, data_cadastro DESC";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die('ERRO FATAL NA PREPARAÇÃO DO SQL: ' . $conn->error);
}

$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$hora_atual = new DateTime();
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
    <a href="informacoes.php">👤 INFORMAÇÕES PESSOAIS</a>
    <a href="relatorio.php">📊 RELATÓRIO</a>
    <a href="sobre.php">ℹ️ SOBRE</a>
    <a href="logout.php" class="btn-sair">🚪 SAIR</a>
  </nav>
</aside>

<main class="main">
  <div class="card">
    <div class="header" style="display:flex; justify-content:space-between; align-items:center;">
      <div class="title">Controle de Medicação</div>
      <form action="novomedicamento.php" method="GET" style="display:inline;">
          <button type="submit" class="btn btn-primary">+ Novo Medicamento</button>
      </form>
    </div>

    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Nome do medicamento</th>
            <th>Dosagem</th>
            <th>Horário</th>
            <th>Status</th>
            <th style="width: 280px;">Ação</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                  $horario_medicamento = new DateTime($row['horario']);

                  if($row['ultima_tomada']) {
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
                          <button type='submit' class='btn btn-primary'>💊 Tomar</button>
                        </form>
                        <form action='editar_medicamento.php' method='GET' style='display:inline;'>
                          <input type='hidden' name='id' value='{$row['id']}'>
                          <button type='submit' class='btn'>✏️ Editar</button>
                        </form>
                        <form action='excluir_medicamento.php' method='GET' style='display:inline;'>
                          <input type='hidden' name='id' value='{$row['id']}'>
                          <button type='submit' class='btn btn-danger'>🗑️ Excluir</button>
                        </form>
                      </div>
                    </td>
                  </tr>";
              }
          } else {
              echo "<tr>
                      <td colspan='5' style='text-align:center; color: var(--muted); padding: 20px;'>
                          Nenhum medicamento cadastrado
                      </td>
                    </tr>";
          }
          $conn->close();
          ?>
        </tbody>
      </table>
    </div>
  </div>
</main>

<!-- Script de lembrete -->
<script>
function verificarHorario() {
  const agora = new Date();
  const hora = agora.getHours();
  const minuto = agora.getMinutes();

  // Exemplo: alerta às 14:30
  if (hora === 14 && minuto === 30) {
    alert("💊 Hora de tomar o remédio!");
  }
}

// Verifica a cada 1 minuto
setInterval(verificarHorario, 60000);
</script>

</body>
</html>