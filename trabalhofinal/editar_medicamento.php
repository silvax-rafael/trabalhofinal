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

// Atualiza medicamento
if(isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $nome = $_POST['nome'];
    $dose = $_POST['dose'];
    $horario = $_POST['horario'];

    $stmt = $conn->prepare("UPDATE medicamentos SET nome=?, dose=?, horario=? WHERE id=? AND usuario_id=?");
    $stmt->bind_param("sssii", $nome, $dose, $horario, $id, $_SESSION['usuario_id']);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header("Location: home.php");
    exit;
}

// Formulário de edição
if(isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM medicamentos WHERE id=? AND id=?");
    $stmt->bind_param("ii", $id, $_SESSION['usuario_id']);
    $stmt->execute();
    $res = $stmt->get_result();
    $med = $res->fetch_assoc();
    $stmt->close();
}
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
<main class="main" style="margin-left:0; padding:32px;">
  <div class="card">
    <div class="header">
      <div class="title">Editar Medicamento</div>
    </div>
    <form action="editar_medicamento.php" method="POST" style="padding:20px; display:flex; flex-direction:column; gap:16px;">
      <input type="hidden" name="id" value="<?php echo $med['id']; ?>">
      <input type="text" name="nome" value="<?php echo $med['nome']; ?>" required>
      <input type="text" name="dose" value="<?php echo $med['dose']; ?>" required>
      <input type="datetime-local" name="horario" value="<?php echo date("Y-m-d\TH:i", strtotime($med['horario'])); ?>" required>
      <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>
  </div>
</main>
</body>
</html>
