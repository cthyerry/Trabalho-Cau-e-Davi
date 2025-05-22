<?php
include 'config.php';
include 'cors.php';
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Parâmetros de paginação
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 5;
$offset = ($page - 1) * $limit;

// Consulta para obter produtos com paginação
$sql = "SELECT * FROM produtos ORDER BY id DESC LIMIT ? OFFSET ?";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(1, $limit, PDO::PARAM_INT);
$stmt->bindParam(2, $offset, PDO::PARAM_INT);
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Consulta para contar o total de produtos
$sql_count = "SELECT COUNT(*) as total FROM produtos";
$stmt_count = $pdo->query($sql_count);
$total_produtos = $stmt_count->fetch(PDO::FETCH_ASSOC)['total'];
$total_pages = ceil($total_produtos / $limit);

// Formatar a URL das imagens para acesso completo
foreach ($produtos as &$produto) {
    if (!empty($produto['imagem'])) {
        // Construir URL completa para a imagem
        $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http" ) . "://$_SERVER[HTTP_HOST]";
        $dir_path = dirname($_SERVER['REQUEST_URI']);
        $produto['imagem_url'] = $base_url . $dir_path . '/' . $produto['imagem'];
    } else {
        $produto['imagem_url'] = null;
    }
}

echo json_encode([
    "produtos" => $produtos,
    "paginacao" => [
        "pagina_atual" => $page,
        "total_paginas" => $total_pages,
        "itens_por_pagina" => $limit,
        "total_itens" => $total_produtos
    ]
]);
?>
