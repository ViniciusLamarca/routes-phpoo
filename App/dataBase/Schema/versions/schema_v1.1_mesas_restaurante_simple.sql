-- Schema simplificado do Sistema de Mesas v1.1
-- Versão sem triggers complexos para importação segura
-- Criar tabela de mesas do restaurante
CREATE TABLE IF NOT EXISTS mesas_restaurante (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_mesa VARCHAR(10) NOT NULL UNIQUE,
    capacidade INT NOT NULL DEFAULT 4,
    status ENUM(
        'disponivel',
        'ocupada',
        'reservada',
        'manutencao'
    ) NOT NULL DEFAULT 'disponivel',
    localizacao VARCHAR(100) DEFAULT NULL,
    observacoes TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
-- Criar tabela de reservas
CREATE TABLE IF NOT EXISTS reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mesa_id INT NOT NULL,
    cliente_nome VARCHAR(100) NOT NULL,
    cliente_telefone VARCHAR(20) DEFAULT NULL,
    cliente_email VARCHAR(100) DEFAULT NULL,
    data_reserva DATE NOT NULL,
    hora_reserva TIME NOT NULL,
    numero_pessoas INT NOT NULL DEFAULT 1,
    status ENUM(
        'confirmada',
        'cancelada',
        'finalizada',
        'pendente'
    ) NOT NULL DEFAULT 'confirmada',
    observacoes TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (mesa_id) REFERENCES mesas_restaurante(id) ON DELETE CASCADE
);
-- Criar tabela de histórico de mesas
CREATE TABLE IF NOT EXISTS historico_mesas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mesa_id INT NOT NULL,
    status_anterior VARCHAR(20) DEFAULT NULL,
    status_novo VARCHAR(20) NOT NULL,
    usuario VARCHAR(50) DEFAULT 'sistema',
    observacoes TEXT DEFAULT NULL,
    data_alteracao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (mesa_id) REFERENCES mesas_restaurante(id) ON DELETE CASCADE
);
-- Inserir dados iniciais de mesas
INSERT IGNORE INTO mesas_restaurante (numero_mesa, capacidade, status, localizacao)
VALUES ('01', 2, 'disponivel', 'Área Principal'),
    ('02', 4, 'disponivel', 'Área Principal'),
    ('03', 4, 'ocupada', 'Área Principal'),
    ('04', 6, 'disponivel', 'Área Principal'),
    ('05', 2, 'reservada', 'Área da Janela'),
    ('06', 4, 'disponivel', 'Área da Janela'),
    ('07', 8, 'disponivel', 'Área VIP'),
    ('08', 4, 'manutencao', 'Área Principal'),
    ('09', 6, 'disponivel', 'Área Externa'),
    ('10', 4, 'disponivel', 'Área Externa');
-- Inserir algumas reservas de exemplo
INSERT IGNORE INTO reservas (
        mesa_id,
        cliente_nome,
        cliente_telefone,
        data_reserva,
        hora_reserva,
        numero_pessoas,
        status
    )
VALUES (
        5,
        'João Silva',
        '(11) 99999-1234',
        CURDATE(),
        '19:00:00',
        2,
        'confirmada'
    ),
    (
        7,
        'Maria Santos',
        '(11) 88888-5678',
        DATE_ADD(CURDATE(), INTERVAL 1 DAY),
        '20:30:00',
        6,
        'confirmada'
    ),
    (
        2,
        'Pedro Oliveira',
        '(11) 77777-9012',
        DATE_ADD(CURDATE(), INTERVAL 2 DAY),
        '18:00:00',
        4,
        'confirmada'
    );
-- Criar view para relatórios de ocupação
CREATE OR REPLACE VIEW vw_ocupacao_mesas AS
SELECT status,
    COUNT(*) as quantidade,
    ROUND(
        (
            COUNT(*) * 100.0 / (
                SELECT COUNT(*)
                FROM mesas_restaurante
            )
        ),
        2
    ) as percentual
FROM mesas_restaurante
GROUP BY status;
-- Criar view para reservas ativas
CREATE OR REPLACE VIEW vw_reservas_ativas AS
SELECT r.id,
    r.cliente_nome,
    r.cliente_telefone,
    r.data_reserva,
    r.hora_reserva,
    r.numero_pessoas,
    r.status,
    m.numero_mesa,
    m.capacidade,
    m.localizacao
FROM reservas r
    JOIN mesas_restaurante m ON r.mesa_id = m.id
WHERE r.data_reserva >= CURDATE()
    AND r.status IN ('confirmada', 'pendente')
ORDER BY r.data_reserva,
    r.hora_reserva;