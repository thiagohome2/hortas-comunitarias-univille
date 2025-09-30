-- Script de criação completa do banco hortas_dev_db
-- MySQL 8.0+

-- Criar o banco se não existir
CREATE DATABASE IF NOT EXISTS hortas_dev_db;
USE hortas_dev_db;

-- Desabilitar verificação de foreign keys temporariamente
SET FOREIGN_KEY_CHECKS = 0;

-- ========================================
-- 1. TABELAS BASE (sem dependências)
-- ========================================

-- Tabela de endereços
CREATE TABLE enderecos (
    uuid CHAR(36) NOT NULL,
    tipo_logradouro VARCHAR(50),
    logradouro VARCHAR(255),
    numero VARCHAR(20),
    complemento VARCHAR(100),
    bairro VARCHAR(100),
    cidade VARCHAR(100),
    estado VARCHAR(2),
    cep VARCHAR(9),
    latitude DECIMAL(10,8),
    longitude DECIMAL(11,8),
    excluido TINYINT NOT NULL DEFAULT 0,
    usuario_criador_uuid CHAR(36),
    data_de_criacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    usuario_alterador_uuid CHAR(36),
    data_de_ultima_alteracao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (uuid)
);

-- Tabela de cargos
CREATE TABLE cargos (
    uuid CHAR(36) NOT NULL,
    codigo INT NOT NULL,
    slug VARCHAR(100) NOT NULL,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    cor VARCHAR(7),
    excluido TINYINT NOT NULL DEFAULT 0,
    usuario_criador_uuid CHAR(36),
    data_de_criacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    usuario_alterador_uuid CHAR(36),
    data_de_ultima_alteracao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (uuid),
    UNIQUE KEY unique_codigo (codigo),
    UNIQUE KEY unique_slug (slug)
);

-- Tabela de planos
CREATE TABLE planos (
    uuid CHAR(36) NOT NULL,
    codigo INT NOT NULL,
    slug VARCHAR(100) NOT NULL,
    valor_em_centavos BIGINT NOT NULL,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    excluido TINYINT DEFAULT 0,
    usuario_criador_uuid CHAR(36),
    data_de_criacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    usuario_alterador_uuid CHAR(36),
    data_de_ultima_alteracao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (uuid),
    UNIQUE KEY codigo (codigo),
    UNIQUE KEY slug (slug)
);

-- Tabela de permissões
CREATE TABLE permissoes (
    uuid CHAR(36) NOT NULL,
    slug VARCHAR(100) NOT NULL,
    tipo TINYINT NOT NULL,
    descricao TEXT,
    modulo TINYINT NOT NULL,
    excluido TINYINT DEFAULT 0,
    usuario_criador_uuid CHAR(36),
    data_de_criacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    usuario_alterador_uuid CHAR(36),
    data_de_ultima_alteracao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (uuid),
    UNIQUE KEY slug (slug)
);

-- Tabela de migrations
CREATE TABLE migrations (
    migration VARCHAR(255) NOT NULL,
    executed_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (migration)
);

-- ========================================
-- 2. TABELAS PRINCIPAIS
-- ========================================

-- Tabela de associações
CREATE TABLE associacoes (
    uuid CHAR(36) NOT NULL,
    cnpj VARCHAR(18) NOT NULL,
    razao_social VARCHAR(255) NOT NULL,
    nome_fantasia VARCHAR(255),
    endereco_uuid CHAR(36),
    url_estatuto_social_pdf TEXT,
    url_ata_associacao_pdf TEXT,
    status_aprovacao TINYINT NOT NULL DEFAULT 0,
    excluido TINYINT NOT NULL DEFAULT 0,
    usuario_responsavel_uuid CHAR(36),
    usuario_criador_uuid CHAR(36),
    data_de_criacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    usuario_alterador_uuid CHAR(36),
    data_de_ultima_alteracao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (uuid),
    UNIQUE KEY unique_cnpj (cnpj),
    FOREIGN KEY (endereco_uuid) REFERENCES enderecos(uuid)
);

