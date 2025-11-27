<?php
require 'config.php';


$estoques = $pdo->query("SELECT id, nome FROM estoque ORDER BY nome")->fetchAll();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Alucom Estoque</title>
</head>
<body>
    <section>
        <h1>Sistema de estoque Alucom</h1>
        <button><a href="view.php">Visualizar Itens</a></button>
        <button><a href="estoque_index.php">Visualizar Estoques</a></button>
        <button><a href="add_item.php">Gerenciar Itens</a></button>
    </section>
</body>
</html>

