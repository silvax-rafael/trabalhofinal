<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: loginform.php");
    exit;
}

// Inclui o Dompdf
require __DIR__ . '/vendor/autoload.php';
use Dompdf\Dompdf;

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

// Gerar PDF
if(isset($_POST['gerar_pdf'])) {
    $dompdf = new Dompdf();

    $html = '<h1>Relatório de Medicação</h1>';
    $html .= '<div style="margin-bottom:20px;">
        <strong>Total de medicamentos:</strong> '.$total.' |
        <strong>Doses tomadas:</strong> '.$tomados.' |
        <strong>Pendentes:</strong> '.$pendentes.' |
        <strong>Atrasadas:</strong> '.$atrasados.'
    </div>';

    $html .= '<table border="1" cellspacing="0" cellpadding="5" width="100%">
        <thead>
            <tr style="background:#85E4F8; color:#fff;">
                <th>Medicamento</th>
                <th>Dosagem</th>
                <th>Horário</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>';

    foreach($medicamentos as $med){
        $cor = '#fff';
        if($med['status_class']=='ok') $cor = '#bbf7d0';
        if($med['status_class']=='pendente') $cor = '#fde68a';
        if($med['status_class']=='atrasado') $cor = '#fecaca';

        $html .= '<tr>
            <td>'.$med['nome'].'</td>
            <td>'.$med['dose'].'</td>
            <td>'.$med['horario'].'</td>
            <td style="background:'.$cor.'; text-align:center;">'.$med['status_text'].'</td>
        </tr>';
    }

    $html .= '</tbody></table>';

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream('relatorio_medicacao.pdf', ['Attachment' => true]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Relatório de Medicação</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<aside class="sidebar">
  <img src="fundo.png" alt="Logo Sistema">
  <nav class="menu">
    <a href="home.php">🏠 HOME</a>
    <a href="informacoes.php">👤 INFORMAÇÕES PESSOAIS</a>
    <a href="relatorio.php" class="active">📊 RELATÓRIO</a>
    <a href="sobre.php">ℹ️ SOBRE</a>

    <form method="POST">
      <button type="submit" name="gerar_pdf" class="btn btn-primary" style="margin: 10px 0;">Gerar PDF</button>
    </form>

    <form action="logout.php" method="POST">
      <button type="submit" class="btn btn-danger" style="margin-top:20px;">Sair</button>
    </form>
  </nav>
</aside>

<main class="main">
    <h1>Relatório de Medicação</h1>

    <section class="cards">
        <div class="card"><h2><?= $total ?></h2><p>Total de medicamentos</p></div>
        <div class="card"><h2><?= $tomados ?></h2><p>Doses tomadas</p></div>
        <div class="card"><h2><?= $pendentes ?></h2><p>Pendentes</p></div>
        <div class="card"><h2><?= $atrasados ?></h2><p>Atrasadas</p></div>
    </section>

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
                            <td><span class="badge <?= $med['status_class'] ?>"><?= $med['status_text'] ?></span></td>
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
