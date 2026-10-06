<?php
require 'functions.php';
require 'db.php';

$inicio = clampYear(intParam('inicio', 2020));
$fim = clampYear(intParam('fim', 2024));
if ($inicio > $fim) [$inicio, $fim] = [$fim, $inicio];

$stmt = $pdo->prepare("SELECT d.nome,
    COALESCE(SUM(n.casos_notificados),0) AS notificados,
    COALESCE(SUM(n.casos_confirmados),0) AS confirmados,
    COALESCE(SUM(n.obitos),0) AS obitos
    FROM doenca d
    JOIN dados_notificacao n ON n.id_doenca = d.id_doenca
    JOIN localidade l ON l.id_localidade = n.id_localidade
    WHERE l.codigo_ibge = '4305108' AND n.ano BETWEEN :inicio AND :fim
    GROUP BY d.id_doenca, d.nome
    ORDER BY confirmados DESC, d.nome");
$stmt->execute(['inicio'=>$inicio,'fim'=>$fim]);
$dados = $stmt->fetchAll();
$max = 1;
$total = 0;
foreach ($dados as $r) {
    $max = max($max, (int)$r['confirmados']);
    $total += (int)$r['confirmados'];
}
$maisFrequente = $dados[0]['nome'] ?? '—';

$pageTitle = 'Comparar doenças';
require 'header.php';
?>
<h1>Comparar doenças</h1>
<form class="filter" method="get">
    <label>Ano inicial
        <select name="inicio">
            <?php for ($a=2020;$a<=2024;$a++): ?><option <?= $a===$inicio?'selected':'' ?>><?= $a ?></option><?php endfor; ?>
        </select>
    </label>
    <label>Ano final
        <select name="fim">
            <?php for ($a=2020;$a<=2024;$a++): ?><option <?= $a===$fim?'selected':'' ?>><?= $a ?></option><?php endfor; ?>
        </select>
    </label>
    <button type="submit">Comparar</button>
</form>

<section class="panel">
    <h2>Casos confirmados por doença</h2>
    <div class="bars compare-bars">
        <?php foreach ($dados as $r): ?>
            <div class="bar-row">
                <span class="bar-label disease-label"><?= e($r['nome']) ?></span>
                <div class="bar-track"><div class="bar-fill" style="width:<?= percentWidth((int)$r['confirmados'], $max) ?>%"></div></div>
                <strong><?= number_format((int)$r['confirmados'], 0, ',', '.') ?></strong>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="metrics two">
    <div><span>Doença mais frequente</span><strong><?= e($maisFrequente) ?></strong></div>
    <div><span>Total de casos confirmados</span><strong><?= number_format($total, 0, ',', '.') ?></strong></div>
</section>

<section class="panel table-wrap">
    <h2>Resumo da comparação</h2>
    <table>
        <thead><tr><th>Doença</th><th>Notificados</th><th>Confirmados</th><th>Óbitos</th></tr></thead>
        <tbody>
        <?php foreach ($dados as $r): ?>
            <tr>
                <td><?= e($r['nome']) ?></td>
                <td><?= number_format((int)$r['notificados'], 0, ',', '.') ?></td>
                <td><?= number_format((int)$r['confirmados'], 0, ',', '.') ?></td>
                <td><?= number_format((int)$r['obitos'], 0, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>
<div class="source">Caxias do Sul/RS • Fonte prevista: DATASUS/SINAN • Dados desta versão são simulados.</div>
<?php require 'footer.php'; ?>
