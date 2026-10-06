<?php
require 'functions.php';
require 'db.php';

$doencas = $pdo->query('SELECT id_doenca, nome FROM doenca ORDER BY nome')->fetchAll();
$id = intParam('doenca', $doencas[0]['id_doenca'] ?? 1);

$stmt = $pdo->prepare('SELECT id_doenca, nome, categoria, descricao FROM doenca WHERE id_doenca = :id');
$stmt->execute(['id' => $id]);
$doenca = $stmt->fetch();

$resumo = ['notificados'=>0,'confirmados'=>0,'obitos'=>0];
$serie = [];
if ($doenca) {
    $stmt = $pdo->prepare("SELECT
        COALESCE(SUM(casos_notificados),0) AS notificados,
        COALESCE(SUM(casos_confirmados),0) AS confirmados,
        COALESCE(SUM(obitos),0) AS obitos
        FROM dados_notificacao
        WHERE id_doenca = :id");
    $stmt->execute(['id' => $id]);
    $resumo = $stmt->fetch();

    $stmt = $pdo->prepare("SELECT ano, COALESCE(SUM(casos_confirmados),0) AS total
        FROM dados_notificacao
        WHERE id_doenca = :id
        GROUP BY ano ORDER BY ano");
    $stmt->execute(['id' => $id]);
    $serie = $stmt->fetchAll();
}

$max = 1;
foreach ($serie as $r) $max = max($max, (int)$r['total']);
$pageTitle = 'Consultar doenças';
require 'header.php';
?>
<h1>Consultar doenças e agravos</h1>
<form class="filter" method="get">
    <label>Doença
        <select name="doenca">
            <?php foreach ($doencas as $d): ?>
                <option value="<?= (int)$d['id_doenca'] ?>" <?= (int)$d['id_doenca'] === $id ? 'selected' : '' ?>><?= e($d['nome']) ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    <button type="submit">Consultar</button>
</form>

<?php if ($doenca): ?>
<section class="panel">
    <h2><?= e($doenca['nome']) ?></h2>
    <p><strong>Categoria:</strong> <?= e($doenca['categoria'] ?: 'Não informada') ?></p>
    <p><?= e($doenca['descricao'] ?: 'Sem descrição.') ?></p>
</section>

<section class="metrics">
    <div><span>Casos notificados</span><strong><?= number_format((int)$resumo['notificados'], 0, ',', '.') ?></strong></div>
    <div><span>Casos confirmados</span><strong><?= number_format((int)$resumo['confirmados'], 0, ',', '.') ?></strong></div>
    <div><span>Óbitos</span><strong><?= number_format((int)$resumo['obitos'], 0, ',', '.') ?></strong></div>
</section>

<section class="panel">
    <h2>Casos confirmados por ano</h2>
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
<?php else: ?>
<p>Doença não encontrada.</p>
<?php endif; ?>
<?php require 'footer.php'; ?>
