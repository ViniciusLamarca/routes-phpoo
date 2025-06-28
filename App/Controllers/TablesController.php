<?php

namespace App\Controllers;

class TablesController extends Controller
{
    /**
     * Página principal do controle de mesas
     */
    public function index()
    {
        $status = $_GET['status'] ?? 'all';

        try {
            // Tentar conectar ao banco
            $pdo = new \PDO('mysql:host=localhost;dbname=service_db;charset=utf8mb4', 'root', '', [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
            ]);

            // Verificar se a tabela mesas_restaurante existe
            $stmt = $pdo->query("SHOW TABLES LIKE 'mesas_restaurante'");
            if ($stmt->rowCount() > 0) {
                // Buscar mesas do banco de dados
                $sql = "SELECT * FROM mesas_restaurante";
                $params = [];

                if ($status !== 'all') {
                    $sql .= " WHERE status = :status";
                    $params['status'] = $status;
                }

                $sql .= " ORDER BY numero_mesa";

                $stmt = $pdo->prepare($sql);
                $stmt->execute($params);
                $mesas = $stmt->fetchAll();

                // Estatísticas das mesas
                $stmt = $pdo->query("SELECT status, COUNT(*) as count FROM mesas_restaurante GROUP BY status");
                $results = $stmt->fetchAll();

                $stats = ['disponivel' => 0, 'ocupada' => 0, 'reservada' => 0, 'manutencao' => 0];
                foreach ($results as $result) {
                    $stats[$result['status']] = $result['count'];
                }
            } else {
                // Tabelas não existem ainda
                $mesas = [];
                $stats = ['disponivel' => 0, 'ocupada' => 0, 'reservada' => 0, 'manutencao' => 0];
            }
        } catch (\Exception $e) {
            // Erro de conexão ou tabelas não existem
            $mesas = [];
            $stats = ['disponivel' => 0, 'ocupada' => 0, 'reservada' => 0, 'manutencao' => 0];
        }

        return $this->view('tables', [
            'title' => 'Controle de Mesas',
            'current_page' => 'Controle de Mesas',
            'page' => 'tables.php',
            'mesas' => $mesas,
            'status_filter' => $status,
            'stats' => $stats
        ]);
    }

    /**
     * Página de reservas
     */
    public function reservations()
    {
        try {
            // Tentar conectar ao banco
            $pdo = new \PDO('mysql:host=localhost;dbname=service_db;charset=utf8mb4', 'root', '', [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
            ]);

            // Verificar se as tabelas existem
            $stmt = $pdo->query("SHOW TABLES LIKE 'reservas'");
            if ($stmt->rowCount() > 0) {
                // Buscar reservas ativas
                $stmt = $pdo->query("
                    SELECT r.*, m.numero_mesa, m.capacidade 
                    FROM reservas r 
                    JOIN mesas_restaurante m ON r.mesa_id = m.id
                    WHERE r.data_reserva >= CURDATE()
                    ORDER BY r.data_reserva, r.hora_reserva
                ");
                $reservas = $stmt->fetchAll();

                // Buscar mesas disponíveis
                $stmt = $pdo->query("
                    SELECT * FROM mesas_restaurante 
                    WHERE status = 'disponivel' 
                    ORDER BY numero_mesa
                ");
                $mesas_disponiveis = $stmt->fetchAll();
            } else {
                // Tabelas não existem ainda
                $reservas = [];
                $mesas_disponiveis = [];
            }
        } catch (\Exception $e) {
            // Erro de conexão ou tabelas não existem
            $reservas = [];
            $mesas_disponiveis = [];
        }

        return $this->view('reservations', [
            'title' => 'Reservas',
            'current_page' => 'Reservas',
            'page' => 'reservations.php',
            'reservas' => $reservas,
            'mesas_disponiveis' => $mesas_disponiveis
        ]);
    }

    /**
     * Atualizar status de uma mesa
     */
    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');

            try {
                $pdo = new \PDO('mysql:host=localhost;dbname=service_db;charset=utf8mb4', 'root', '', [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
                ]);

                $mesa_id = $_POST['mesa_id'] ?? null;
                $novo_status = $_POST['status'] ?? null;

                if (!$mesa_id || !$novo_status) {
                    throw new \Exception('Dados obrigatórios não informados');
                }

                // Verificar se a tabela existe
                $stmt = $pdo->query("SHOW TABLES LIKE 'mesas_restaurante'");
                if ($stmt->rowCount() === 0) {
                    throw new \Exception('Sistema não ativado');
                }

                // Atualizar status da mesa
                $stmt = $pdo->prepare("UPDATE mesas_restaurante SET status = ?, updated_at = NOW() WHERE id = ?");
                $stmt->execute([$novo_status, $mesa_id]);

                if ($stmt->rowCount() > 0) {
                    echo json_encode(['success' => true, 'message' => 'Status atualizado com sucesso']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Mesa não encontrada']);
                }
            } catch (\Exception $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        } else {
            header('Location: tables.php');
            exit;
        }
    }

    /**
     * Criar nova reserva
     */
    public function createReservation()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');

            try {
                $pdo = new \PDO('mysql:host=localhost;dbname=service_db;charset=utf8mb4', 'root', '', [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
                ]);

                $mesa_id = $_POST['mesa_id'] ?? null;
                $cliente_nome = $_POST['cliente_nome'] ?? null;
                $cliente_telefone = $_POST['cliente_telefone'] ?? null;
                $data_reserva = $_POST['data_reserva'] ?? null;
                $hora_reserva = $_POST['hora_reserva'] ?? null;
                $numero_pessoas = $_POST['numero_pessoas'] ?? null;

                if (!$mesa_id || !$cliente_nome || !$data_reserva || !$hora_reserva) {
                    throw new \Exception('Dados obrigatórios não informados');
                }

                // Verificar se as tabelas existem
                $stmt = $pdo->query("SHOW TABLES LIKE 'reservas'");
                if ($stmt->rowCount() === 0) {
                    throw new \Exception('Sistema não ativado');
                }

                // Verificar se a mesa está disponível na data/hora
                $stmt = $pdo->prepare("
                    SELECT COUNT(*) as count 
                    FROM reservas 
                    WHERE mesa_id = ? AND data_reserva = ? AND hora_reserva = ? AND status = 'confirmada'
                ");
                $stmt->execute([$mesa_id, $data_reserva, $hora_reserva]);
                $result = $stmt->fetch();

                if ($result['count'] > 0) {
                    throw new \Exception('Mesa já reservada para este horário');
                }

                // Criar reserva
                $stmt = $pdo->prepare("
                    INSERT INTO reservas (mesa_id, cliente_nome, cliente_telefone, data_reserva, hora_reserva, numero_pessoas, status)
                    VALUES (?, ?, ?, ?, ?, ?, 'confirmada')
                ");
                $stmt->execute([$mesa_id, $cliente_nome, $cliente_telefone, $data_reserva, $hora_reserva, $numero_pessoas]);

                echo json_encode(['success' => true, 'message' => 'Reserva criada com sucesso']);
            } catch (\Exception $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        } else {
            header('Location: reservations.php');
            exit;
        }
    }
}
