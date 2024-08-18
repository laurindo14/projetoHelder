<?php
include("conexao.php");

$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'produto';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Adicionar <?= ucfirst($tipo) ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 20px;
        }
        .container {
            max-width: 600px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Adicionar <?= ucfirst($tipo) ?></h1>
        <form action="conexao.php" method="post">
            <?php if ($tipo == 'categoria'): ?>
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" class="form-control" required>
                </div>
            <?php else: ?>
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="preco">Preço:</label>
                    <input type="text" id="preco" name="preco" class="form-control" required pattern="^\d+(\.\d{1,2})?$" title="Formato: 123.45">
                </div>
                <div class="form-group">
                    <label for="id_categoria">Categoria:</label>
                    <select id="id_categoria" name="id_categoria" class="form-control" required>
                        <option value="" disabled selected>Selecione uma categoria</option>
                        <?php
                        // Aqui você deve listar as categorias existentes
                        $categorias = selectAllCategoria();
                        foreach ($categorias as $categoria) {
                            echo '<option value="' . htmlspecialchars($categoria["id"]) . '">' . htmlspecialchars($categoria["nome"]) . '</option>';
                        }
                        ?>
                    </select>
                </div>
            <?php endif; ?>
            <input type="hidden" name="acao" value="inserir<?= ucfirst($tipo) ?>">
            <button type="submit" class="btn btn-primary">Adicionar <?= ucfirst($tipo) ?></button>
        </form>
        <a href="index.php?tipo=<?= $tipo ?>" class="btn btn-secondary mt-3">Voltar</a>
    </div>
</body>
</html>
