<?php
require_once "config.php";

/* -------------------------
   1. Capturar filtros
------------------------- */
$filtro_nome = $_GET['nome'] ?? '';
$filtro_cor = $_GET['cor'] ?? '';
$filtro_estoque = $_GET['estoque'] ?? '';

/* -------------------------
   2. Criar query dinâmica
------------------------- */
$query = "
    SELECT 
        item.id,
        item.nome AS item_nome,
        item.descricao,
        item.cor,
        item.quantidade,
        estoque.nome AS estoque_nome
    FROM item
    LEFT JOIN estoque ON item.item_estoque = estoque.id
    WHERE 1 = 1
";

$params = [];

// Filtro por nome
if (!empty($filtro_nome)) {
    $query .= " AND item.nome LIKE :nome ";
    $params[':nome'] = "%$filtro_nome%";
}

// Filtro por cor
if (!empty($filtro_cor)) {
    $query .= " AND item.cor = :cor ";
    $params[':cor'] = $filtro_cor;
}

// Filtro por estoque
if (!empty($filtro_estoque)) {
    $query .= " AND item.item_estoque = :estoque ";
    $params[':estoque'] = $filtro_estoque;
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$itens = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* Buscar opções de filtro (estoques e cores) */
$estoques = $pdo->query("SELECT id, nome FROM estoque")->fetchAll(PDO::FETCH_ASSOC);
$cores = $pdo->query("SELECT DISTINCT cor FROM item")->fetchAll(PDO::FETCH_ASSOC);

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

<!-- ===================== -->
<!-- 🔍 FORMULÁRIO DE FILTRO -->
<!-- ===================== -->

<form method="GET" style="margin-bottom:20px;">

    <label>Nome:</label>
    <input type="text" name="nome" value="<?= $filtro_nome ?>">

    <label>Cor:</label>
    <select name="cor">
        <option value="">Todas</option>
        <?php foreach ($cores as $c): ?>
            <option value="<?= $c['cor'] ?>" 
                <?= $filtro_cor === $c['cor'] ? 'selected' : '' ?>>
                <?= $c['cor'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Estoque:</label>
    <select name="estoque">
        <option value="">Todos</option>
        <?php foreach ($estoques as $est): ?>
            <option value="<?= $est['id'] ?>"
                <?= $filtro_estoque == $est['id'] ? 'selected' : '' ?>>
                <?= $est['nome'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Filtrar</button>
    <a href="lista.php">Limpar</a>
</form>

<!-- ===================== -->
<!-- TABELA DOS ITENS -->
<!-- ===================== -->

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>ID</th>
            <th>Item</th>
            <th>Descrição</th>
            <th>Cor</th>
            <th>Quantidade</th>
            <th>Estoque</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($itens as $item): ?>
            <tr>
                <td><?= $item['id'] ?></td>
                <td><?= $item['item_nome'] ?></td>
                <td><?= $item['descricao'] ?></td>
                <td><?= $item['cor'] ?></td>
                <td><?= $item['quantidade'] ?></td>
                <td><?= $item['estoque_nome'] ?: 'Sem estoque' ?></td>
                <td>
                    <a href="edit.php?id=<?= $item['id'] ?>">Editar</a>
                    -
                    <a href="delete.php?id=<?= $item['id'] ?>">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p><a href="index.php">Voltar</a></p>

</body>
</html>
