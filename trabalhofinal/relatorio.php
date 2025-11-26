<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include 'conexao.php';

$user_id = $_SESSION['id'];

// Buscar todos os medicamentos do usuário
$sql = "SELECT id, nome, horario, ultima_tomada FROM medicamentos WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$hora_atual = new DateTime();

// contadores
$pendentes = 0;
$atrasados = 0;
$tomados = 0;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório</title>
    <link rel="stylesheet" href="styles.css">

    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top:20px; }
        th, td { padding: 12px; border-bottom: 1px solid #ccc; text-align:left; }
        .ok { color: green; font-weight: bold; }
        .pendente { color: orange; font-weight: bold; }
        .atrasado { color: red; font-weight: bold; }
        .card { padding:20px; border-radius:10px; box-shadow:0 0 10px #ccc; margin-bottom:20px; }
    </style>
</head>
<body>

<h2>Relatório de Medicamentos</h2>

<div class="card">
    <h3>Status geral:</h3>
    <p><strong>Em dia:</strong> <?= $tomados ?></p>
    <p><strong>Pendentes:</strong> <?= $pendentes ?></p>
    <p><strong>Atrasados:</strong> <?= $atrasados ?></p>
</div>

<table>
    <tr>
        <th>Medicamento</th>
        <th>Horário</th>
        <th>Última Tomada</th>
        <th>Status</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>

        <?php
        $horario_medicamento = new DateTime($row['horario']);

        // Verificar status correto
        if (!empty($row['ultima_tomada'])) {

            // Se já tomou → EM DIA
            $status_class = 'ok';
            $status_text  = 'Em dia';
            $tomados++;

        } else {

            if ($hora_atual > $horario_medicamento) {
                // Horário passou → ATRASADO
                $status_class = 'atrasado';
                $status_text  = 'Atrasado';
                $atrasados++;
            } else {
                // Antes do horário → PENDENTE
                $status_class = 'pendente';
                $status_text  = 'Pendente';
                $pendentes++;
            }
        }
        ?>

        <tr>
            <td><?= $row['nome'] ?></td>
            <td><?= date("H:i", strtotime($row['horario'])) ?></td>
            <td>
                <?= 
                    !empty($row['ultima_tomada']) 
                    ? date("d/m/Y H:i", strtotime($row['ultima_tomada'])) 
                    : "—"
                ?>
            </td>
            <td class="<?= $status_class ?>"><?= $status_text ?></td>
        </tr>

    <?php endwhile; ?>

</table>

</body>
</html>
