-- Schema v1.1 - Sistema de Controle de Mesas do Restaurante
-- Data: 2024-01-15
-- Descrição: Tabelas para gerenciamento de mesas, reservas e histórico
-- Tabela de mesas do restaurante
CREATE TABLE IF NOT EXISTS mesas_restaurante (
    id INT PRIMARY KEY AUTO_INCREMENT,
    numero_mesa INT NOT NULL UNIQUE,
    capacidade INT NOT NULL DEFAULT 4,
    localizacao ENUM(
        'salao_principal',
        'terraco',
        'area_vip',
        'area_externa'
    ) DEFAULT 'salao_principal',
    status ENUM(
        'disponivel',
        'ocupada',
        'reservada',
        'manutencao'
    ) DEFAULT 'disponivel',
    observacoes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_numero_mesa (numero_mesa),
    INDEX idx_localizacao (localizacao)
);
-- Tabela de reservas
CREATE TABLE IF NOT EXISTS reservas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    mesa_id INT NOT NULL,
    cliente_nome VARCHAR(100) NOT NULL,
    cliente_telefone VARCHAR(20) NOT NULL,
    cliente_email VARCHAR(100),
    data_reserva DATE NOT NULL,
    hora_reserva TIME NOT NULL,
    numero_pessoas INT NOT NULL DEFAULT 2,
    observacoes TEXT,
    status ENUM(
        'ativa',
        'confirmada',
        'finalizada',
        'cancelada',
        'nao_compareceu'
    ) DEFAULT 'ativa',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (mesa_id) REFERENCES mesas_restaurante(id) ON DELETE CASCADE,
    INDEX idx_data_reserva (data_reserva),
    INDEX idx_mesa_data (mesa_id, data_reserva),
    INDEX idx_status (status),
    UNIQUE KEY unique_reserva (mesa_id, data_reserva, hora_reserva)
);
-- Tabela de histórico de mudanças de status das mesas
CREATE TABLE IF NOT EXISTS historico_mesas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    mesa_id INT NOT NULL,
    status_anterior ENUM(
        'disponivel',
        'ocupada',
        'reservada',
        'manutencao'
    ),
    status_novo ENUM(
        'disponivel',
        'ocupada',
        'reservada',
        'manutencao'
    ) NOT NULL,
    usuario_id INT,
    observacoes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (mesa_id) REFERENCES mesas_restaurante(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE
    SET NULL,
        INDEX idx_mesa_id (mesa_id),
        INDEX idx_created_at (created_at)
);
-- Inserir algumas mesas de exemplo
INSERT IGNORE INTO mesas_restaurante (numero_mesa, capacidade, localizacao, status)
VALUES (1, 2, 'salao_principal', 'disponivel'),
    (2, 4, 'salao_principal', 'disponivel'),
    (3, 4, 'salao_principal', 'disponivel'),
    (4, 6, 'salao_principal', 'disponivel'),
    (5, 2, 'terraco', 'disponivel'),
    (6, 4, 'terraco', 'disponivel'),
    (7, 8, 'area_vip', 'disponivel'),
    (8, 6, 'area_vip', 'disponivel'),
    (9, 4, 'area_externa', 'disponivel'),
    (10, 2, 'area_externa', 'disponivel');
-- Inserir algumas reservas de exemplo para teste
INSERT IGNORE INTO reservas (
        mesa_id,
        cliente_nome,
        cliente_telefone,
        data_reserva,
        hora_reserva,
        numero_pessoas,
        observacoes
    )
VALUES (
        1,
        'João Silva',
        '(11) 99999-1111',
        CURDATE(),
        '19:00',
        2,
        'Mesa para aniversário'
    ),
    (
        2,
        'Maria Santos',
        '(11) 99999-2222',
        CURDATE(),
        '20:00',
        4,
        'Jantar de negócios'
    ),
    (
        3,
        'Pedro Oliveira',
        '(11) 99999-3333',
        DATE_ADD(CURDATE(), INTERVAL 1 DAY),
        '19:30',
        4,
        ''
    ),
    (
        7,
        'Ana Costa',
        '(11) 99999-4444',
        DATE_ADD(CURDATE(), INTERVAL 2 DAY),
        '21:00',
        6,
        'Comemoração especial - área VIP'
    );
