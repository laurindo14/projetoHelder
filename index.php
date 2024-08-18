<?php 
include("conexao.php");

// Define o tipo de dado (categoria ou produto) baseado no parâmetro da URL
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'produto';

// Função para selecionar dados dependendo do tipo
if ($tipo == 'categoria') {
    $grupo = selectAllCategoria();
    $headers = ['Nome', 'Editar', 'Excluir'];
    $acaoExcluir = 'excluirCategoria';
    $acaoEditar = 'editarCategoria';
} else {
    $grupo = selectAllProduto();
    $headers = ['Nome', 'Preço', 'Categoria', 'Editar', 'Excluir'];
    $acaoExcluir = 'excluirProduto';
    $acaoEditar = 'editarProduto';
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>CRUD com PHP e MYSQL - <?= ucfirst($tipo) ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="text-center my-4">
            <h1><?= ucfirst($tipo) ?>s</h1>
            <a href="index.php?tipo=<?= $tipo == 'categoria' ? 'produto' : 'categoria' ?>" class="btn btn-secondary">
                Ver <?= $tipo == 'categoria' ? 'Produtos' : 'Categorias' ?>
            </a>
        </div>
        
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <?php foreach ($headers as $header) : ?>
                        <th><?= htmlspecialchars($header) ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($grupo as $item) : ?>
                    <tr>
                        <?php if ($tipo == 'categoria') : ?>
                            <td><?= htmlspecialchars($item["nome"]) ?></td>
                            <td>
                                <form action="alterar.php" method="post" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($item["id"]) ?>">
                                    <input type="submit" name="editar" value="Editar" class="btn btn-warning btn-sm">
                                </form>
                            </td>
                            <td>
                                <form action="conexao.php" method="post" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($item["id"]) ?>">
                                    <input type="hidden" name="acao" value="<?= htmlspecialchars($acaoExcluir) ?>">
                                    <input type="submit" name="excluir" value="Excluir" class="btn btn-danger btn-sm">
                                </form>
                            </td>
                        <?php else : ?>
                            <td><?= htmlspecialchars($item["nome"]) ?></td>
                            <td><?= number_format($item["preco"], 2, ',', '.') ?></td>
                            <td><?= htmlspecialchars($item["categoria"]) ?></td>
                            <td>
                                <form action="alterar.php" method="post" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($item["id"]) ?>">
                                    <input type="submit" name="editar" value="Editar" class="btn btn-warning btn-sm">
                                </form>
                            </td>
                            <td>
                                <form action="conexao.php" method="post" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($item["id"]) ?>">
                                    <input type="hidden" name="acao" value="<?= htmlspecialchars($acaoExcluir) ?>">
                                    <input type="submit" name="excluir" value="Excluir" class="btn btn-danger btn-sm">
                                </form>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="text-center my-4">
            <a href="inserir.php?tipo=<?= $tipo ?>" class="btn btn-primary">Adicionar <?= ucfirst($tipo) ?></a>
        </div>
    </div>
</body>
</html>
