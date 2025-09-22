<?php
$pdo = new PDO('sqlite:' . __DIR__ . '/../database.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("CREATE TABLE IF NOT EXISTS tickets (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    event TEXT,
    name TEXT,
    qr TEXT,
    validated INTEGER DEFAULT 0
)");
?>
