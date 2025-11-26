<?php
require_once "config.php";

// Verifica se o ID foi informado
if (!isset($_GET['id'])) {
    die("ID não informado.");
}

$id = intval($_GET['id']);

// Buscar o item
$stmt = $pdo->prepare("SELECT * FROM item WHERE id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    die("Item não encontrado.");
}

// Buscar lista de estoques para o select
$estoques = $pdo->query("SELECT id, nome FROM estoque")->fetchAll(PDO::FETCH_ASSOC);

// Atualizar item ao enviar o formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $quantidade = $_POST['quantidade'] === '' ? null : intval($_POST['quantidade']);
    $item_estoque = $_POST['item_estoque'];

    $update = $pdo->prepare("
        UPDATE item 
        SET nome = ?, descricao = ?, quantidade = ?, item_estoque = ?
        WHERE id = ?
    ");

    if ($update->execute([$nome, $descricao, $quantidade, $item_estoque, $id])) {
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
    <input type="text" name="nome" value="<?= htmlspecialchars($item['nome']) ?>" required>

    <label>Descrição:</label>
    <input type="text" name="descricao" value="<?= htmlspecialchars($item['descricao']) ?>">

    <label>Quantidade:</label>
    <input type="number" name="quantidade" value="<?= htmlspecialchars($item['quantidade']) ?>">

    <label>Estoque:</label>
    <select name="item_estoque" required>
        <option value="">Selecione...</option>

        <?php foreach ($estoques as $est): ?>
            <option value="<?= $est['id'] ?>" 
                <?= $est['id'] == $item['item_estoque'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($est['nome']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <br><br>

    <button type="submit" class="btn">Salvar alterações</button>
    <a href="index.php" class="btn">Cancelar</a>

</form>

</body>
</html>
