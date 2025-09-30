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
-- Desabilita checagem de foreign keys temporariamente
SET FOREIGN_KEY_CHECKS = 0;

-- ================= LIMPEZA =================
DELETE FROM permissoes_de_cargo;
DELETE FROM permissoes;

-- ================= INSERTS DE PERMISSÕES =================

-- ================= SESSÕES (PÚBLICAS) =================
INSERT INTO permissoes (uuid, slug, tipo, descricao, modulo, excluido, usuario_criador_uuid, data_de_criacao, usuario_alterador_uuid, data_de_ultima_alteracao) VALUES
(UUID(), 'sessoes_login', 0, 'Permissão para realizar login', 100, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'sessoes_cadastro', 1, 'Permissão para realizar cadastro', 100, 0, NULL, NOW(), NULL, NOW());

-- ================= ASSOCIACOES =================
INSERT INTO permissoes VALUES
(UUID(), 'associacoes_get', 0, 'Listar associações', 1, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'associacoes_get_uuid', 0, 'Buscar associação por UUID', 1, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'associacoes_post', 1, 'Criar associação', 1, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'associacoes_put', 2, 'Editar associação', 1, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'associacoes_delete', 3, 'Deletar associação', 1, 0, NULL, NOW(), NULL, NOW());

-- ================= CANTEIROS E USUARIOS =================
INSERT INTO permissoes VALUES
(UUID(), 'canteiros_e_usuarios_get', 0, 'Listar canteiros e usuários', 5, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'canteiros_e_usuarios_get_uuid', 0, 'Buscar canteiro e usuário por UUID', 5, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'canteiros_e_usuarios_post', 1, 'Criar relação canteiro e usuário', 5, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'canteiros_e_usuarios_put', 2, 'Editar relação canteiro e usuário', 5, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'canteiros_e_usuarios_delete', 3, 'Deletar relação canteiro e usuário', 5, 0, NULL, NOW(), NULL, NOW());

-- ================= CANTEIROS =================
INSERT INTO permissoes VALUES
(UUID(), 'canteiros_get', 0, 'Listar canteiros', 4, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'canteiros_get_uuid', 0, 'Buscar canteiro por UUID', 4, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'canteiros_post', 1, 'Criar canteiro', 4, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'canteiros_put', 2, 'Editar canteiro', 4, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'canteiros_delete', 3, 'Deletar canteiro', 4, 0, NULL, NOW(), NULL, NOW());

-- ================= CARGOS =================
INSERT INTO permissoes VALUES
(UUID(), 'cargos_get', 0, 'Listar cargos', 6, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'cargos_get_uuid', 0, 'Buscar cargo por UUID', 6, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'cargos_post', 1, 'Criar cargo', 6, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'cargos_put', 2, 'Editar cargo', 6, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'cargos_delete', 3, 'Deletar cargo', 6, 0, NULL, NOW(), NULL, NOW());

-- ================= CATEGORIAS FINANCEIRAS =================
INSERT INTO permissoes VALUES
(UUID(), 'categorias_financeiras_get', 0, 'Listar categorias financeiras', 10, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'categorias_financeiras_get_uuid', 0, 'Buscar categoria financeira por UUID', 10, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'categorias_financeiras_get_associacao', 0, 'Listar categorias financeiras por associação', 10, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'categorias_financeiras_get_horta', 0, 'Listar categorias financeiras por horta', 10, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'categorias_financeiras_post', 1, 'Criar categoria financeira', 10, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'categorias_financeiras_put', 2, 'Editar categoria financeira', 10, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'categorias_financeiras_delete', 3, 'Deletar categoria financeira', 10, 0, NULL, NOW(), NULL, NOW());

-- ================= CHAVES =================
INSERT INTO permissoes VALUES
(UUID(), 'chaves_get', 0, 'Listar chaves', 17, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'chaves_get_uuid', 0, 'Buscar chave por UUID', 17, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'chaves_post', 1, 'Criar chave', 17, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'chaves_put', 2, 'Editar chave', 17, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'chaves_delete', 3, 'Deletar chave', 17, 0, NULL, NOW(), NULL, NOW());

-- ================= ENDERECOS =================
INSERT INTO permissoes VALUES
(UUID(), 'enderecos_get', 0, 'Listar endereços', 3, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'enderecos_get_uuid', 0, 'Buscar endereço por UUID', 3, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'enderecos_post', 1, 'Criar endereço', 3, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'enderecos_put', 2, 'Editar endereço', 3, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'enderecos_delete', 3, 'Deletar endereço', 3, 0, NULL, NOW(), NULL, NOW());

