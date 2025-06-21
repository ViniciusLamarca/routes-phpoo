<?php
// Script temporário para diagnosticar a estrutura da tabela usuarios

require_once 'vendor/autoload.php';

use app\dataBase\connection;

try {
    $pdo = connection::connect();

    // Verificar se a tabela usuarios existe
    $stmt = $pdo->query("SHOW TABLES LIKE 'usuarios'");
    if ($stmt->rowCount() == 0) {
        echo "❌ Tabela 'usuarios' não encontrada!<br>";
        echo "📝 Você disse que tem a tabela 'usuarios', mas não foi encontrada no banco 'service_db'<br><br>";

        echo "🔧 Verifique:<br>";
        echo "• Se está no banco correto (service_db)<br>";
        echo "• Se a tabela realmente existe<br>";
        echo "• Se a conexão está correta<br>";
    } else {
        echo "✅ Tabela 'usuarios' encontrada!<br><br>";

        // Mostrar estrutura da tabela
        $stmt = $pdo->query("DESCRIBE usuarios");
        echo "📋 Estrutura da tabela usuarios:<br>";
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
        echo "<tr style='background-color: #f0f0f0;'><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Chave</th><th>Padrão</th></tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td><strong>" . $row['Field'] . "</strong></td>";
            echo "<td>" . $row['Type'] . "</td>";
            echo "<td>" . $row['Null'] . "</td>";
            echo "<td>" . $row['Key'] . "</td>";
            echo "<td>" . ($row['Default'] ?? 'NULL') . "</td>";
            echo "</tr>";
        }
        echo "</table><br>";

        // Mostrar usuários existentes (sem senhas)
        $stmt = $pdo->query("SELECT id_usuario, username, email, cargo, status FROM usuarios ORDER BY id_usuario");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "👥 Usuários cadastrados (" . count($users) . " total):<br>";
        if (count($users) == 0) {
            echo "❌ Nenhum usuário encontrado!<br>";
            echo "👤 Para criar um usuário admin de teste:<br>";
            echo "<pre style='background-color: #f5f5f5; padding: 10px; border-radius: 5px;'>";
            echo "INSERT INTO usuarios (username, email, senha, cargo, data_contratacao, status) VALUES 
('admin', 'admin@admin.com', '" . password_hash('admin', PASSWORD_DEFAULT) . "', 'ADMINISTRADOR', CURDATE(), 'ativo');";
            echo "</pre>";
        } else {
            echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
            echo "<tr style='background-color: #f0f0f0;'><th>ID</th><th>Username</th><th>Email</th><th>Cargo</th><th>Status</th></tr>";
            foreach ($users as $user) {
                $statusColor = $user['status'] == 'ativo' ? 'green' : 'red';
                echo "<tr>";
                echo "<td>" . $user['id_usuario'] . "</td>";
                echo "<td><strong>" . htmlspecialchars($user['username']) . "</strong></td>";
                echo "<td>" . htmlspecialchars($user['email']) . "</td>";
                echo "<td>" . htmlspecialchars($user['cargo']) . "</td>";
                echo "<td style='color: {$statusColor};'>" . ucfirst($user['status']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";

            echo "<br>🔐 <strong>Para testar o login:</strong><br>";
            echo "• Use qualquer <strong>username</strong> ou <strong>email</strong> da tabela acima<br>";
            echo "• Use a senha correspondente (se você souber)<br>";
            echo "• O sistema aceita ambos os formatos de login<br>";
        }
    }
} catch (Exception $e) {
    echo "❌ Erro: " . $e->getMessage() . "<br>";
    echo "📝 Verifique se:<br>";
    echo "• O Laragon/MySQL está rodando<br>";
    echo "• O banco 'service_db' existe<br>";
    echo "• As credenciais de conexão estão corretas<br>";
}
