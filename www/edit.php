<?php
require_once "config.php";

if (!isset($_GET['id'])) {
    die("ID não informado.");
}

$id = intval($_GET['id']);

$stmt = $pdo->prepare("SELECT * FROM item WHERE id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    die("Item não encontrado.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $item_estoque = $_POST['item_estoque'];

    $update = $pdo->prepare("
        UPDATE item 
        SET nome = ?, descricao = ?, item_estoque = ?
        WHERE id = ?
    ");

    if ($update->execute([$nome, $descricao, $item_estoque, $id])) {
        header("Location: index.php");
        exit;
    } else {
        echo "Erro ao atualizar o item.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <title>Editar Item</title>
</head>
<body>

<h2>Editar Item</h2>

<form method="POST">

    <label>Nome:</label>
    <input type="text" name="nome" value="<?= $item['nome'] ?>" required>

    <label>Descrição:</label>
    <input type="text" name="descricao" value="<?= $item['descricao'] ?>">

    <label>ID Estoque:</label>
    <input type="number" name="item_estoque" value="<?= $item['item_estoque'] ?>" required>

    <button type="submit" class="btn">Salvar Alterações</button>
    <a href="index.php" class="btn">Cancelar</a>

</form>

</body>
</html>
