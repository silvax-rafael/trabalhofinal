<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['medication_taken_id'])) {
    $medication_id = $_POST['medication_taken_id'];

    
    if ($success) {
        
        session_start(); 
        $_SESSION['success_message'] = "✅ O remédio foi tomado com sucesso!";
        
      
        header("Location: " . $_SERVER['PHP_SELF']); 
        exit();
    } else {
        // Handle error case
        $error_message = "❌ Erro ao registrar a tomada do remédio.";
    }
}

// 5. **Display Messages and List:**
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Gerenciamento de Medicamentos</title>
</head>
<body>

    <?php
    // Check for and display the success message from the session
    session_start();
    if (isset($_SESSION['success_message'])) {
        echo '<div style="color: green; border: 1px solid green; padding: 10px; margin-bottom: 20px;">' . $_SESSION['success_message'] . '</div>';
        unset($_SESSION['success_message']); // Clear the message after displaying it
    }
    
    // Display error message if one exists from the POST attempt
    if (isset($error_message)) {
         echo '<div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 20px;">' . $error_message . '</div>';
    }
    
    
    ?>

    <?php
// Certifique-se de que a sessão foi iniciada no topo do seu arquivo principal.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Bloco de Exibição da Mensagem de Sucesso (e Erro, se houver)
if (isset($_SESSION['success_message'])) {
    // Estilização simples para destacar a mensagem de sucesso
    echo '<div style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 15px; margin-bottom: 20px; border-radius: 5px;" role="alert">';
    echo '<strong>Sucesso!</strong> ' . htmlspecialchars($_SESSION['success_message']);
    echo '</div>';
    
    // Importante: Limpa a mensagem da sessão para que ela não apareça no próximo refresh.
    unset($_SESSION['success_message']); 
} 

// Se você tiver uma variável de erro definida (ex: $error_message no bloco POST)
if (isset($error_message)) {
    echo '<div style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 15px; margin-bottom: 20px; border-radius: 5px;" role="alert">';
    echo '<strong>Erro:</strong> ' . htmlspecialchars($error_message);
    echo '</div>';
}

// ---

// 2. Exemplo de Bloco de Lista Atualizada
echo '<h3>💊 Lista de Medicamentos Atualizada</h3>';

// Simulação de dados (Na vida real, esta variável seria preenchida com a consulta ao DB)
$medicamentos_exemplo = [
    ['nome' => 'Paracetamol', 'horario' => '08:00', 'status' => 'Tomado'],
    ['nome' => 'Amoxicilina', 'horario' => '14:00', 'status' => 'Pendente'],
    ['nome' => 'Loratadina', 'horario' => '20:00', 'status' => 'Pendente'],
];

if (!empty($medicamentos_exemplo)) {
    echo '<table style="width: 100%; border-collapse: collapse;">';
    echo '<thead>';
    echo '<tr style="background-color: #f2f2f2;"><th>Medicamento</th><th>Horário</th><th>Status</th></tr>';
    echo '</thead>';
    echo '<tbody>';
    
    foreach ($medicamentos_exemplo as $remedio) {
        $status_cor = ($remedio['status'] === 'Tomado') ? 'green' : 'orange';
        
        echo '<tr>';
        echo '<td style="border: 1px solid #ddd; padding: 8px;">' . htmlspecialchars($remedio['nome']) . '</td>';
        echo '<td style="border: 1px solid #ddd; padding: 8px;">' . htmlspecialchars($remedio['horario']) . '</td>';
        echo '<td style="border: 1px solid #ddd; padding: 8px; color: ' . $status_cor . '; font-weight: bold;">' . htmlspecialchars($remedio['status']) . '</td>';
        // Aqui você adicionaria um formulário/botão para "Tomar" se o status fosse "Pendente"
        echo '</tr>';
    }
    
    echo '</tbody>';
    echo '</table>';
} else {
    echo '<p>Nenhum medicamento agendado.</p>';
}



?>  

    </body>
</html>