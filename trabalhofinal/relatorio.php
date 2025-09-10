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

// Contadores para os cards
$total = 0;
$tomados = 0;
$pendentes = 0;
$atrasados = 0;

$medicamentos = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $total++;
        $horario_medicamento = new DateTime($row['horario']);
        $status_class = '';
        $status_text = '';

        if($row['status'] == 'Em dia') {
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
            "nome" => $row['nome'],
            "dose" => $row['dose'],
            "horario" => date("d/m/Y H:i", strtotime($row['horario'])),
            "status_class" => $status_class,
            "status_text" => $status_text
        ];
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="relatorio.css">
    <title>Sistema de Controle de Medicação</title>
</head>
<body>

<!-- ====== HEADER ====== -->
<header class="header">
    <div class="logo">
        <img src="fundo.png" alt="Logo" class="img">
    </div>
    <nav class="menu">
        <a href="home.php">HOME</a>
        <a href="informacoes.php">INFORMAÇÕES PESSOAIS</a>
        <a href="relatorio.php" class="active">RELATÓRIO</a>
        <a href="#">SOBRE</a>
    </nav>
</header>

<!-- ====== CONTEÚDO PRINCIPAL ====== -->
<main class="container">
    <!-- Header do relatório -->
    <header class="report-header">
        <h1>Relatório de Medicação</h1>
        <p>Emitido em: <?= date("d/m/Y H:i") ?></p>
    </header>

    <!-- Cards resumo -->
    <section class="cards">
        <div class="card">
            <h2><?= $total ?></h2>
            <p>Total de medicamentos</p>
        </div>
        <div class="card">
            <h2><?= $tomados ?></h2>
            <p>Doses tomadas</p>
        </div>
        <div class="card">
            <h2><?= $pendentes ?></h2>
            <p>Pendentes</p>
        </div>
        <div class="card">
            <h2><?= $atrasados ?></h2>
            <p>Atrasadas</p>
        </div>
    </section>

    <!-- Tabela detalhada -->
    <section>
        <table>
            <caption>Detalhes por medicamento</caption>
            <thead>
                <tr>
                    <th>Medicamento</th>
                    <th>Dosagem</th>
                    <th>Próxima dose</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($medicamentos) > 0): ?>
                    <?php foreach ($medicamentos as $med): ?>
                        <tr>
                            <td><?= $med['nome'] ?></td>
                            <td><?= $med['dose'] ?></td>
                            <td><?= $med['horario'] ?></td>
                            <td><span class="status <?= $med['status_class'] ?>"><?= $med['status_text'] ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align:center; color:gray; padding:15px;">
                            Nenhum medicamento cadastrado
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>

<!-- ====== FOOTER ====== -->
<footer>
    Relatório gerado automaticamente pelo sistema de controle de medicação.
</footer>

</body>
</html>
