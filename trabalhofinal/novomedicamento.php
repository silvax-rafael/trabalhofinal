<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Controle de Medicação</title>
    <link rel="stylesheet" href="novomedicamento.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">
        <img src="fundo.png" alt="Logo">
        <h2>Cadastro de Medicamento</h2>

        <!-- Formulário que envia os dados para o PHP -->
        <form action="cadastro_medicamento.php" method="POST">
            <label>
                <input type="text" name="nomedomedicamento" placeholder="Nome do Medicamento" required>
            </label>

            <label>
                <input type="text" name="dose" placeholder="Dose (ex: 500 mg)" required>
            </label>

            <!-- datetime-local envia data + hora -->
            <label>
                <input type="datetime-local" name="horario" required>
            </label>

            <button type="submit">Cadastrar Medicamento</button>
        </form>
    </div>

</body>
</html>

