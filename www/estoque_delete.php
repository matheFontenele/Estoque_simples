<?php
require 'config.php';

if (!isset($_GET['id'])) {
    die('ID não informado.');
}
$id = (int) $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM estoque WHERE id = ?");
if ($stmt->execute([$id])) {
    header('Location: estoque_index.php');
    exit;
} else {
    echo "Erro ao deletar estoque.";
}
