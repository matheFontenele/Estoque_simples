<?php
require 'config.php';

// buscar todos os estoques
$stmt = $pdo->query("SELECT id, nome, endereco, data_cadastro FROM estoque ORDER BY id DESC");
$estoques = $stmt->fetchAll();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Estoques</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h1>Lista de Estoques</h1>

  <p>
    <a href="index.php">← Voltar (Itens)</a> |
    <a href="estoque_add.php">➕ Adicionar Estoque</a> |
    <a href="view.php">Itens</a>
  </p>

  <table border="1" cellpadding="8" cellspacing="0">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Endereço</th>
        <th>Data Cadastro</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php if (count($estoques) === 0): ?>
        <tr><td colspan="5">Nenhum estoque cadastrado.</td></tr>
      <?php else: ?>
        <?php foreach ($estoques as $e): ?>
          <tr>
            <td><?= htmlspecialchars($e['id']) ?></td>
            <td><?= htmlspecialchars($e['nome']) ?></td>
            <td><?= htmlspecialchars($e['endereco']) ?></td>
            <td><?= htmlspecialchars($e['data_cadastro']) ?></td>
            <td>
              <a href="estoque_edit.php?id=<?= $e['id'] ?>">Editar</a> |
              <a href="estoque_delete.php?id=<?= $e['id'] ?>" onclick="return confirm('Excluir estoque?')">Excluir</a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</body>
</html>
