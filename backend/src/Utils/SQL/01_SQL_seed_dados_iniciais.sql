-- Desabilita checagem de foreign keys temporariamente
SET FOREIGN_KEY_CHECKS = 0;

-- Limpa tabelas na ordem correta
DELETE FROM permissoes_de_cargo;
DELETE FROM usuarios;
DELETE FROM cargos;
DELETE FROM permissoes;

-- //// Adiciona cargos base em "cargos"
INSERT INTO cargos (uuid, codigo, slug, nome, descricao, cor, excluido, usuario_criador_uuid, usuario_alterador_uuid)
SELECT UUID(), 4, 'dependente', 'Dependente', 'Usuário dependente de outro associado.', '#FF00FF', 0, NULL, NULL
UNION ALL
SELECT UUID(), 3, 'canteirista', 'Canteirista', 'Responsável por cuidar dos canteiros.', '#FFFF00', 0, NULL, NULL
UNION ALL
SELECT UUID(), 0, 'admin_plataforma', 'Administração da Plataforma', 'Usuário com acesso total ao sistema.', '#FF0000', 0, NULL, NULL
UNION ALL
SELECT UUID(), 1, 'admin_associacao_geral', 'Administração da Associação', 'Gerencia todas as associações.', '#00FF00', 0, NULL, NULL
UNION ALL
SELECT UUID(), 2, 'admin_horta_geral', 'Administração da Horta', 'Gerencia todas as hortas.', '#0000FF', 0, NULL, NULL;

-- //// Adiciona permissoes base em "permissoes"
-- ================= USUARIOS =================
INSERT INTO permissoes (uuid, slug, tipo, descricao, modulo, excluido, usuario_criador_uuid, data_de_criacao, usuario_alterador_uuid, data_de_ultima_alteracao) VALUES
(UUID(), 'usuarios_ler', 0, 'Permissão de LER no módulo USUARIOS', 0, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'usuarios_criar', 1, 'Permissão de CRIAR no módulo USUARIOS', 0, 0, NULL, NOW(), NULL, NOW()),
('7e2a2a54-d142-4e7c-8974-5d9ead9c5b0d', 'usuarios_editar', 2, 'Permissão de EDITAR no módulo USUARIOS', 0, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'usuarios_deletar', 3, 'Permissão de DELETAR no módulo USUARIOS', 0, 0, NULL, NOW(), NULL, NOW());

-- ================= ASSOCIACOES =================
INSERT INTO permissoes VALUES
(UUID(), 'associacoes_ler', 0, 'Permissão de LER no módulo ASSOCIACOES', 1, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'associacoes_criar', 1, 'Permissão de CRIAR no módulo ASSOCIACOES', 1, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'associacoes_editar', 2, 'Permissão de EDITAR no módulo ASSOCIACOES', 1, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'associacoes_deletar', 3, 'Permissão de DELETAR no módulo ASSOCIACOES', 1, 0, NULL, NOW(), NULL, NOW());

-- ================= HORTAS =================
INSERT INTO permissoes VALUES
(UUID(), 'hortas_ler', 0, 'Permissão de LER no módulo HORTAS', 2, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'hortas_criar', 1, 'Permissão de CRIAR no módulo HORTAS', 2, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'hortas_editar', 2, 'Permissão de EDITAR no módulo HORTAS', 2, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'hortas_deletar', 3, 'Permissão de DELETAR no módulo HORTAS', 2, 0, NULL, NOW(), NULL, NOW());

-- ================= ENDERECOS =================
INSERT INTO permissoes VALUES
(UUID(), 'enderecos_ler', 0, 'Permissão de LER no módulo ENDERECOS', 3, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'enderecos_criar', 1, 'Permissão de CRIAR no módulo ENDERECOS', 3, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'enderecos_editar', 2, 'Permissão de EDITAR no módulo ENDERECOS', 3, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'enderecos_deletar', 3, 'Permissão de DELETAR no módulo ENDERECOS', 3, 0, NULL, NOW(), NULL, NOW());

