<?php
require 'functions.php';
$pageTitle = 'Início';
require 'header.php';
?>
<section class="hero">
    <p class="eyebrow">Monitoramento epidemiológico</p>
    <h1>Saúde Caxias</h1>
    <p>Aplicação simples para consultar doenças, visualizar estatísticas e comparar casos em Caxias do Sul.</p>
</section>

<div class="notice">
    <strong>Atenção:</strong> os registros usados nesta versão são simulados para desenvolvimento e demonstração. A fonte prevista do projeto é DATASUS/SINAN.
</div>

<section class="cards">
    <a class="card" href="consultar.php">
        <span class="tag">H1</span>
        <h2>Consultar doenças</h2>
        <p>Selecione uma doença e veja informações e totais registrados.</p>
    </a>
    <a class="card" href="estatisticas.php">
        <span class="tag">H2</span>
        <h2>Visualizar estatísticas</h2>
        <p>Escolha uma doença e um período para acompanhar a evolução dos casos.</p>
    </a>
    <a class="card" href="comparar.php">
        <span class="tag">H3</span>
        <h2>Comparar doenças</h2>
        <p>Compare as doenças no período e identifique as maiores ocorrências.</p>
    </a>
</section>
<?php require 'footer.php'; ?>
