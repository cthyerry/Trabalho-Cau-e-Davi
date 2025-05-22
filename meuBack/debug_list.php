<?php
include 'config.php';

// Verificar conexão
echo "Conexão com o banco de dados OK<br>";

// Verificar se há produtos
$sql = "SELECT COUNT(*) as total FROM produtos";
$stmt = $pdo->query($sql);
$total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
echo "Total de produtos: " . $total . "<br>";

// Listar produtos em formato simples
$sql = "SELECT * FROM produtos";
$stmt = $pdo->query($sql);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";
print_r($produtos);
echo "</pre>";
?>
