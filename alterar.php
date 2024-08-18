<?php
include("conexao.php");

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'produto';

// Verifica se o tipo é válido e seleciona o item correspondente
if ($tipo == 'categoria') {
    $item = selectIdCategoria($id);
} else {
    $item = selectIdProduto($id);
}

// Verifica se o item foi encontrado
if (!$item) {
    die("Item não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar <?= ucfirst($tipo) ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Editar <?= ucfirst($tipo) ?></h1>
        <form action="conexao.php" method="post">
            <?php if ($tipo == 'categoria'): ?>
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" class="form-control" value="<?= htmlspecialchars($item["nome"], ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
            <?php else: ?>
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" class="form-control" value="<?= htmlspecialchars($item["nome"], ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
                <div class="form-group">
                    <label for="preco">Preço:</label>
                    <input type="text" id="preco" name="preco" class="form-control" value="<?= htmlspecialchars(number_format($item["preco"], 2, ',', '.'), ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
                <div class="form-group">
                    <label for="id_categoria">Categoria:</label>
                    <select id="id_categoria" name="id_categoria" class="form-control" required>
                        <?php
                        $categorias = selectAllCategoria();
                        foreach ($categorias as $categoria) {
                            $selected = $categoria["id"] == $item["id_categoria"] ? ' selected' : '';
                            echo '<option value="' . htmlspecialchars($categoria["id"], ENT_QUOTES, 'UTF-8') . '"' . $selected . '>' . htmlspecialchars($categoria["nome"], ENT_QUOTES, 'UTF-8') . '</option>';
                        }
                        ?>
                    </select>
                </div>
            <?php endif; ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($item["id"], ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="acao" value="alterar<?= ucfirst($tipo) ?>">
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>
    </div>
</body>
</html>
