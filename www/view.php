<?php
require_once "config.php";

// Buscar todos os itens com o nome do estoque
$query = "
    SELECT 
        item.id,
        item.nome AS item_nome,
        item.descricao,
	item.cor,
        estoque.nome AS estoque_nome
    FROM item
    LEFT JOIN estoque ON item.item_estoque = estoque.id
";

$stmt = $pdo->prepare($query);
$stmt->execute();
$itens = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <title>Lista de Itens</title>
</head>
<body>

<h1>Itens cadastrados</h1>

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>ID</th>
            <th>Item</th>
            <th>Descrição</th>
	    <th>Cor</th>
            <th>Estoque</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($itens as $item): ?>
            <tr>
                <td><?= $item['id'] ?></td>
                <td><?= $item['item_nome'] ?></td>
                <td><?= $item['descricao'] ?></td>
		<td><?= $item['cor'] ?></th>
                <td><?= $item['estoque_nome'] ?: 'Sem estoque' ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p><a href="index.php">Voltar</a></p>

</body>
</html>