-- ================= FILA DE USUARIOS =================
INSERT INTO permissoes VALUES
(UUID(), 'fila_de_usuarios_get', 0, 'Listar fila de usuários', 18, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'fila_de_usuarios_get_uuid', 0, 'Buscar fila de usuário por UUID', 18, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'fila_de_usuarios_get_horta', 0, 'Listar fila de usuários por horta', 18, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'fila_de_usuarios_get_usuario', 0, 'Listar fila de usuários por usuário', 18, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'fila_de_usuarios_post', 1, 'Criar entrada na fila de usuários', 18, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'fila_de_usuarios_put', 2, 'Editar entrada na fila de usuários', 18, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'fila_de_usuarios_delete', 3, 'Deletar entrada na fila de usuários', 18, 0, NULL, NOW(), NULL, NOW());

-- ================= FINANCEIRO DA ASSOCIACAO =================
INSERT INTO permissoes VALUES
(UUID(), 'financeiro_da_associacao_get', 0, 'Listar lançamentos financeiros da associação', 12, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'financeiro_da_associacao_get_uuid', 0, 'Buscar lançamento financeiro da associação por UUID', 12, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'financeiro_da_associacao_get_associacao', 0, 'Listar lançamentos financeiros por associação', 12, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'financeiro_da_associacao_post', 1, 'Criar lançamento financeiro da associação', 12, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'financeiro_da_associacao_put', 2, 'Editar lançamento financeiro da associação', 12, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'financeiro_da_associacao_delete', 3, 'Deletar lançamento financeiro da associação', 12, 0, NULL, NOW(), NULL, NOW());

-- ================= FINANCEIRO DA HORTA =================
INSERT INTO permissoes VALUES
(UUID(), 'financeiro_da_horta_get', 0, 'Listar lançamentos financeiros da horta', 11, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'financeiro_da_horta_get_uuid', 0, 'Buscar lançamento financeiro da horta por UUID', 11, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'financeiro_da_horta_get_horta', 0, 'Listar lançamentos financeiros por horta', 11, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'financeiro_da_horta_post', 1, 'Criar lançamento financeiro da horta', 11, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'financeiro_da_horta_put', 2, 'Editar lançamento financeiro da horta', 11, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'financeiro_da_horta_delete', 3, 'Deletar lançamento financeiro da horta', 11, 0, NULL, NOW(), NULL, NOW());

-- ================= HORTAS =================
INSERT INTO permissoes VALUES
(UUID(), 'hortas_get', 0, 'Listar hortas', 2, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'hortas_get_uuid', 0, 'Buscar horta por UUID', 2, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'hortas_post', 1, 'Criar horta', 2, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'hortas_put', 2, 'Editar horta', 2, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'hortas_delete', 3, 'Deletar horta', 2, 0, NULL, NOW(), NULL, NOW());

-- ================= MENSALIDADES DA PLATAFORMA (cobradas pela plataforma das associações) =================
INSERT INTO permissoes VALUES
(UUID(), 'mensalidades_da_plataforma_get', 0, 'Listar mensalidades da plataforma', 13, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'mensalidades_da_plataforma_get_uuid', 0, 'Buscar mensalidade da plataforma por UUID', 13, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'mensalidades_da_plataforma_get_associacao', 0, 'Listar mensalidades da plataforma por associação', 13, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'mensalidades_da_plataforma_get_usuario', 0, 'Listar mensalidades da plataforma por usuário', 13, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'mensalidades_da_plataforma_post', 1, 'Criar mensalidade da plataforma', 13, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'mensalidades_da_plataforma_put', 2, 'Editar mensalidade da plataforma', 13, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'mensalidades_da_plataforma_delete', 3, 'Deletar mensalidade da plataforma', 13, 0, NULL, NOW(), NULL, NOW());

-- ================= MENSALIDADES DA ASSOCIACAO (cobradas pela associação dos usuários) =================
INSERT INTO permissoes VALUES
(UUID(), 'mensalidades_da_associacao_get', 0, 'Listar mensalidades da associação', 14, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'mensalidades_da_associacao_get_uuid', 0, 'Buscar mensalidade da associação por UUID', 14, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'mensalidades_da_associacao_get_usuario', 0, 'Listar mensalidades da associação por usuário', 14, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'mensalidades_da_associacao_post', 1, 'Criar mensalidade da associação', 14, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'mensalidades_da_associacao_put', 2, 'Editar mensalidade da associação', 14, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'mensalidades_da_associacao_delete', 3, 'Deletar mensalidade da associação', 14, 0, NULL, NOW(), NULL, NOW());

