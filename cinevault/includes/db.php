<?php
// ============================================
// CineVault - Database Connection
// Funciona com XAMPP (Windows) e MAMP (Mac)
// ============================================

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root');      // XAMPP: vazio | MAMP: 'root'
define('DB_NAME', 'cinevault');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die('<div style="font-family:sans-serif;padding:20px;background:#1a0000;color:#ff4444;border:1px solid #ff4444;border-radius:8px;margin:20px;">
        <strong>Erro de conexão com o banco de dados.</strong><br>
        ' . mysqli_connect_error() . '<br><br>
        <em>Se usar MAMP, mude DB_PASS para \'root\' em includes/db.php</em>
    </div>');
}

mysqli_set_charset($conn, 'utf8mb4');
session_start();
?>
