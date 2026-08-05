<?php
// ============================================
// CineVault - Database Connection
// Detecta automaticamente se está rodando local
// (MAMP/XAMPP) ou no InfinityFree e usa as
// credenciais certas para cada ambiente.
// ============================================

$host_atual = $_SERVER['HTTP_HOST'] ?? '';

if (strpos($host_atual, 'localhost') !== false || strpos($host_atual, '127.0.0.1') !== false) {
    // ----- Ambiente LOCAL (MAMP/XAMPP) -----
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', 'root');      // XAMPP: deixe vazio ('') | MAMP: 'root'
    define('DB_NAME', 'cinevault');
} else {
    // ----- Ambiente ONLINE (InfinityFree) -----
    define('DB_HOST', 'sql207.infinityfree.com');
    define('DB_USER', 'if0_42580800');
    define('DB_PASS', 'EAZWZKnNaOlT');
    define('DB_NAME', 'if0_42580800_cinevault');
}

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die('<div style="font-family:sans-serif;padding:20px;background:#1a0000;color:#ff4444;border:1px solid #ff4444;border-radius:8px;margin:20px;">
        <strong>Erro de conexão com o banco de dados.</strong><br>
        ' . mysqli_connect_error() . '<br><br>
        <em>Se estiver testando local: confira se o MAMP/XAMPP está ligado e se o banco "cinevault" foi importado.</em>
    </div>');
}

mysqli_set_charset($conn, 'utf8mb4');
session_start();
?>
