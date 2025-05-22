<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json"); // <- ESSENCIAL!
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php'; // deve conter $pdo

$input = file_get_contents("php://input");
$data = json_decode($input);

if (!$data || !isset($data->nome, $data->email, $data->senha)) {
    http_response_code(400);
    echo json_encode(["error" => "Dados inválidos ou incompletos"]);
    exit;
}

$nome = $data->nome;
$email = $data->email;
$senha = password_hash($data->senha, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
$stmt = $pdo->prepare($sql);

if ($stmt->execute([$nome, $email, $senha])) {
    echo json_encode(["message" => "Usuário cadastrado!"]);
} else {
    echo json_encode(["error" => "Erro ao cadastrar."]);
}
