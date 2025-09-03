<?php
// Conexão com o banco
$host = "localhost";
$db   = "controle_medicamento";
$user = "root";
$pass = "";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) { die("Conexão falhou: " . $conn->connect_error); }

// Busca todos os medicamentos
$sql = "SELECT * FROM medicamentos ORDER BY data_cadastro DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lista de Medicamentos</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<aside class="sidebar">
  <img src="fundo.png" alt="Logo Sistema">
  <nav class="menu">
    <a href="lista_medicamentos.php" class="active">🏠 HOME</a>
    <a href="novomedicamento.html">+ Cadastrar Medicamento</a>
  </nav>
</aside>

<main class="main">
  <div class="card">
    <div class="header">
      <div class="title">Controle de Medicação</div>
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
                  // Determinar status aleatório apenas de exemplo
                  $status = rand(0,2);
                  $badge = ($status==0) ? "ok" : (($status==1) ? "pendente" : "atrasado");
                  $status_text = ($status==0) ? "Em dia" : (($status==1) ? "Pendente" : "Atrasado");

                  echo "<tr>
                    <td>{$row['nome']}</td>
                    <td>{$row['dose']}</td>
                    <td>".date("d/m/Y H:i", strtotime($row['horario']))."</td>
                    <td><span class='badge $badge'>$status_text</span></td>
                    <td>
                      <div class='actions'>
                        <button class='btn btn-primary'>Tomar</button>
                        <button class='btn'>Editar</button>
                        <button class='btn btn-danger'>Excluir</button>
                      </div>
                    </td>
                  </tr>";
              }
          } else {
              echo "<tr><td colspan='5'>Nenhum medicamento cadastrado.</td></tr>";
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
