<?php
session_start();

// Verifica login
if (!isset($_SESSION['usuario_id']) || empty($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Conexão com o banco de dados
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "controle_medicamento";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$usuario_id = $_SESSION['usuario_id'];

$sql = "SELECT nome, horario, ultima_tomada 
        FROM medicamentos 
        WHERE usuario_id = ?
        ORDER BY horario ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório</title>
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
        <a href="logout.php" class="btn-sair">🚪 SAIR</a>
    </nav>
</aside>

<main>
    <h2>Relatório de Medicamentos</h2>

    <div class="card">
        <h3>Lista de medicamentos cadastrados:</h3>
    </div>

    <table>
        <thead>
            <tr>
                <th>Medicamento</th>
                <th>Horário</th>
                <th>Última Tomada</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nome']) ?></td>
                    <td><?= date("H:i", strtotime($row['horario'])) ?></td>
                    <td>
                        <?= !empty($row['ultima_tomada']) 
                                ? date("d/m/Y H:i", strtotime($row['ultima_tomada'])) 
                                : "—" ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>

</body>
</html>
