<?php
require 'functions.php';
require 'db.php';

$doencas = $pdo->query('SELECT id_doenca, nome FROM doenca ORDER BY nome')->fetchAll();
$id = intParam('doenca', $doencas[0]['id_doenca'] ?? 1);
$inicio = clampYear(intParam('inicio', 2020));
$fim = clampYear(intParam('fim', 2024));
if ($inicio > $fim) [$inicio, $fim] = [$fim, $inicio];

$stmt = $pdo->prepare('SELECT nome FROM doenca WHERE id_doenca = :id');
$stmt->execute(['id'=>$id]);
$nome = $stmt->fetchColumn() ?: 'Doença';

$stmt = $pdo->prepare("SELECT ano, COALESCE(SUM(casos_confirmados),0) AS total
    FROM dados_notificacao
    WHERE id_doenca = :id AND ano BETWEEN :inicio AND :fim
    GROUP BY ano ORDER BY ano");
$stmt->execute(['id'=>$id,'inicio'=>$inicio,'fim'=>$fim]);
$serie = $stmt->fetchAll();
$total = array_sum(array_map(fn($r)=>(int)$r['total'], $serie));
$max = 1;
foreach ($serie as $r) $max = max($max, (int)$r['total']);

$pageTitle = 'Estatísticas';
require 'header.php';
?>
<h1>Visualizar dados estatísticos</h1>
<form class="filter grid-filter" method="get">
    <label>Doença
        <select name="doenca">
            <?php foreach ($doencas as $d): ?>
                <option value="<?= (int)$d['id_doenca'] ?>" <?= (int)$d['id_doenca'] === $id ? 'selected' : '' ?>><?= e($d['nome']) ?></option>
            <?php endforeach; ?>
        </select>
    </label>
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
    <button type="submit">Consultar</button>
</form>

<section class="metrics one">
    <div><span>Total de casos confirmados — <?= e($nome) ?></span><strong><?= number_format($total, 0, ',', '.') ?></strong></div>
</section>

<section class="panel">
    <h2>Casos por ano (<?= $inicio ?>–<?= $fim ?>)</h2>
    <div class="bars">
        <?php foreach ($serie as $r): ?>
            <div class="bar-row">
                <span class="bar-label"><?= (int)$r['ano'] ?></span>
                <div class="bar-track"><div class="bar-fill" style="width:<?= percentWidth((int)$r['total'], $max) ?>%"></div></div>
                <strong><?= number_format((int)$r['total'], 0, ',', '.') ?></strong>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<div class="source">Fonte prevista: DATASUS/SINAN • Nesta demonstração, os valores são simulados.</div>
<?php require 'footer.php'; ?>
