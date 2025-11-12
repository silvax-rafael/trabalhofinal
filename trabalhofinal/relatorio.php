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
$total = 0;
$tomados = 0;
$pendentes = 0;
$atrasados = 0;

$medicamentos = [];
while($row = $result->fetch_assoc()) {
    $total++;
    $horario_medicamento = new DateTime($row['horario']);
    $status_class = '';
    $status_text = '';

    if ($row['status'] == 'Em dia') {
        $status_class = 'ok';
        $status_text = 'Em dia';
        $tomados++;
    } elseif ($row['ultima_tomada']) {
        $ultima = new DateTime($row['ultima_tomada']);
        if ($ultima >= $horario_medicamento) {
            $status_class = 'ok';
            $status_text = 'Em dia';
            $tomados++;
        } elseif ($hora_atual > $horario_medicamento) {
            $status_class = 'atrasado';
            $status_text = 'Atrasado';
            $atrasados++;
        } else {
            $status_class = 'pendente';
            $status_text = 'Pendente';
            $pendentes++;
        }
    } else {
        if ($hora_atual > $horario_medicamento) {
            $status_class = 'atrasado';
            $status_text = 'Atrasado';
            $atrasados++;
        } else {
            $status_class = 'pendente';
            $status_text = 'Pendente';
            $pendentes++;
        }
    }

    $medicamentos[] = [
        'nome' => $row['nome'],
        'dose' => $row['dose'],
        'horario' => date("d/m/Y H:i", strtotime($row['horario'])),
        'status_class' => $status_class,
        'status_text' => $status_text
    ];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Relatório de Medicação</title>
<link rel="stylesheet" href="relatorio.css">
</head>
<body>

<aside class="sidebar">
  <img src="fundo.png" alt="Logo Sistema">
  <nav class="menu">
    <a href="home.php">🏠 HOME</a>
    <a href="informacoes.php">👤 INFORMAÇÕES PESSOAIS</a>
    <a href="relatorio.php" class="active">📊 RELATÓRIO</a>
    <a href="sobre.php">ℹ️ SOBRE</a>
    <form action="logout.php" method="POST">
      <button type="submit" class="btn-sair">Sair</button>
    </form>
  </nav>
</aside>

<main>
    <h1>Relatório de Medicação</h1>

    <!-- Cards resumo -->
    <section class="cards">
        <div class="card"><h2><?= $total ?></h2><p>Total de medicamentos</p></div>
        <div class="card"><h2><?= $tomados ?></h2><p>Doses tomadas</p></div>
        <div class="card"><h2><?= $pendentes ?></h2><p>Pendentes</p></div>
        <div class="card"><h2><?= $atrasados ?></h2><p>Atrasadas</p></div>
    </section>

    <!-- Tabela detalhada -->
    <section>
        <table>
            <thead>
                <tr>
                    <th>Medicamento</th>
                    <th>Dosagem</th>
                    <th>Horário</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($medicamentos) > 0): ?>
                    <?php foreach($medicamentos as $med): ?>
                        <tr>
                            <td><?= $med['nome'] ?></td>
                            <td><?= $med['dose'] ?></td>
                            <td><?= $med['horario'] ?></td>
                            <td><span class="status <?= $med['status_class'] ?>"><?= $med['status_text'] ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" style="text-align:center;color:gray;">Nenhum medicamento cadastrado</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>

</body>
</html>
