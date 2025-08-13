-- Script de inicialização do banco de dados
SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

-- Criar banco de dados se não existir
CREATE DATABASE IF NOT EXISTS `hortas_db` 
    CHARACTER SET utf8mb4 
    COLLATE utf8mb4_unicode_ci;

USE `hortas_db`;

-- Tabela de usuários
CREATE TABLE IF NOT EXISTS `usuarios` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(100) NOT NULL,
    `email` VARCHAR(150) NOT NULL UNIQUE,
    `senha` VARCHAR(255) NOT NULL,
    `tipo` ENUM('admin', 'produtor', 'consumidor') NOT NULL DEFAULT 'consumidor',
    `telefone` VARCHAR(20) NULL,
    `ativo` BOOLEAN NOT NULL DEFAULT TRUE,
    `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `atualizado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_email` (`email`),
    INDEX `idx_tipo` (`tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de hortas
CREATE TABLE IF NOT EXISTS `hortas` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(150) NOT NULL,
    `descricao` TEXT NULL,
    `endereco` TEXT NOT NULL,
    `latitude` DECIMAL(10,8) NULL,
    `longitude` DECIMAL(11,8) NULL,
    `responsavel_id` INT UNSIGNED NOT NULL,
    `ativa` BOOLEAN NOT NULL DEFAULT TRUE,
    `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `atualizado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`responsavel_id`) REFERENCES `usuarios`(`id`) ON DELETE RESTRICT,
    INDEX `idx_responsavel` (`responsavel_id`),
    INDEX `idx_localizacao` (`latitude`, `longitude`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de produtos
CREATE TABLE IF NOT EXISTS `produtos` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(100) NOT NULL,
    `descricao` TEXT NULL,
    `categoria` VARCHAR(50) NOT NULL,
    `unidade_medida` VARCHAR(20) NOT NULL DEFAULT 'kg',
    `preco_sugerido` DECIMAL(10,2) NULL,
    `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `atualizado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_categoria` (`categoria`),
    INDEX `idx_nome` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Inserir dados iniciais
INSERT INTO `usuarios` (`nome`, `email`, `senha`, `tipo`) VALUES
('Administrador', 'admin@hortas.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('João Silva', 'joao@producer.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'produtor'),
('Maria Santos', 'maria@consumer.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'consumidor');

INSERT INTO `produtos` (`nome`, `categoria`, `unidade_medida`) VALUES
('Alface', 'Folhosas', 'kg'),
('Tomate', 'Frutos', 'kg'),
('Cenoura', 'Raízes', 'kg'),
('Rúcula', 'Folhosas', 'maço'),
('Pimentão', 'Frutos', 'kg');
