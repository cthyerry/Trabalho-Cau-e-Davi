<?php
// Arquivo para obter detalhes de um produto específico
include 'config.php';

// Verificar se o ID foi fornecido
if (!isset($_GET['id'])) {
    echo json_encode(["error" => "ID do produto não fornecido"]);
    exit;
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM produtos WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if ($produto) {
    echo json_encode($produto);
} else {
    echo json_encode(["error" => "Produto não encontrado"]);
}
?>
