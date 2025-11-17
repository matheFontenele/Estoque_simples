CREATE DATABASE IF NOT EXISTS alucom_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE alucom_db;

-- ==========================
-- TABELA ESTOQUE
-- ==========================
CREATE TABLE IF NOT EXISTS estoque (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    endereco VARCHAR(255) NOT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ==========================
-- TABELA ITEM
-- ==========================
CREATE TABLE IF NOT EXISTS item (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao VARCHAR(255),
    cor ENUM('preto', 'ciano', 'magenta', 'amarelo', 'não se aplica') NOT NULL DEFAULT 'não se aplica',
    item_estoque INT,
    
    CONSTRAINT fk_item_estoque
        FOREIGN KEY (item_estoque) REFERENCES estoque(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
) ENGINE=InnoDB;
