<?php
session_start();

// Protege a página
if (!isset($_SESSION['usuario_id'])) {
    header("Location: loginform.php");
    exit;
}

// Conexão com o banco
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
    <a href="informacoes.php">👤 INFORMAÇÕES PESSOAIS</a>
    <a href="relatorio.php">📊 RELATÓRIO</a>
    <a href="#">ℹ️ SOBRE</a>
    <form action="logout.php" method="POST" style="margin-top: 10px;">
      <button type="submit" class="btn btn-danger" style="width:100%;">🚪 SAIR</button>
    </form>
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
</body>
</html>
