<?php
// Configurações do banco de dados
$host = "localhost"; // geralmente localhost
$db   = "controle_medicamento";
$user = "root";      // seu usuário do MySQL
$pass = "";          // sua senha do MySQL

// Conexão com o banco
$conn = new mysqli($host, $user, $pass, $db);

// Verifica conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome   = $_POST['nomedomedicamento'];
    $dose   = $_POST['dose'];
    $horario = $_POST['horario'];

    // Prepara a query
    $stmt = $conn->prepare("INSERT INTO medicamentos (nome, dose, horario) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $dose, $horario);

    if ($stmt->execute()) {
        echo "<script>alert('Medicamento cadastrado com sucesso!'); window.location.href='home.php';</script>";
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
