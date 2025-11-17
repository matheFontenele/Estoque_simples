<?php
require 'config.php';

if (!isset($_GET['id'])) {
    die('ID não informado.');
}
$id = (int) $_GET['id'];

// buscar estoque
$stmt = $pdo->prepare("SELECT id, nome, endereco FROM estoque WHERE id = ?");
$stmt->execute([$id]);
$estoque = $stmt->fetch();

if (!$estoque) {
    die('Estoque não encontrado.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $endereco = trim($_POST['endereco'] ?? '');

    if ($nome === '' || $endereco === '') {
        $error = "Nome e endereço são obrigatórios.";
    } else {
        $upd = $pdo->prepare("UPDATE estoque SET nome = :nome, endereco = :endereco WHERE id = :id");
        $upd->execute([':nome' => $nome, ':endereco' => $endereco, ':id' => $id]);
        header('Location: estoque_index.php');
        exit;
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Editar Estoque</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h1>Editar Estoque</h1>

  <?php if (!empty($error)): ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

  <form method="post">
    <label>Nome:<br>
      <input type="text" name="nome" value="<?= htmlspecialchars($estoque['nome']) ?>" required>
    </label><br><br>

    <label>Endereço:<br>
      <input type="text" name="endereco" value="<?= htmlspecialchars($estoque['endereco']) ?>" required>
    </label><br><br>

    <button type="submit">Salvar</button>
    <a href="estoque_index.php">Cancelar</a>
  </form>
</body>
</html>
