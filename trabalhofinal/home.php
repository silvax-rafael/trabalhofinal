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
$sql = "SELECT * FROM medicamentos WHERE usuario_id = ? ORDER BY data_cadastro DESC";
$stmt = $conn->prepare($sql);
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
    <form action="logout.php" method="POST">
      <button type="submit" class="btn btn-danger" style="margin-top:20px;">Sair</button>
    </form>
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

</body>
</html>
