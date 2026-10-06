<?php
// Conexão simples com PostgreSQL.
// Ajuste os valores abaixo conforme seu ambiente local.
$host = getenv('DB_HOST') ?: 'localhost';
$port = getenv('DB_PORT') ?: '5432';
$db   = getenv('DB_NAME') ?: 'saude_caxias';
$user = getenv('DB_USER') ?: 'postgres';
$pass = getenv('DB_PASS') ?: 'postgres';

try {
    $pdo = new PDO(
        "pgsql:host={$host};port={$port};dbname={$db}",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    echo '<!doctype html><html lang="pt-BR"><meta charset="utf-8"><title>Saúde Caxias</title>';
    echo '<style>body{font-family:Arial,sans-serif;max-width:780px;margin:60px auto;padding:0 20px;color:#1f2937}code{background:#f3f4f6;padding:2px 5px;border-radius:4px}.box{border:1px solid #ddd;padding:20px;border-radius:10px;background:#fafafa}</style>';
    echo '<div class="box"><h1>Não foi possível conectar ao PostgreSQL</h1>';
    echo '<p>Confira se o banco <code>saude_caxias</code> foi criado e se usuário/senha em <code>db.php</code> estão corretos.</p>';
    echo '<p>Depois execute os arquivos <code>sql/01_schema.sql</code> e <code>sql/02_seed.sql</code>.</p>';
    echo '<p><strong>Erro técnico:</strong> '.htmlspecialchars($e->getMessage()).'</p></div></html>';
    exit;
}