-- Views úteis para relatórios
-- View de mesas com status resumido
CREATE OR REPLACE VIEW v_mesas_status AS
SELECT m.id,
    m.numero_mesa,
    m.capacidade,
    m.localizacao,
    m.status,
    m.observacoes,
    CASE
        WHEN m.status = 'ocupada' THEN 'Ocupada'
        WHEN m.status = 'reservada' THEN CONCAT('Reservada - ', IFNULL(r.cliente_nome, 'N/A'))
        WHEN m.status = 'disponivel' THEN 'Disponível'
        WHEN m.status = 'manutencao' THEN 'Manutenção'
        ELSE 'Indefinido'
    END as status_descricao,
    r.cliente_nome as cliente_atual,
    r.data_reserva,
    r.hora_reserva,
    m.updated_at
FROM mesas_restaurante m
    LEFT JOIN reservas r ON m.id = r.mesa_id
    AND r.data_reserva = CURDATE()
    AND r.status IN ('ativa', 'confirmada')
ORDER BY m.numero_mesa;
-- View de reservas ativas com detalhes
CREATE OR REPLACE VIEW v_reservas_ativas AS
SELECT r.id,
    r.mesa_id,
    m.numero_mesa,
    m.capacidade,
    m.localizacao,
    r.cliente_nome,
    r.cliente_telefone,
    r.data_reserva,
    r.hora_reserva,
    r.numero_pessoas,
    r.observacoes,
    r.status,
    r.created_at,
    DATEDIFF(r.data_reserva, CURDATE()) as dias_para_reserva
FROM reservas r
    JOIN mesas_restaurante m ON r.mesa_id = m.id
WHERE r.status IN ('ativa', 'confirmada')
    AND r.data_reserva >= CURDATE()
ORDER BY r.data_reserva,
    r.hora_reserva;
-- Triggers para automação
-- Trigger para atualizar status da mesa quando reserva é criada
DELIMITER // CREATE TRIGGER tr_reserva_created
AFTER
INSERT ON reservas FOR EACH ROW BEGIN -- Se a reserva é para hoje, marcar mesa como reservada
    IF NEW.data_reserva = CURDATE()
    AND NEW.status = 'ativa' THEN
UPDATE mesas_restaurante
SET status = 'reservada'
WHERE id = NEW.mesa_id;
END IF;
END // DELIMITER;
-- Trigger para registrar histórico quando status da mesa muda
DELIMITER // CREATE TRIGGER tr_mesa_status_history
AFTER
UPDATE ON mesas_restaurante FOR EACH ROW BEGIN IF OLD.status != NEW.status THEN
INSERT INTO historico_mesas (
        mesa_id,
        status_anterior,
        status_novo,
        created_at
    )
VALUES (NEW.id, OLD.status, NEW.status, NOW());
END IF;
END // DELIMITER;
-- Procedures úteis
-- Procedure para liberar mesas após horário de reserva
DELIMITER // CREATE PROCEDURE sp_liberar_mesas_vencidas() BEGIN -- Liberar mesas reservadas cujo horário já passou
UPDATE mesas_restaurante m
    JOIN reservas r ON m.id = r.mesa_id
SET m.status = 'disponivel'
WHERE m.status = 'reservada'
    AND r.data_reserva = CURDATE()
    AND r.hora_reserva < CURTIME()
    AND r.status = 'ativa'
    AND TIMEDIFF(CURTIME(), r.hora_reserva) > '01:00:00';
-- 1 hora de tolerância
-- Marcar reservas como não compareceu
UPDATE reservas
SET status = 'nao_compareceu'
WHERE data_reserva = CURDATE()
    AND hora_reserva < CURTIME()
    AND status = 'ativa'
    AND TIMEDIFF(CURTIME(), hora_reserva) > '01:00:00';
END // DELIMITER;
-- Procedure para estatísticas das mesas
DELIMITER // CREATE PROCEDURE sp_estatisticas_mesas() BEGIN
SELECT 'Total de Mesas' as categoria,
    COUNT(*) as quantidade
FROM mesas_restaurante
UNION ALL
SELECT CONCAT('Mesas ', UPPER(status)) as categoria,
    COUNT(*) as quantidade
FROM mesas_restaurante
GROUP BY status
UNION ALL
SELECT 'Reservas Hoje' as categoria,
    COUNT(*) as quantidade
FROM reservas
WHERE data_reserva = CURDATE()
    AND status IN ('ativa', 'confirmada');
END // DELIMITER;
COMMIT;