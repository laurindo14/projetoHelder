<?php

// Verifica se o POST existe antes de inserir, alterar ou excluir uma categoria ou produto
if (isset($_POST["acao"])) {
    switch ($_POST["acao"]) {
        case "inserirCategoria":
            inserirCategoria();
            break;
        case "inserirProduto":
            inserirProduto();
            break;
        case "alterarCategoria":
            alterarCategoria();
            break;
        case "alterarProduto":
            alterarProduto();
            break;
        case "excluirCategoria":
            excluirCategoria();
            break;
        case "excluirProduto":
            excluirProduto();
            break;
    }
}

// Responsável por criar uma conexão com o banco
function abrirBanco() {
    $conexao = new mysqli("localhost", "root", "", "mercado2");
    if ($conexao->connect_error) {
        die("Conexão falhou: " . $conexao->connect_error);
    }
    return $conexao;
}

// Função responsável por inserir uma categoria no banco de dados
function inserirCategoria() {
    $banco = abrirBanco();
    $stmt = $banco->prepare("INSERT INTO categoria(nome) VALUES (?)");
    $stmt->bind_param("s", $_POST["nome"]);
    $stmt->execute();
    $stmt->close();
    $banco->close();
    voltarIndex();
}

// Função responsável por inserir um produto no banco de dados
function inserirProduto() {
    $banco = abrirBanco();
    $stmt = $banco->prepare("INSERT INTO produto(nome, preco, id_categoria) VALUES (?, ?, ?)");
    $stmt->bind_param("sdi", $_POST["nome"], $_POST["preco"], $_POST["id_categoria"]);
    $stmt->execute();
    $stmt->close();
    $banco->close();
    voltarIndex();
}

// Função responsável por alterar uma categoria no banco de dados
function alterarCategoria() {
    $banco = abrirBanco();
    $stmt = $banco->prepare("UPDATE categoria SET nome=? WHERE id=?");
    $stmt->bind_param("si", $_POST["nome"], $_POST["id"]);
    $stmt->execute();
    $stmt->close();
    $banco->close();
    voltarIndex();
}

// Função responsável por alterar um produto no banco de dados
function alterarProduto() {
    $banco = abrirBanco();
    $stmt = $banco->prepare("UPDATE produto SET nome=?, preco=?, id_categoria=? WHERE id=?");
    $stmt->bind_param("sdii", $_POST["nome"], $_POST["preco"], $_POST["id_categoria"], $_POST["id"]);
    $stmt->execute();
    $stmt->close();
    $banco->close();
    voltarIndex();
}

// Função responsável por excluir uma categoria no banco de dados
function excluirCategoria() {
    $banco = abrirBanco();
    $stmt = $banco->prepare("DELETE FROM categoria WHERE id=?");
    $stmt->bind_param("i", $_POST["id"]);
    $stmt->execute();
    $stmt->close();
    $banco->close();
    voltarIndex();
}

// Função responsável por excluir um produto no banco de dados
function excluirProduto() {
    $banco = abrirBanco();
    $stmt = $banco->prepare("DELETE FROM produto WHERE id=?");
    $stmt->bind_param("i", $_POST["id"]);
    $stmt->execute();
    $stmt->close();
    $banco->close();
    voltarIndex();
}

// Função para selecionar todas as categorias
function selectAllCategoria() {
    $banco = abrirBanco();
    $stmt = $banco->prepare("SELECT * FROM categoria ORDER BY nome");
    $stmt->execute();
    $resultado = $stmt->get_result();
    $grupo = $resultado->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $banco->close();
    return $grupo;
}

// Função para selecionar todos os produtos
function selectAllProduto() {
    $banco = abrirBanco();
    $stmt = $banco->prepare("SELECT p.*, c.nome AS categoria FROM produto p JOIN categoria c ON p.id_categoria = c.id ORDER BY p.nome");
    $stmt->execute();
    $resultado = $stmt->get_result();
    $grupo = $resultado->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $banco->close();
    return $grupo;
}

// Função para selecionar uma categoria por ID
function selectIdCategoria($id) {
    $banco = abrirBanco();
    $stmt = $banco->prepare("SELECT * FROM categoria WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $categoria = $resultado->fetch_assoc();
    $stmt->close();
    $banco->close();
    return $categoria;
}

// Função para selecionar um produto por ID
function selectIdProduto($id) {
    $banco = abrirBanco();
    $stmt = $banco->prepare("SELECT p.*, c.nome AS categoria FROM produto p JOIN categoria c ON p.id_categoria = c.id WHERE p.id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $produto = $resultado->fetch_assoc();
    $stmt->close();
    $banco->close();
    return $produto;
}

// Após inserir, alterar ou excluir, retorna para a página principal
function voltarIndex() {
    header("Location: index.php");
    exit();
}

?>