-- Tabela de chaves (precisa ser criada antes de usuários)
CREATE TABLE chaves (
    uuid CHAR(36) NOT NULL,
    codigo VARCHAR(255) NOT NULL,
    horta_uuid CHAR(36) NOT NULL,
    observacoes TEXT,
    disponivel TINYINT DEFAULT 1,
    excluido TINYINT DEFAULT 0,
    usuario_criador_uuid CHAR(36) NOT NULL,
    usuario_alterador_uuid CHAR(36) NOT NULL,
    data_de_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    data_de_ultima_alteracao DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (uuid),
    UNIQUE KEY unique_codigo_horta (codigo, horta_uuid)
);

-- Tabela de usuários (principal)
CREATE TABLE usuarios (
    uuid CHAR(36) NOT NULL,
    nome_completo VARCHAR(255) NOT NULL,
    cpf VARCHAR(14) NOT NULL,
    email VARCHAR(255) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    data_de_nascimento DATE,
    cargo_uuid CHAR(36),
    taxa_associado_em_centavos INT,
    endereco_uuid CHAR(36),
    associacao_uuid CHAR(36),
    horta_uuid CHAR(36),
    usuario_associado_uuid CHAR(36),
    status_de_acesso VARCHAR(50),
    responsavel_da_conta VARCHAR(255),
    data_bloqueio_acesso DATETIME,
    motivo_bloqueio_acesso TEXT,
    excluido TINYINT NOT NULL DEFAULT 0,
    usuario_criador_uuid CHAR(36),
    data_de_criacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    usuario_alterador_uuid CHAR(36),
    data_de_ultima_alteracao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    apelido VARCHAR(100),
    dias_ausente INT,
    chave_uuid CHAR(36),
    PRIMARY KEY (uuid),
    UNIQUE KEY unique_cpf (cpf),
    UNIQUE KEY unique_email (email),
    FOREIGN KEY (cargo_uuid) REFERENCES cargos(uuid),
    FOREIGN KEY (endereco_uuid) REFERENCES enderecos(uuid),
    FOREIGN KEY (associacao_uuid) REFERENCES associacoes(uuid),
    FOREIGN KEY (usuario_associado_uuid) REFERENCES usuarios(uuid),
    FOREIGN KEY (chave_uuid) REFERENCES chaves(uuid),
    CONSTRAINT chk_nao_excluir_responsavel CHECK (excluido = 0 OR responsavel_da_conta IS NULL)
);

-- Tabela de hortas
CREATE TABLE hortas (
    uuid CHAR(36) NOT NULL,
    nome_da_horta VARCHAR(255) NOT NULL,
    endereco_uuid CHAR(36) NOT NULL,
    associacao_vinculada_uuid CHAR(36) NOT NULL,
    percentual_taxa_associado DECIMAL(5,2) NOT NULL,
    excluido TINYINT DEFAULT 0,
    usuario_criador_uuid CHAR(36),
    data_de_criacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    usuario_alterador_uuid CHAR(36),
    data_de_ultima_alteracao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    tipo_de_liberacao VARCHAR(50),
    PRIMARY KEY (uuid),
    FOREIGN KEY (endereco_uuid) REFERENCES enderecos(uuid),
    FOREIGN KEY (associacao_vinculada_uuid) REFERENCES associacoes(uuid),
    FOREIGN KEY (usuario_criador_uuid) REFERENCES usuarios(uuid),
    FOREIGN KEY (usuario_alterador_uuid) REFERENCES usuarios(uuid)
);

-- ========================================
-- 3. TABELAS DE RELACIONAMENTO E DEPENDENTES
-- ========================================

