<?php
require_once "config.php";

if (!isset($_GET['id'])) {
    die("ID não informado.");
}

$id = intval($_GET['id']);

$stmt = $pdo->prepare("DELETE FROM item WHERE id = ?");
if ($stmt->execute([$id])) {
    header("Location: index.php");
    exit;
} else {
    echo "Erro ao deletar o item.";
}
