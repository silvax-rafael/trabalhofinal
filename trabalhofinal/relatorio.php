<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="relatorio.css">
    <title>Sistema de Controle de Medicação</title>
</head>
<body>

<!-- ====== HEADER ====== -->
<header class="header">
    <div class="logo">
        <img src="fundo.png" alt="Logo" class="img">
    </div>
    <nav class="menu">
        <a href="home.php">HOME</a>
        <a href="informacoes.php">INFORMAÇÕES PESSOAIS</a>
        <a href="relatorio.php">RELATÓRIO</a>
        <a href="#">SOBRE</a>
    </nav>
</header>

<!-- ====== CONTEÚDO PRINCIPAL ====== -->
<main class="container">
    <!-- Header do relatório -->
    <header class="report-header">
        <h1>Relatório de Medicação</h1>
        <p>Emitido em: 27/08/2025</p>
    </header>

    <!-- Cards resumo -->
    <section class="cards">
        <div class="card">
            <h2>12</h2>
            <p>Total de medicamentos</p>
        </div>
        <div class="card">
            <h2>8</h2>
            <p>Doses tomadas</p>
        </div>
        <div class="card">
            <h2>3</h2>
            <p>Pendentes</p>
        </div>
        <div class="card">
            <h2>1</h2>
            <p>Atrasadas</p>
        </div>
    </section>

    <!-- Tabela detalhada -->
    <section>
        <table>
            <caption>Detalhes por medicamento</caption>
            <thead>
                <tr>
                    <th>Medicamento</th>
                    <th>Dosagem</th>
                    <th>Próxima dose</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Paracetamol</td>
                    <td>750 mg</td>
                    <td>27/08/2025 14:00</td>
                    <td><span class="status pendente">Pendente</span></td>
                </tr>
                <tr>
                    <td>Amoxicilina</td>
                    <td>500 mg</td>
                    <td>27/08/2025 18:00</td>
                    <td><span class="status ok">Em dia</span></td>
                </tr>
                <tr>
                    <td>Losartana</td>
                    <td>50 mg</td>
                    <td>27/08/2025 08:00</td>
                    <td><span class="status atrasado">Atrasado</span></td>
                </tr>
            </tbody>
        </table>
    </section>
</main>

<!-- ====== FOOTER ====== -->
<footer>
    Relatório gerado automaticamente pelo sistema de controle de medicação.
</footer>

</body>
</html>