-- Recursos do plano
CREATE TABLE recursos_do_plano (
    uuid CHAR(36) NOT NULL,
    plano_uuid CHAR(36) NOT NULL,
    nome_do_recurso VARCHAR(100) NOT NULL,
    quantidade INT,
    descricao TEXT,
    excluido TINYINT DEFAULT 0,
    usuario_criador_uuid CHAR(36),
    data_de_criacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    usuario_alterador_uuid CHAR(36),
    data_de_ultima_alteracao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (uuid),
    FOREIGN KEY (plano_uuid) REFERENCES planos(uuid),
    FOREIGN KEY (usuario_criador_uuid) REFERENCES usuarios(uuid),
    FOREIGN KEY (usuario_alterador_uuid) REFERENCES usuarios(uuid)
);

-- Permissões de cargo
CREATE TABLE permissoes_de_cargo (
    uuid CHAR(36) NOT NULL,
    cargo_uuid CHAR(36) NOT NULL,
    permissao_uuid CHAR(36) NOT NULL,
    excluido TINYINT DEFAULT 0,
    usuario_criador_uuid CHAR(36),
    data_de_criacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    usuario_alterador_uuid CHAR(36),
    data_de_ultima_alteracao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (uuid),
    UNIQUE KEY cargo_uuid (cargo_uuid, permissao_uuid),
    FOREIGN KEY (cargo_uuid) REFERENCES cargos(uuid),
    FOREIGN KEY (permissao_uuid) REFERENCES permissoes(uuid),
    FOREIGN KEY (usuario_criador_uuid) REFERENCES usuarios(uuid),
    FOREIGN KEY (usuario_alterador_uuid) REFERENCES usuarios(uuid)
);

-- Permissões de exceção
CREATE TABLE permissoes_de_excecao (
    uuid CHAR(36) NOT NULL,
    usuario_uuid CHAR(36) NOT NULL,
    permissao_uuid CHAR(36) NOT NULL,
    liberado TINYINT DEFAULT 0,
    excluido TINYINT DEFAULT 0,
    usuario_criador_uuid CHAR(36),
    data_de_criacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    usuario_alterador_uuid CHAR(36),
    data_de_ultima_alteracao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (uuid),
    UNIQUE KEY unique_usuario_permissao (usuario_uuid, permissao_uuid),
    FOREIGN KEY (usuario_uuid) REFERENCES usuarios(uuid),
    FOREIGN KEY (permissao_uuid) REFERENCES permissoes(uuid),
    FOREIGN KEY (usuario_criador_uuid) REFERENCES usuarios(uuid),
    FOREIGN KEY (usuario_alterador_uuid) REFERENCES usuarios(uuid)
);

-- Canteiros
CREATE TABLE canteiros (
    uuid CHAR(36) NOT NULL,
    numero_identificador VARCHAR(20) NOT NULL,
    tamanho_m2 DECIMAL(8,2) NOT NULL,
    horta_uuid CHAR(36) NOT NULL,
    excluido TINYINT DEFAULT 0,
    usuario_criador_uuid CHAR(36),
    data_de_criacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    usuario_alterador_uuid CHAR(36),
    data_de_ultima_alteracao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    usuario_anterior_uuid CHAR(36),
    PRIMARY KEY (uuid),
    UNIQUE KEY numero_identificador (numero_identificador, horta_uuid),
    FOREIGN KEY (horta_uuid) REFERENCES hortas(uuid),
    FOREIGN KEY (usuario_criador_uuid) REFERENCES usuarios(uuid),
    FOREIGN KEY (usuario_alterador_uuid) REFERENCES usuarios(uuid),
    FOREIGN KEY (usuario_anterior_uuid) REFERENCES usuarios(uuid)
);