-- ================= CANTEIROS =================
INSERT INTO permissoes VALUES
(UUID(), 'canteiros_ler', 0, 'Permissão de LER no módulo CANTEIROS', 4, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'canteiros_criar', 1, 'Permissão de CRIAR no módulo CANTEIROS', 4, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'canteiros_editar', 2, 'Permissão de EDITAR no módulo CANTEIROS', 4, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'canteiros_deletar', 3, 'Permissão de DELETAR no módulo CANTEIROS', 4, 0, NULL, NOW(), NULL, NOW());

-- ================= CANTEIROS_E_USUARIOS =================
INSERT INTO permissoes VALUES
(UUID(), 'canteiros_usuarios_ler', 0, 'Permissão de LER no módulo CANTEIROS_E_USUARIOS', 5, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'canteiros_usuarios_criar', 1, 'Permissão de CRIAR no módulo CANTEIROS_E_USUARIOS', 5, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'canteiros_usuarios_editar', 2, 'Permissão de EDITAR no módulo CANTEIROS_E_USUARIOS', 5, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'canteiros_usuarios_deletar', 3, 'Permissão de DELETAR no módulo CANTEIROS_E_USUARIOS', 5, 0, NULL, NOW(), NULL, NOW());

-- ================= CARGOS =================
INSERT INTO permissoes VALUES
(UUID(), 'cargos_ler', 0, 'Permissão de LER no módulo CARGOS', 6, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'cargos_criar', 1, 'Permissão de CRIAR no módulo CARGOS', 6, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'cargos_editar', 2, 'Permissão de EDITAR no módulo CARGOS', 6, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'cargos_deletar', 3, 'Permissão de DELETAR no módulo CARGOS', 6, 0, NULL, NOW(), NULL, NOW());

-- ================= PERMISSOES =================
INSERT INTO permissoes VALUES
(UUID(), 'permissoes_ler', 0, 'Permissão de LER no módulo PERMISSOES', 7, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'permissoes_criar', 1, 'Permissão de CRIAR no módulo PERMISSOES', 7, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'permissoes_editar', 2, 'Permissão de EDITAR no módulo PERMISSOES', 7, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'permissoes_deletar', 3, 'Permissão de DELETAR no módulo PERMISSOES', 7, 0, NULL, NOW(), NULL, NOW());

-- ================= PERMISSOES_DE_CARGO =================
INSERT INTO permissoes VALUES
(UUID(), 'permissoes_cargo_ler', 0, 'Permissão de LER no módulo PERMISSOES_DE_CARGO', 8, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'permissoes_cargo_criar', 1, 'Permissão de CRIAR no módulo PERMISSOES_DE_CARGO', 8, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'permissoes_cargo_editar', 2, 'Permissão de EDITAR no módulo PERMISSOES_DE_CARGO', 8, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'permissoes_cargo_deletar', 3, 'Permissão de DELETAR no módulo PERMISSOES_DE_CARGO', 8, 0, NULL, NOW(), NULL, NOW());

-- ================= PERMISSOES_DE_EXCECAO =================
INSERT INTO permissoes VALUES
(UUID(), 'permissoes_excecao_ler', 0, 'Permissão de LER no módulo PERMISSOES_DE_EXCECAO', 9, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'permissoes_excecao_criar', 1, 'Permissão de CRIAR no módulo PERMISSOES_DE_EXCECAO', 9, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'permissoes_excecao_editar', 2, 'Permissão de EDITAR no módulo PERMISSOES_DE_EXCECAO', 9, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'permissoes_excecao_deletar', 3, 'Permissão de DELETAR no módulo PERMISSOES_DE_EXCECAO', 9, 0, NULL, NOW(), NULL, NOW());

-- ================= PERMISSOES_DO_USUARIO =================
INSERT INTO permissoes VALUES
(UUID(), 'permissoes_usuario_ler', 0, 'Permissão de LER no módulo PERMISSOES_DO_USUARIO', 18, 0, NULL, NOW(), NULL, NOW());

-- ================= CATEGORIAS_FINANCEIRAS =================
INSERT INTO permissoes VALUES
(UUID(), 'categorias_financeiras_ler', 0, 'Permissão de LER no módulo CATEGORIAS_FINANCEIRAS', 10, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'categorias_financeiras_criar', 1, 'Permissão de CRIAR no módulo CATEGORIAS_FINANCEIRAS', 10, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'categorias_financeiras_editar', 2, 'Permissão de EDITAR no módulo CATEGORIAS_FINANCEIRAS', 10, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'categorias_financeiras_deletar', 3, 'Permissão de DELETAR no módulo CATEGORIAS_FINANCEIRAS', 10, 0, NULL, NOW(), NULL, NOW());

