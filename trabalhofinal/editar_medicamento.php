<?php
session_start();

// Garante login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}


// Conexão
$conn = new mysqli("localhost", "root", "", "controle_medicamento");
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Verifica se recebeu ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("<p style='color:red; text-align:center;'>Erro: ID do medicamento não informado.</p>");
}

$medicamento_id = intval($_GET['id']);
$usuario_id = $_SESSION['usuario_id'];

// Seleciona usando a coluna correta: id
$sql = "SELECT * FROM medicamentos WHERE id = ? AND usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $medicamento_id, $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("<p style='color:red; text-align:center;'>Medicamento não encontrado ou não pertence ao usuário.</p>");
}

$medicamento = $result->fetch_assoc();

// Atualiza se enviou formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = $_POST['nome'] ?? '';
    $dose = $_POST['dose'] ?? '';
    $horario = $_POST['horario'] ?? '';

    if (!empty($nome) && !empty($dose) && !empty($horario)) {

        // UPDATE usando ID correto
        $update = $conn->prepare("
            UPDATE medicamentos
            SET nome = ?, dose = ?, horario = ?
            WHERE id = ? AND usuario_id = ?
        ");

        $update->bind_param("sssii", $nome, $dose, $horario, $medicamento_id, $usuario_id);

        if ($update->execute()) {
            header("Location: home.php");
            exit;
        } else {
            echo "<p style='color:red; text-align:center;'>Erro ao atualizar.</p>";
        }

        $update->close();

    } else {
        echo "<p style='color:red; text-align:center;'>Preencha todos os campos.</p>";
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Medicamento</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="card" style="max-width: 600px; margin: 80px auto; padding: 30px;">
    <h2 style="text-align:center;">Editar Medicamento</h2>

    <form action="" method="POST">

        <input type="text" 
               name="nome" 
               placeholder="Nome do medicamento" 
               required 
               value="<?php echo htmlspecialchars($medicamento['nome']); ?>">

        <br><br>

        <input type="text" 
               name="dose" 
               placeholder="Dosagem" 
               required 
               value="<?php echo htmlspecialchars($medicamento['dose']); ?>">

        <br><br>

        <input type="datetime-local" 
               name="horario" 
               required 
               value="<?php echo date('Y-m-d\TH:i', strtotime($medicamento['horario'])); ?>">

        <br><br>

        <button type="submit" class="btn btn-primary" style="width:100%;">Salvar Alterações</button>

    </form>
</div>

</body>
</html>