-- Canteiros e usuários (relacionamento)
CREATE TABLE canteiros_e_usuarios (
    uuid CHAR(36) NOT NULL,
    canteiro_uuid CHAR(36) NOT NULL,
    usuario_uuid CHAR(36) NOT NULL,
    tipo_vinculo TINYINT DEFAULT 1,
    data_inicio DATE NOT NULL,
    data_fim DATE,
    percentual_responsabilidade DECIMAL(5,2) DEFAULT 100.00,
    observacoes TEXT,
    ativo TINYINT DEFAULT 1,
    excluido TINYINT DEFAULT 0,
    usuario_criador_uuid CHAR(36),
    data_de_criacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    usuario_alterador_uuid CHAR(36),
    data_de_ultima_alteracao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (uuid),
    UNIQUE KEY canteiro_uuid (canteiro_uuid, usuario_uuid, data_inicio),
    FOREIGN KEY (canteiro_uuid) REFERENCES canteiros(uuid),
    FOREIGN KEY (usuario_uuid) REFERENCES usuarios(uuid),
    FOREIGN KEY (usuario_criador_uuid) REFERENCES usuarios(uuid),
    FOREIGN KEY (usuario_alterador_uuid) REFERENCES usuarios(uuid)
);

-- Categorias financeiras
CREATE TABLE categorias_financeiras (
    uuid CHAR(36) NOT NULL,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    tipo TINYINT NOT NULL,
    cor VARCHAR(7),
    icone VARCHAR(50),
    associacao_uuid CHAR(36),
    horta_uuid CHAR(36),
    excluido TINYINT DEFAULT 0,
    usuario_criador_uuid CHAR(36) NOT NULL,
    data_de_criacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    usuario_alterador_uuid CHAR(36),
    data_de_ultima_alteracao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (uuid),
    FOREIGN KEY (associacao_uuid) REFERENCES associacoes(uuid),
    FOREIGN KEY (horta_uuid) REFERENCES hortas(uuid),
    FOREIGN KEY (usuario_criador_uuid) REFERENCES usuarios(uuid),
    FOREIGN KEY (usuario_alterador_uuid) REFERENCES usuarios(uuid)
);

-- Fila de usuários
CREATE TABLE fila_de_usuarios (
    uuid CHAR(36) NOT NULL,
    usuario_uuid CHAR(36) NOT NULL,
    horta_uuid CHAR(36) NOT NULL,
    data_entrada TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    ordem INT NOT NULL,
    excluido TINYINT DEFAULT 0,
    usuario_criador_uuid CHAR(36),
    data_de_criacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    usuario_alterador_uuid CHAR(36),
    data_de_ultima_alteracao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (uuid),
    UNIQUE KEY ordem (ordem, horta_uuid),
    FOREIGN KEY (usuario_uuid) REFERENCES usuarios(uuid),
    FOREIGN KEY (horta_uuid) REFERENCES hortas(uuid),
    FOREIGN KEY (usuario_criador_uuid) REFERENCES usuarios(uuid),
    FOREIGN KEY (usuario_alterador_uuid) REFERENCES usuarios(uuid)
);

-- Mensalidades da plataforma
CREATE TABLE mensalidades_da_plataforma (
    uuid CHAR(36) NOT NULL,
    usuario_uuid CHAR(36) NOT NULL,
    valor_em_centavos BIGINT NOT NULL,
    plano_uuid CHAR(36),
    data_vencimento DATE NOT NULL,
    data_pagamento DATE,
    status TINYINT NOT NULL DEFAULT 0,
    dias_atraso INT DEFAULT 0,
    url_anexo TEXT,
    excluido TINYINT DEFAULT 0,
    usuario_criador_uuid CHAR(36),
    data_de_criacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    usuario_alterador_uuid CHAR(36),
    data_de_ultima_alteracao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    url_recibo VARCHAR(255),
    PRIMARY KEY (uuid),
    FOREIGN KEY (usuario_uuid) REFERENCES usuarios(uuid),
    FOREIGN KEY (plano_uuid) REFERENCES planos(uuid),
    FOREIGN KEY (usuario_criador_uuid) REFERENCES usuarios(uuid),
    FOREIGN KEY (usuario_alterador_uuid) REFERENCES usuarios(uuid)
);

