<?php
// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Variáveis (Revisadas e CORRETAS)
    $nome       = $_POST['nomedomedicamento'];
    $dose       = $_POST['dose'];
    $horario    = $_POST['horario'];
    // Assumindo que $_SESSION['usuario_id'] está sendo definido corretamente no login
    $usuario_id = $_SESSION['usuario_id'] ?? null; 
    
    // Teste de ID
    if (empty($usuario_id)) {
        die("ERRO FATAL: O ID do usuário está vazio na sessão. Verifique o login.");
    }

    // 2. Consulta SQL (Assumindo que usuario_id é o nome correto da coluna FK)
    $sql_insert = "INSERT INTO medicamentos (nome, dose, horario, usuario_id) VALUES (?, ?, ?, ?)";
    
    // 3. TENTA PREPARAR
    $stmt = $conn->prepare($sql_insert);

    // 4. VERIFICA O ERRO DE PREPARAÇÃO
    if (!$stmt) {
        // ESSA MENSAGEM IRÁ TE DAR O ERRO EXATO DO BANCO DE DADOS
        echo "<h2>❌ ERRO NO PREPARE:</h2>";
        die("Falha ao preparar: " . $conn->error); 
    }

    // 5. Tenta VINCULAR
    $bind_result = $stmt->bind_param("sssi", $nome, $dose, $horario, $usuario_id); 
    
    if (!$bind_result) {
        echo "<h2>❌ ERRO NO BIND:</h2>";
        die("Falha ao vincular parâmetros: " . $stmt->error);
    }

    // 6. EXECUÇÃO E FEEDBACK
    if ($stmt->execute()) {
        $_SESSION['success_message'] = 'Medicamento cadastrado com sucesso!';
        header("Location: home.php");
        exit;
    } else {
        // ERRO DURANTE A EXECUÇÃO (geralmente problema de dados/tipos)
        $_SESSION['error_message'] = 'Erro ao cadastrar: ' . $stmt->error;
        header("Location: novomedicamento.php"); 
        exit;
    }

    $stmt->close();
}
?>
