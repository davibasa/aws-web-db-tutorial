<?php
// SamplePage.php - Página de exemplo para tutorial AWS Web DB

// Configuração de conexão com banco de dados
$host = $_ENV['DB_HOST'] ?? 'localhost';
$dbname = $_ENV['DB_NAME'] ?? 'tutorial_db';
$username = $_ENV['DB_USER'] ?? 'root';
$password = $_ENV['DB_PASS'] ?? '';

try {
    // Conexão com banco de dados usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Query de exemplo
    $stmt = $pdo->query("SELECT 'Conexão realizada com sucesso!' as message");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    $error_message = "Erro na conexão: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutorial AWS Web DB - Página de Exemplo</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .success { color: green; background: #e8f5e8; padding: 15px; border-radius: 5px; }
        .error { color: red; background: #ffe8e8; padding: 15px; border-radius: 5px; }
        h1 { color: #333; }
        .info { background: #f0f8ff; padding: 15px; border-radius: 5px; margin: 20px 0; }
    </style>
</head>
<body>
    <h1>Tutorial AWS Web DB - Página de Exemplo</h1>
    
    <div class="info">
        <h2>Status da Conexão</h2>
        <?php if (isset($result)): ?>
            <div class="success"><?= htmlspecialchars($result['message']) ?></div>
        <?php elseif (isset($error_message)): ?>
            <div class="error"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>
    </div>
    
    <div class="info">
        <h2>Informações do Sistema</h2>
        <p><strong>Servidor:</strong> <?= htmlspecialchars($_SERVER['HTTP_HOST'] ?? 'N/A') ?></p>
        <p><strong>PHP Version:</strong> <?= PHP_VERSION ?></p>
        <p><strong>Data/Hora:</strong> <?= date('d/m/Y H:i:s') ?></p>
    </div>
    
    <div class="info">
        <h2>Links Úteis</h2>
        <ul>
            <li><a href="Produtos.php">Gerenciamento de Produtos</a></li>
        </ul>
    </div>
</body>
</html>