-- Mensalidades da associação
CREATE TABLE mensalidades_da_associacao (
    uuid CHAR(36) NOT NULL,
    usuario_uuid CHAR(36) NOT NULL,
    associacao_uuid CHAR(36) NOT NULL,
    valor_em_centavos BIGINT NOT NULL,
    data_vencimento DATE NOT NULL,
    data_pagamento DATE,
    status TINYINT NOT NULL DEFAULT 0,
    dias_atraso INT DEFAULT 0,
    url_anexo TEXT,
    excluido TINYINT DEFAULT 0,
    usuario_criador_uuid CHAR(36),
    data_de_criacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    usuario_alterador_uuid CHAR(36),
    data_de_ultima_alteracao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    url_recibo VARCHAR(255),
    PRIMARY KEY (uuid),
    FOREIGN KEY (usuario_uuid) REFERENCES usuarios(uuid),
    FOREIGN KEY (associacao_uuid) REFERENCES associacoes(uuid),
    FOREIGN KEY (usuario_criador_uuid) REFERENCES usuarios(uuid),
    FOREIGN KEY (usuario_alterador_uuid) REFERENCES usuarios(uuid)
);

-- Financeiro da associação
CREATE TABLE financeiro_da_associacao (
    uuid CHAR(36) NOT NULL,
    valor_em_centavos BIGINT NOT NULL,
    descricao_do_lancamento TEXT NOT NULL,
    categoria_uuid CHAR(36),
    url_anexo TEXT,
    data_do_lancamento DATE NOT NULL,
    associacao_uuid CHAR(36) NOT NULL,
    mensalidade_uuid CHAR(36),
    excluido TINYINT DEFAULT 0,
    usuario_criador_uuid CHAR(36),
    data_de_criacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    usuario_alterador_uuid CHAR(36),
    data_de_ultima_alteracao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (uuid),
    FOREIGN KEY (categoria_uuid) REFERENCES categorias_financeiras(uuid),
    FOREIGN KEY (associacao_uuid) REFERENCES associacoes(uuid),
    FOREIGN KEY (mensalidade_uuid) REFERENCES mensalidades_da_associacao(uuid),
    FOREIGN KEY (usuario_criador_uuid) REFERENCES usuarios(uuid),
    FOREIGN KEY (usuario_alterador_uuid) REFERENCES usuarios(uuid)
);

-- Financeiro da horta
CREATE TABLE financeiro_da_horta (
    uuid CHAR(36) NOT NULL,
    valor_em_centavos BIGINT NOT NULL,
    descricao_do_lancamento TEXT NOT NULL,
    categoria_uuid CHAR(36),
    url_anexo TEXT,
    data_do_lancamento DATE NOT NULL,
    horta_uuid CHAR(36) NOT NULL,
    excluido TINYINT DEFAULT 0,
    usuario_criador_uuid CHAR(36),
    data_de_criacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    usuario_alterador_uuid CHAR(36),
    data_de_ultima_alteracao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (uuid),
    FOREIGN KEY (categoria_uuid) REFERENCES categorias_financeiras(uuid),
    FOREIGN KEY (horta_uuid) REFERENCES hortas(uuid),
    FOREIGN KEY (usuario_criador_uuid) REFERENCES usuarios(uuid),
    FOREIGN KEY (usuario_alterador_uuid) REFERENCES usuarios(uuid)
);

-- ========================================
-- 4. ATUALIZAR FOREIGN KEYS PENDENTES
-- ========================================

-- Adicionar FKs para chaves (que dependem de hortas)
ALTER TABLE chaves 
ADD FOREIGN KEY (horta_uuid) REFERENCES hortas(uuid),
ADD FOREIGN KEY (usuario_criador_uuid) REFERENCES usuarios(uuid),
ADD FOREIGN KEY (usuario_alterador_uuid) REFERENCES usuarios(uuid);

-- Adicionar FK para horta_uuid em usuarios
ALTER TABLE usuarios 
ADD FOREIGN KEY (horta_uuid) REFERENCES hortas(uuid);

-- Adicionar FK para usuario_responsavel_uuid em associacoes
ALTER TABLE associacoes 
ADD FOREIGN KEY (usuario_responsavel_uuid) REFERENCES usuarios(uuid);

