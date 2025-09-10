<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="index.css">
  <title>Sistema de Controle de Medicação - Cadastro</title>
</head>
<body>

  <!-- Cabeçalho -->
  <header>
    <img src="fundo.png" alt="Logo do Sistema" class="img">
    <h1 class="titulo">Sistema de Controle de Medicação</h1>
  </header>

  <!-- Cadastro -->
  <main>
    <h2 class="titulo2">Cadastro</h2>
    <form class="box" action="login.php" method="POST">

      <label>
        <input type="text" name="nome" placeholder="NOME" required>
      </label>

      <label>
        <input type="date" name="data" required>
      </label>

      <label>
        <input type="text" name="nomedeusuario" placeholder="NOME DE USUÁRIO" required>
      </label>

      <label>
        <input type="password" name="senha" placeholder="SENHA" required>
      </label>

      <label>
        <input type="password" name="confirmarsenha" placeholder="CONFIRMAR SENHA" required>
      </label>

      <button type="submit">ENVIAR</button>
      <a href="login.php">Já tenho uma conta</a>
    </form>
  </main>

</body>
</html>
