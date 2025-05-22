<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php'; // deve conter a conexão $pdo

// Lê o corpo da requisição
$input = file_get_contents("php://input");
$data = json_decode($input);

// Valida os dados recebidos
if (!$data || !isset($data->email, $data->senha)) {
    http_response_code(400);
    echo json_encode(["error" => "Dados inválidos ou incompletos"]);
    exit;
}

$email = $data->email;
$senha = $data->senha;

// Busca o usuário pelo email
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($senha, $user['senha'])) {
    echo json_encode([
        "message" => "Login realizado com sucesso",
        "usuario" => [
            "id" => $user["id"],
            "nome" => $user["nome"],
            "email" => $user["email"]
        ]
    ]);
} else {
    http_response_code(401);
    echo json_encode(["error" => "Email ou senha inválidos"]);
}
