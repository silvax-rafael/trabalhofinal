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