-- ================= FINANCEIRO_HORTA =================
INSERT INTO permissoes VALUES
(UUID(), 'financeiro_horta_ler', 0, 'Permissão de LER no módulo FINANCEIRO_HORTA', 11, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'financeiro_horta_criar', 1, 'Permissão de CRIAR no módulo FINANCEIRO_HORTA', 11, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'financeiro_horta_editar', 2, 'Permissão de EDITAR no módulo FINANCEIRO_HORTA', 11, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'financeiro_horta_deletar', 3, 'Permissão de DELETAR no módulo FINANCEIRO_HORTA', 11, 0, NULL, NOW(), NULL, NOW());

-- ================= FINANCEIRO_ASSOCIACAO =================
INSERT INTO permissoes VALUES
(UUID(), 'financeiro_associacao_ler', 0, 'Permissão de LER no módulo FINANCEIRO_ASSOCIACAO', 12, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'financeiro_associacao_criar', 1, 'Permissão de CRIAR no módulo FINANCEIRO_ASSOCIACAO', 12, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'financeiro_associacao_editar', 2, 'Permissão de EDITAR no módulo FINANCEIRO_ASSOCIACAO', 12, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'financeiro_associacao_deletar', 3, 'Permissão de DELETAR no módulo FINANCEIRO_ASSOCIACAO', 12, 0, NULL, NOW(), NULL, NOW());

-- ================= MENSALIDADES_DA_ASSOCIACAO =================
INSERT INTO permissoes VALUES
(UUID(), 'mensalidades_associacao_ler', 0, 'Permissão de LER no módulo MENSALIDADES_DA_ASSOCIACAO', 13, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'mensalidades_associacao_criar', 1, 'Permissão de CRIAR no módulo MENSALIDADES_DA_ASSOCIACAO', 13, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'mensalidades_associacao_editar', 2, 'Permissão de EDITAR no módulo MENSALIDADES_DA_ASSOCIACAO', 13, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'mensalidades_associacao_deletar', 3, 'Permissão de DELETAR no módulo MENSALIDADES_DA_ASSOCIACAO', 13, 0, NULL, NOW(), NULL, NOW());

-- ================= MENSALIDADES_DA_PLATAFORMA =================
INSERT INTO permissoes VALUES
(UUID(), 'mensalidades_plataforma_ler', 0, 'Permissão de LER no módulo MENSALIDADES_DA_PLATAFORMA', 14, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'mensalidades_plataforma_criar', 1, 'Permissão de CRIAR no módulo MENSALIDADES_DA_PLATAFORMA', 14, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'mensalidades_plataforma_editar', 2, 'Permissão de EDITAR no módulo MENSALIDADES_DA_PLATAFORMA', 14, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'mensalidades_plataforma_deletar', 3, 'Permissão de DELETAR no módulo MENSALIDADES_DA_PLATAFORMA', 14, 0, NULL, NOW(), NULL, NOW());

-- ================= PLANOS =================
INSERT INTO permissoes VALUES
(UUID(), 'planos_ler', 0, 'Permissão de LER no módulo PLANOS', 15, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'planos_criar', 1, 'Permissão de CRIAR no módulo PLANOS', 15, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'planos_editar', 2, 'Permissão de EDITAR no módulo PLANOS', 15, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'planos_deletar', 3, 'Permissão de DELETAR no módulo PLANOS', 15, 0, NULL, NOW(), NULL, NOW());
-- ================= RECURSOS_DO_PLANO =================
INSERT INTO permissoes VALUES
(UUID(), 'recursos_plano_ler', 0, 'Permissão de LER no módulo RECURSOS_DO_PLANO', 16, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'recursos_plano_criar', 1, 'Permissão de CRIAR no módulo RECURSOS_DO_PLANO', 16, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'recursos_plano_editar', 2, 'Permissão de EDITAR no módulo RECURSOS_DO_PLANO', 16, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'recursos_plano_deletar', 3, 'Permissão de DELETAR no módulo RECURSOS_DO_PLANO', 16, 0, NULL, NOW(), NULL, NOW());

