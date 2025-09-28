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

-- //// Adiciona usuário super admin em "usuarios"
-- email e senha na doc
INSERT INTO usuarios (
    uuid,
    nome_completo,
    cpf,
    email,
    senha,
    data_de_nascimento,
    cargo_uuid,
    taxa_associado_em_centavos,
    endereco_uuid,
    associacao_uuid,
    horta_uuid,
    usuario_associado_uuid,
    status_de_acesso,
    responsavel_da_conta,
    data_bloqueio_acesso,
    motivo_bloqueio_acesso,
    excluido,
    usuario_criador_uuid,
    data_de_criacao,
    usuario_alterador_uuid,
    data_de_ultima_alteracao,
    apelido,
    dias_ausente,
    chave_uuid
)
SELECT
    UUID(),
    'Admin Hortas Comunitárias',
    '123.456.789-09',
    '$2y$10$TUHWKOcJj85/pMDxEg7eTu3zGDlE2sfOdVn4dfSN5JzMIqssNISYG',
    NULL,
    c.uuid,
    0,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL,
    0,
    NULL,
    NOW(),
    NULL,
    NOW(),
    NULL,
    NULL,
    0,
    NULL
FROM cargos c
WHERE c.slug = 'admin_plataforma';

-- Reabilita checagem de foreign keys
SET FOREIGN_KEY_CHECKS = 1;