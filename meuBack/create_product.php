<?php 
include 'config.php';
include 'cors.php'; 
$nome = $_POST['nome']; 
$descricao = $_POST['descricao']; 
$preco = $_POST['preco']; 
$usuario_id = $_POST['usuario_id']; 
$imagem = $_FILES['imagem']; 
$imagem_path = "uploads/" . basename($imagem['name']); 
move_uploaded_file($imagem['tmp_name'], $imagem_path); 
$sql = "INSERT INTO produtos (nome, descricao, preco, imagem, usuario_id) 
VALUES (?, ?, ?, ?, ?)"; 
$stmt = $pdo->prepare($sql); 
$stmt->execute([$nome, $descricao, $preco, $imagem_path, $usuario_id]); 
echo json_encode(["message" => "Produto cadastrado!"]);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

?>