-- ================= PERMISSOES DE CARGO =================
INSERT INTO permissoes VALUES
(UUID(), 'permissoes_de_cargo_get', 0, 'Listar permissões de cargo', 8, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'permissoes_de_cargo_get_uuid', 0, 'Buscar permissão de cargo por UUID', 8, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'permissoes_de_cargo_get_cargo', 0, 'Listar permissões por cargo', 8, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'permissoes_de_cargo_post', 1, 'Criar permissão de cargo', 8, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'permissoes_de_cargo_put', 2, 'Editar permissão de cargo', 8, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'permissoes_de_cargo_delete', 3, 'Deletar permissão de cargo', 8, 0, NULL, NOW(), NULL, NOW());

-- ================= PERMISSOES DE EXCECAO =================
INSERT INTO permissoes VALUES
(UUID(), 'permissoes_de_excecao_get', 0, 'Listar permissões de exceção', 9, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'permissoes_de_excecao_get_uuid', 0, 'Buscar permissão de exceção por UUID', 9, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'permissoes_de_excecao_post', 1, 'Criar permissão de exceção', 9, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'permissoes_de_excecao_put', 2, 'Editar permissão de exceção', 9, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'permissoes_de_excecao_delete', 3, 'Deletar permissão de exceção', 9, 0, NULL, NOW(), NULL, NOW());

-- ================= PERMISSOES DO USUARIO =================
INSERT INTO permissoes VALUES
(UUID(), 'permissoes_do_usuario_get', 0, 'Buscar permissões do usuário', 19, 0, NULL, NOW(), NULL, NOW());

-- ================= PERMISSOES =================
INSERT INTO permissoes VALUES
(UUID(), 'permissoes_get', 0, 'Listar permissões', 7, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'permissoes_get_uuid', 0, 'Buscar permissão por UUID', 7, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'permissoes_post', 1, 'Criar permissão', 7, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'permissoes_put', 2, 'Editar permissão', 7, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'permissoes_delete', 3, 'Deletar permissão', 7, 0, NULL, NOW(), NULL, NOW());

-- ================= PLANOS =================
INSERT INTO permissoes VALUES
(UUID(), 'planos_get', 0, 'Listar planos', 15, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'planos_get_uuid', 0, 'Buscar plano por UUID', 15, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'planos_get_usuario', 0, 'Listar planos por usuário', 15, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'planos_post', 1, 'Criar plano', 15, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'planos_put', 2, 'Editar plano', 15, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'planos_delete', 3, 'Deletar plano', 15, 0, NULL, NOW(), NULL, NOW());

-- ================= RECURSOS DO PLANO =================
INSERT INTO permissoes VALUES
(UUID(), 'recursos_do_plano_get', 0, 'Listar recursos do plano', 16, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'recursos_do_plano_get_uuid', 0, 'Buscar recurso do plano por UUID', 16, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'recursos_do_plano_get_plano', 0, 'Listar recursos por plano', 16, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'recursos_do_plano_post', 1, 'Criar recurso do plano', 16, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'recursos_do_plano_put', 2, 'Editar recurso do plano', 16, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'recursos_do_plano_delete', 3, 'Deletar recurso do plano', 16, 0, NULL, NOW(), NULL, NOW());

-- ================= USUARIOS =================
INSERT INTO permissoes VALUES
(UUID(), 'usuarios_get', 0, 'Listar usuários', 0, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'usuarios_get_uuid', 0, 'Buscar usuário por UUID', 0, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'usuarios_post', 1, 'Criar usuário', 0, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'usuarios_put', 2, 'Editar usuário', 0, 0, NULL, NOW(), NULL, NOW()),
(UUID(), 'usuarios_delete', 3, 'Deletar usuário', 0, 0, NULL, NOW(), NULL, NOW());

-- ================= INSERTS DE PERMISSÕES POR CARGO =================

-- ADMIN DA PLATAFORMA - TODAS as permissões (exceto as públicas)
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
WHERE c.slug = 'admin_plataforma'
AND p.slug NOT IN ('sessoes_login', 'sessoes_cadastro');

