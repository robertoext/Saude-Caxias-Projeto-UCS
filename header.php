<?php if (!isset($pageTitle)) $pageTitle = 'Saúde Caxias'; ?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?> - Saúde Caxias</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="topbar">
    <div class="wrap topbar-inner">
        <a class="brand" href="index.php">Saúde Caxias</a>
        <nav>
            <a href="consultar.php">Consultar doenças</a>
            <a href="estatisticas.php">Estatísticas</a>
            <a href="comparar.php">Comparar</a>
        </nav>
    </div>
</header>
<main class="wrap">