-- ================= CHAVES =================
INSERT INTO permissoes VALUES
(UUID(), 'chaves_ler', 0, 'Permissão de LER no módulo CHAVES', 17, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'chaves_criar', 1, 'Permissão de CRIAR no módulo CHAVES', 17, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'chaves_editar', 2, 'Permissão de EDITAR no módulo CHAVES', 17, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'chaves_deletar', 3, 'Permissão de DELETAR no módulo CHAVES', 17, 0, NULL, NOW(), NULL, NOW());

-- ================= FILA_DE_USUARIO =================
INSERT INTO permissoes VALUES
(UUID(), 'fila_usuarios_ler', 0, 'Permissão de LER no módulo FILA_DE_USUARIO', 18, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'fila_usuarios_criar', 1, 'Permissão de CRIAR no módulo FILA_DE_USUARIO', 18, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'fila_usuarios_editar', 2, 'Permissão de EDITAR no módulo FILA_DE_USUARIO', 18, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'fila_usuarios_deletar', 3, 'Permissão de DELETAR no módulo FILA_DE_USUARIO', 18, 0, NULL, NOW(), NULL, NOW());

-- //// Adiciona permissoes totais para o cargo UUID que for referente ao slug "admin_plataforma" na tabela "permissoes_de_cargo"
INSERT INTO permissoes_de_cargo (uuid, cargo_uuid, permissao_uuid, excluido, usuario_criador_uuid, data_de_criacao)
SELECT
    UUID(),
    c.uuid,
    p.uuid,
    0,
    NULL,
    NOW()
FROM cargos c
CROSS JOIN permissoes p
WHERE c.slug = 'admin_plataforma';

-- Adiciona permissões para o cargo "Administração da Associação"
INSERT INTO permissoes_de_cargo (uuid, cargo_uuid, permissao_uuid, excluido, usuario_criador_uuid, data_de_criacao)
SELECT
    UUID(),
    c.uuid,
    p.uuid,
    0,
    NULL,
    NOW()
FROM cargos c
CROSS JOIN permissoes p
WHERE c.slug = 'admin_associacao_geral'
AND p.slug IN (
    'usuarios_ler', 'usuarios_criar', 'usuarios_editar', 'usuarios_deletar',
    'hortas_ler', 'hortas_criar', 'hortas_editar', 'hortas_deletar',
    'enderecos_ler', 'enderecos_criar', 'enderecos_editar', 'enderecos_deletar',
    'canteiros_ler', 'canteiros_criar', 'canteiros_editar', 'canteiros_deletar',
    'canteiros_usuarios_ler', 'canteiros_usuarios_criar', 'canteiros_usuarios_editar', 'canteiros_usuarios_deletar',
    'cargos_ler',
    'permissoes_cargo_ler',
    'permissoes_excecao_ler', 'permissoes_excecao_criar', 'permissoes_excecao_editar', 'permissoes_excecao_deletar',
    'permissoes_usuario_ler',
    'categorias_financeiras_ler', 'categorias_financeiras_criar', 'categorias_financeiras_editar', 'categorias_financeiras_deletar',
    'financeiro_horta_ler', 'financeiro_horta_criar', 'financeiro_horta_editar', 'financeiro_horta_deletar',
    'financeiro_associacao_ler', 'financeiro_associacao_criar', 'financeiro_associacao_editar', 'financeiro_associacao_deletar',
    'mensalidades_associacao_ler',
    'mensalidades_plataforma_ler',
    'planos_ler',
    'chaves_ler', 'chaves_criar', 'chaves_editar', 'chaves_deletar',
    'fila_usuarios_ler', 'fila_usuarios_criar', 'fila_usuarios_editar', 'fila_usuarios_deletar'
);


-- Adiciona permissões para o cargo "Administração da Horta"
INSERT INTO permissoes_de_cargo (uuid, cargo_uuid, permissao_uuid, excluido, usuario_criador_uuid, data_de_criacao)
SELECT
    UUID(),
    c.uuid,
    p.uuid,
    0,
    NULL,
    NOW()