-- ADMIN DA ASSOCIAÇÃO
INSERT INTO permissoes_de_cargo (uuid, cargo_uuid, permissao_uuid, excluido, usuario_criador_uuid, data_de_criacao)
SELECT UUID(), c.uuid, p.uuid, 0, NULL, NOW()
FROM cargos c CROSS JOIN permissoes p
WHERE c.slug = 'admin_associacao_geral'
AND p.slug IN (
    -- Usuarios
    'usuarios_get', 'usuarios_get_uuid', 'usuarios_post', 'usuarios_put', 'usuarios_delete',
    -- Hortas
    'hortas_get', 'hortas_get_uuid', 'hortas_post', 'hortas_put', 'hortas_delete',
    -- Enderecos
    'enderecos_get', 'enderecos_get_uuid', 'enderecos_post', 'enderecos_put', 'enderecos_delete',
    -- Canteiros
    'canteiros_get', 'canteiros_get_uuid', 'canteiros_post', 'canteiros_put', 'canteiros_delete',
    -- Canteiros e Usuarios
    'canteiros_e_usuarios_get', 'canteiros_e_usuarios_get_uuid', 'canteiros_e_usuarios_post', 'canteiros_e_usuarios_put', 'canteiros_e_usuarios_delete',
    -- Cargos (somente leitura)
    'cargos_get', 'cargos_get_uuid',
    -- Permissoes de Cargo (somente leitura)
    'permissoes_de_cargo_get', 'permissoes_de_cargo_get_uuid', 'permissoes_de_cargo_get_cargo',
    -- Permissoes de Excecao (completo)
    'permissoes_de_excecao_get', 'permissoes_de_excecao_get_uuid', 'permissoes_de_excecao_post', 'permissoes_de_excecao_put', 'permissoes_de_excecao_delete',
    -- Permissoes do Usuario
    'permissoes_do_usuario_get',
    -- Categorias Financeiras
    'categorias_financeiras_get', 'categorias_financeiras_get_uuid', 'categorias_financeiras_get_associacao', 'categorias_financeiras_get_horta', 
    'categorias_financeiras_post', 'categorias_financeiras_put', 'categorias_financeiras_delete',
    -- Financeiro da Horta
    'financeiro_da_horta_get', 'financeiro_da_horta_get_uuid', 'financeiro_da_horta_get_horta', 
    'financeiro_da_horta_post', 'financeiro_da_horta_put', 'financeiro_da_horta_delete',
    -- Financeiro da Associacao
    'financeiro_da_associacao_get', 'financeiro_da_associacao_get_uuid', 
    'financeiro_da_associacao_post', 'financeiro_da_associacao_put', 'financeiro_da_associacao_delete',
    -- Mensalidades da Plataforma (somente leitura)
    'mensalidades_da_plataforma_get', 'mensalidades_da_plataforma_get_uuid',
    -- Mensalidades da Associacao (completo)
    'mensalidades_da_associacao_get', 'mensalidades_da_associacao_get_uuid', 'mensalidades_da_associacao_get_usuario',
    -- Planos (somente leitura)
    'planos_get', 'planos_get_uuid', 'planos_get_usuario',
    -- Chaves
    'chaves_get', 'chaves_get_uuid', 'chaves_post', 'chaves_put', 'chaves_delete',
    -- Fila de Usuarios
    'fila_de_usuarios_get', 'fila_de_usuarios_get_uuid', 'fila_de_usuarios_get_horta', 'fila_de_usuarios_get_usuario', 
    'fila_de_usuarios_post', 'fila_de_usuarios_put', 'fila_de_usuarios_delete'
);

-- ADMIN DA HORTA
INSERT INTO permissoes_de_cargo (uuid, cargo_uuid, permissao_uuid, excluido, usuario_criador_uuid, data_de_criacao)
SELECT UUID(), c.uuid, p.uuid, 0, NULL, NOW()
FROM cargos c CROSS JOIN permissoes p
WHERE c.slug = 'admin_horta_geral'
AND p.slug IN (
    -- Usuarios
    'usuarios_get', 'usuarios_get_uuid', 'usuarios_post', 'usuarios_put', 'usuarios_delete',
    -- Hortas (somente leitura)
    'hortas_get', 'hortas_get_uuid',
    -- Enderecos
    'enderecos_get', 'enderecos_get_uuid', 'enderecos_post', 'enderecos_put', 'enderecos_delete',
    -- Canteiros
    'canteiros_get', 'canteiros_get_uuid', 'canteiros_post', 'canteiros_put', 'canteiros_delete',
    -- Canteiros e Usuarios
    'canteiros_e_usuarios_get', 'canteiros_e_usuarios_get_uuid', 'canteiros_e_usuarios_post', 'canteiros_e_usuarios_put', 'canteiros_e_usuarios_delete',
    -- Cargos (somente leitura)
    'cargos_get', 'cargos_get_uuid',
    -- Permissoes do Usuario
    'permissoes_do_usuario_get',
    -- Categorias Financeiras
    'categorias_financeiras_get', 'categorias_financeiras_get_uuid', 'categorias_financeiras_get_horta', 
    'categorias_financeiras_post', 'categorias_financeiras_put', 'categorias_financeiras_delete',
    -- Financeiro da Horta
    'financeiro_da_horta_get', 'financeiro_da_horta_get_uuid', 'financeiro_da_horta_get_horta', 
    'financeiro_da_horta_post', 'financeiro_da_horta_put', 'financeiro_da_horta_delete',
    -- Financeiro da Associacao (somente leitura)
    'financeiro_da_associacao_get', 'financeiro_da_associacao_get_uuid',
    -- Chaves
    'chaves_get', 'chaves_get_uuid', 'chaves_post', 'chaves_put', 'chaves_delete',
    -- Fila de Usuarios
    'fila_de_usuarios_get', 'fila_de_usuarios_get_uuid', 'fila_de_usuarios_get_horta', 'fila_de_usuarios_get_usuario', 
    'fila_de_usuarios_post', 'fila_de_usuarios_put', 'fila_de_usuarios_delete'
);

