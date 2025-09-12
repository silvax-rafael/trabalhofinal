<?php
session_start();

// Limpa todas as variáveis da sessão
session_unset();

// Destroi a sessão
session_destroy();

// Redireciona para a página de login
header("Location: loginform.php");
exit;
?>
