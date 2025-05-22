<?php
// Arquivo para atualizar um produto existente
include 'config.php';

// Verificar se é uma requisição PUT
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Método não permitido"]);
    exit;
}

// Obter dados do formulário
$id = $_POST['id'];
$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$preco = $_POST['preco'];

// Verificar se há uma nova imagem
$imagem_path = null;
if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
    $imagem = $_FILES['imagem'];
    $imagem_path = "uploads/" . basename($imagem['name']);
    move_uploaded_file($imagem['tmp_name'], $imagem_path);
    
    // Atualizar com nova imagem
    $sql = "UPDATE produtos SET nome = ?, descricao = ?, preco = ?, imagem = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $descricao, $preco, $imagem_path, $id]);
} else {
    // Atualizar sem alterar a imagem
    $sql = "UPDATE produtos SET nome = ?, descricao = ?, preco = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $descricao, $preco, $id]);
}

echo json_encode(["message" => "Produto atualizado com sucesso!"]);
?>
