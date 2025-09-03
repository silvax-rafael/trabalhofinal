<?php
$host = "localhost";
$db   = "controle_medicamento";
$user = "root";
$pass = "";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) { die("Conexão falhou: " . $conn->connect_error); }

// Se o formulário foi enviado
if(isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $nome = $_POST['nome'];
    $dose = $_POST['dose'];
    $horario = $_POST['horario'];

    $sql = "UPDATE medicamentos SET nome='$nome', dose='$dose', horario='$horario' WHERE id=$id";
    $conn->query($sql);
    $conn->close();
    header("Location: home.php");
    exit;
}

// Se veio pelo GET, mostrar formulário de edição
if(isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $res = $conn->query("SELECT * FROM medicamentos WHERE id=$id");
    $med = $res->fetch_assoc();
}
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
