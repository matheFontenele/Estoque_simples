<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $endereco = trim($_POST['endereco'] ?? '');

    if ($nome === '' || $endereco === '') {
        $error = "Nome e endereço são obrigatórios.";
    } else {
        $sql = "INSERT INTO estoque (nome, endereco) VALUES (:nome, :endereco)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':nome' => $nome, ':endereco' => $endereco]);
        header('Location: estoque_index.php');
        exit;
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Adicionar Estoque</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h1>Adicionar Estoque</h1>

  <?php if (!empty($error)): ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

  <form method="post">
    <label>Nome:<br>
      <input type="text" name="nome" required>
    </label><br><br>

    <label>Endereço:<br>
      <input type="text" name="endereco" required>
    </label><br><br>

    <button type="submit">Salvar</button>
    <a href="estoque_index.php">Cancelar</a>
  </form>
</body>
</html>