-- ========================================
-- 5. ÍNDICES ADICIONAIS PARA PERFORMANCE
-- ========================================

-- Índices para consultas frequentes
CREATE INDEX idx_usuarios_cargo ON usuarios(cargo_uuid);
CREATE INDEX idx_usuarios_associacao ON usuarios(associacao_uuid);
CREATE INDEX idx_usuarios_horta ON usuarios(horta_uuid);
CREATE INDEX idx_usuarios_email ON usuarios(email);
CREATE INDEX idx_usuarios_status ON usuarios(status_de_acesso);

CREATE INDEX idx_hortas_associacao ON hortas(associacao_vinculada_uuid);
CREATE INDEX idx_canteiros_horta ON canteiros(horta_uuid);
CREATE INDEX idx_canteiros_usuarios_canteiro ON canteiros_e_usuarios(canteiro_uuid);
CREATE INDEX idx_canteiros_usuarios_usuario ON canteiros_e_usuarios(usuario_uuid);

CREATE INDEX idx_mensalidades_plataforma_usuario ON mensalidades_da_plataforma(usuario_uuid);
CREATE INDEX idx_mensalidades_plataforma_vencimento ON mensalidades_da_plataforma(data_vencimento);
CREATE INDEX idx_mensalidades_associacao_usuario ON mensalidades_da_associacao(usuario_uuid);
CREATE INDEX idx_mensalidades_associacao_associacao ON mensalidades_da_associacao(associacao_uuid);

CREATE INDEX idx_financeiro_associacao_data ON financeiro_da_associacao(data_do_lancamento);
CREATE INDEX idx_financeiro_horta_data ON financeiro_da_horta(data_do_lancamento);

-- Reabilitar verificação de foreign keys
SET FOREIGN_KEY_CHECKS = 1;

-- ========================================
-- 6. COMENTÁRIOS DAS TABELAS
-- ========================================

ALTER TABLE usuarios COMMENT = 'Tabela principal de usuários do sistema';
ALTER TABLE associacoes COMMENT = 'Tabela de associações/cooperativas';
ALTER TABLE hortas COMMENT = 'Tabela de hortas comunitárias';
ALTER TABLE canteiros COMMENT = 'Canteiros individuais dentro das hortas';
ALTER TABLE canteiros_e_usuarios COMMENT = 'Relacionamento entre canteiros e usuários responsáveis';
ALTER TABLE enderecos COMMENT = 'Endereços utilizados por usuários, associações e hortas';
ALTER TABLE cargos COMMENT = 'Cargos/funções dos usuários no sistema';
ALTER TABLE permissoes COMMENT = 'Permissões do sistema';
ALTER TABLE permissoes_de_cargo COMMENT = 'Permissões atribuídas a cada cargo';
ALTER TABLE permissoes_de_excecao COMMENT = 'Permissões especiais para usuários específicos';
ALTER TABLE planos COMMENT = 'Planos de assinatura da plataforma';
ALTER TABLE recursos_do_plano COMMENT = 'Recursos disponíveis em cada plano';
ALTER TABLE mensalidades_da_plataforma COMMENT = 'Mensalidades dos usuários na plataforma';
ALTER TABLE mensalidades_da_associacao COMMENT = 'Mensalidades dos usuários nas associações';
ALTER TABLE financeiro_da_associacao COMMENT = 'Movimentações financeiras das associações';
ALTER TABLE financeiro_da_horta COMMENT = 'Movimentações financeiras das hortas';
ALTER TABLE categorias_financeiras COMMENT = 'Categorias para classificação financeira';
ALTER TABLE fila_de_usuarios COMMENT = 'Fila de espera de usuários para canteiros';
ALTER TABLE chaves COMMENT = 'Chaves de acesso às hortas';

SELECT 'Banco de dados criado com sucesso! Todas as tabelas, relacionamentos e índices foram configurados.' AS status;