-- CANTEIRISTA
INSERT INTO permissoes_de_cargo (uuid, cargo_uuid, permissao_uuid, excluido, usuario_criador_uuid, data_de_criacao)
SELECT UUID(), c.uuid, p.uuid, 0, NULL, NOW()
FROM cargos c CROSS JOIN permissoes p
WHERE c.slug = 'canteirista'
AND p.slug IN (
    -- Canteiros (somente leitura)
    'canteiros_get', 'canteiros_get_uuid',
    -- Canteiros e Usuarios (somente leitura)
    'canteiros_e_usuarios_get', 'canteiros_e_usuarios_get_uuid',
    -- Permissoes do Usuario
    'permissoes_do_usuario_get',
    -- Financeiro da Horta (somente leitura)
    'financeiro_da_horta_get', 'financeiro_da_horta_get_uuid', 'financeiro_da_horta_get_horta',
    -- Financeiro da Associacao (somente leitura)
    'financeiro_da_associacao_get', 'financeiro_da_associacao_get_uuid',
    -- Fila de Usuarios (somente leitura)
    'fila_de_usuarios_get', 'fila_de_usuarios_get_uuid', 'fila_de_usuarios_get_horta', 'fila_de_usuarios_get_usuario'
);

-- DEPENDENTE
INSERT INTO permissoes_de_cargo (uuid, cargo_uuid, permissao_uuid, excluido, usuario_criador_uuid, data_de_criacao)
SELECT UUID(), c.uuid, p.uuid, 0, NULL, NOW()
FROM cargos c CROSS JOIN permissoes p
WHERE c.slug = 'dependente'
AND p.slug IN (
    -- Canteiros (somente leitura)
    'canteiros_get', 'canteiros_get_uuid',
    -- Canteiros e Usuarios (somente leitura)
    'canteiros_e_usuarios_get', 'canteiros_e_usuarios_get_uuid',
    -- Permissoes do Usuario
    'permissoes_do_usuario_get',
    -- Financeiro da Horta (somente leitura)
    'financeiro_da_horta_get', 'financeiro_da_horta_get_uuid', 'financeiro_da_horta_get_horta',
    -- Financeiro da Associacao (somente leitura)
    'financeiro_da_associacao_get', 'financeiro_da_associacao_get_uuid',
    -- Fila de Usuarios (somente leitura)
    'fila_de_usuarios_get', 'fila_de_usuarios_get_uuid', 'fila_de_usuarios_get_horta', 'fila_de_usuarios_get_usuario'
);

-- Reabilita checagem de foreign keys
SET FOREIGN_KEY_CHECKS = 1;

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
    'hortas_comunitarias@univille.br',
    '$2y$10$TUHWKOcJj85/pMDxEg7eTu3zGDlE2sfOdVn4dfSN5JzMIqssNISYG', -- hash de senha
    '1980-01-01',
    @adminCargoUUID,
    0,
    0,
    NOW()
);


-- //// INSERT Planos base

INSERT INTO planos (uuid, codigo, slug, valor_em_centavos, nome, descricao, excluido, usuario_criador_uuid, usuario_alterador_uuid)
VALUES 
  (UUID(), 1, 'plano_ouro', 30000, 'Plano Ouro', NULL, 0, NULL, NULL),
  (UUID(), 2, 'plano_prata', 20000, 'Plano Prata', NULL, 0, NULL, NULL),
  (UUID(), 3, 'plano_bronze', 10000, 'Plano Bronze', NULL, 0, NULL, NULL);


-- Reabilita checagem de foreign keys
SET FOREIGN_KEY_CHECKS = 1;