FROM cargos c
CROSS JOIN permissoes p
WHERE c.slug = 'admin_horta_geral'
AND p.slug IN (
    'usuarios_ler', 'usuarios_criar', 'usuarios_editar', 'usuarios_deletar',
    'hortas_ler',
    'canteiros_ler', 'canteiros_criar', 'canteiros_editar', 'canteiros_deletar',
    'canteiros_usuarios_ler', 'canteiros_usuarios_criar', 'canteiros_usuarios_editar', 'canteiros_usuarios_deletar',
    'cargos_ler',
    'permissoes_usuario_ler',
    'categorias_financeiras_ler', 'categorias_financeiras_criar', 'categorias_financeiras_editar', 'categorias_financeiras_deletar',
    'financeiro_horta_ler', 'financeiro_horta_criar', 'financeiro_horta_editar', 'financeiro_horta_deletar',
    'financeiro_associacao_ler', 'financeiro_associacao_criar', 'financeiro_associacao_editar', 'financeiro_associacao_deletar',
    'chaves_ler', 'chaves_criar', 'chaves_editar', 'chaves_deletar',
    'fila_usuarios_ler', 'fila_usuarios_criar', 'fila_usuarios_editar', 'fila_usuarios_deletar'
);



-- //// Depois adiciona permissões para o cargo "Canteirista"
INSERT INTO permissoes_de_cargo (uuid, cargo_uuid, permissao_uuid, excluido, usuario_criador_uuid, data_de_criacao)
SELECT
    UUID(),
    c.uuid,
    p.uuid,
    0,
    NULL,
    NOW()
FROM cargos c
CROSS JOIN permissoes p
WHERE c.slug = 'canteirista'
AND p.slug IN (
    'canteiros_ler',
    'canteiros_usuarios_ler',
    'permissoes_usuario_ler',
    'financeiro_horta_ler',
    'financeiro_associacao_ler',
    'chaves_ler',
    'fila_usuarios_ler'
);

-- //// Depois adiciona permissões para o cargo "Dependente"
INSERT INTO permissoes_de_cargo (uuid, cargo_uuid, permissao_uuid, excluido, usuario_criador_uuid, data_de_criacao)
SELECT
    UUID(),
    c.uuid,
    p.uuid,
    0,
    NULL,
    NOW()
FROM cargos c
CROSS JOIN permissoes p
WHERE c.slug = 'dependente'
AND p.slug IN (
    'canteiros_ler',
    'canteiros_usuarios_ler',
    'permissoes_usuario_ler',
    'financeiro_horta_ler',
    'financeiro_associacao_ler',
    'chaves_ler',
    'fila_usuarios_ler'
);

-- ================= USUARIO ADMIN =================
-- Primeiro pegue o UUID do cargo admin_plataforma
SET @adminCargoUUID = (SELECT uuid FROM cargos WHERE slug = 'admin_plataforma');

INSERT INTO usuarios (
    uuid,
    nome_completo,
    cpf,
    email,
    senha,
    data_de_nascimento,
    cargo_uuid,
    taxa_associado_em_centavos,
    excluido,
    data_de_criacao
)
VALUES (
    UUID(),
    'Administração da Plataforma',
    '123.456.789-09',
    'hortas_comunitarias@univille.com',
    '$2y$10$TUHWKOcJj85/pMDxEg7eTu3zGDlE2sfOdVn4dfSN5JzMIqssNISYG', -- hash de senha
    '1980-01-01',
    @adminCargoUUID,
    0,
    0,
    NOW()
);


-- //// INSERT Planos base

INSERT INTO planos (uuid, codigo, slug, valor_em_centavos nome, descricao, excluido, usuario_criador_uuid, usuario_alterador_uuid)
VALUES 
  (UUID(), 1, 'plano_ouro', 30000, 'Plano Ouro', NULL, 0, NULL, NULL),
  (UUID(), 2, 'plano_prata', 20000, 'Plano Prata', NULL, 0, NULL, NULL),
  (UUID(), 3, 'plano_bronze', 10000, 'Plano Bronze', NULL, 0, NULL, NULL);


-- Reabilita checagem de foreign keys
SET FOREIGN_KEY_CHECKS = 1;