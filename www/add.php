<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = $_POST['nome'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $cor = $_POST['cor'] ?? 'não se aplica';
    $estoque_id = $_POST['estoque_id'] ?: null;

    $sql = "INSERT INTO item (nome, descricao, cor, item_estoque)
            VALUES (:nome, :descricao, :cor, :estoque_id)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':nome' => $nome,
        ':descricao' => $descricao,
        ':cor' => $cor,
        ':estoque_id' => $estoque_id
    ]);

    header('Location: index.php');
    exit;
}

// pegar estoques para select
$estoques = $pdo->query("SELECT id, nome FROM estoque ORDER BY nome")->fetchAll();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Adicionar Item</title>
</head>
<body>

<h1>Adicionar item</h1>

<form method="post">

    <label>Nome: 
        <input name="nome" required>
    </label><br><br>

    <label>Descrição:
        <input name="descricao">
    </label><br><br>

    <!-- CAMPO COR ENUM -->
    <label>Cor:
        <select name="cor" required>
            <option value="preto">Preto</option>
            <option value="ciano">Ciano</option>
            <option value="magenta">Magenta</option>
            <option value="amarelo">Amarelo</option>
            <option value="não se aplica" selected>Não se aplica</option>
        </select>
    </label><br><br>

    <!-- SELECT ESTOQUE -->
    <label>Estoque:
        <select name="estoque_id">
            <option value="">-- nenhum --</option>
            <?php foreach($estoques as $e): ?>
                <option value="<?= $e['id'] ?>">
                    <?= htmlspecialchars($e['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label><br><br>

    <button type="submit">Salvar</button>

</form>

<p><a href="index.php">Voltar</a></p>

</body>
</html>
