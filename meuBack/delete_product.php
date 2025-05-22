<?php
// Arquivo para excluir um produto
include 'config.php';

// Verificar se o ID foi fornecido
if (!isset($_POST['id'])) {
    echo json_encode(["error" => "ID do produto não fornecido"]);
    exit;
}

$id = intval($_POST['id']);
$usuario_id = intval($_POST['usuario_id']); // Para verificar se o usuário tem permissão

// Verificar se o produto pertence ao usuário
$check_sql = "SELECT * FROM produtos WHERE id = ? AND usuario_id = ?";
$check_stmt = $pdo->prepare($check_sql);
$check_stmt->execute([$id, $usuario_id]);
$produto = $check_stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    echo json_encode(["error" => "Produto não encontrado ou você não tem permissão para excluí-lo"]);
    exit;
}

// Excluir o produto
$sql = "DELETE FROM produtos WHERE id = ?";
$stmt = $pdo->prepare($sql);

if ($stmt->execute([$id])) {
    // Se o produto tiver imagem, excluir o arquivo
    if (!empty($produto['imagem']) && file_exists($produto['imagem'])) {
        unlink($produto['imagem']);
    }
    
    echo json_encode(["message" => "Produto excluído com sucesso!"]);
} else {
    echo json_encode(["error" => "Erro ao excluir o produto"]);
}
?>
