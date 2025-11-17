<?php
// config.php

$host = getenv('DB_HOST') ?: 'db';  // ← CORRIGIDO
$db = getenv('MYSQL_DATABASE') ?: 'alucom_db';
$user = getenv('MYSQL_USER') ?: 'alucom';
$pass = getenv('MYSQL_PASSWORD') ?: 'alucom123';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    echo "Erro ao conectar com o banco: " . $e->getMessage();
    exit;
}
