-- Cria 68 permissões na tabela "permissoes"
INSERT INTO permissoes (uuid, slug, tipo, descricao, modulo, excluido, usuario_criador_uuid, data_de_criacao, usuario_alterador_uuid, data_de_ultima_alteracao)
VALUES
-- USUARIOS (0)
('7418acc6-b98c-416d-a83c-8a34cb95e0c9', 'usuarios_ler', 0, 'Permissão de LER no módulo USUARIOS', 0, 0, NULL, NOW(), NULL, NOW()),
('868ab438-40fa-48d5-9db9-35ae3d3cea79', 'usuarios_criar', 1, 'Permissão de CRIAR no módulo USUARIOS', 0, 0, NULL, NOW(), NULL, NOW()),
('99928746-53a7-41dd-ab14-678e969418b7', 'usuarios_editar', 2, 'Permissão de EDITAR no módulo USUARIOS', 0, 0, NULL, NOW(), NULL, NOW()),
('a2cd16e3-a7e5-4fbb-893c-51bbef4ad879', 'usuarios_deletar', 3, 'Permissão de DELETAR no módulo USUARIOS', 0, 0, NULL, NOW(), NULL, NOW()),

-- ASSOCIACOES (1)
('2e8c935c-a156-4333-8d1e-526163cfab96', 'associacoes_ler', 0, 'Permissão de LER no módulo ASSOCIACOES', 1, 0, NULL, NOW(), NULL, NOW()),
('42c072b8-bd2f-4e04-a4ec-606d6f54cfd2', 'associacoes_criar', 1, 'Permissão de CRIAR no módulo ASSOCIACOES', 1, 0, NULL, NOW(), NULL, NOW()),
('b2c3af4a-bf90-49e8-a747-fc4692c0ca8a', 'associacoes_editar', 2, 'Permissão de EDITAR no módulo ASSOCIACOES', 1, 0, NULL, NOW(), NULL, NOW()),
('715ed780-381f-4d2b-bf35-fee7f73fa1ef', 'associacoes_deletar', 3, 'Permissão de DELETAR no módulo ASSOCIACOES', 1, 0, NULL, NOW(), NULL, NOW()),

-- HORTAS (2)
('64e8c1d0-2b16-484d-9978-29ffbe119e62', 'hortas_ler', 0, 'Permissão de LER no módulo HORTAS', 2, 0, NULL, NOW(), NULL, NOW()),
('aa0dc49a-3f2e-4b8f-a05e-0d4221f03148', 'hortas_criar', 1, 'Permissão de CRIAR no módulo HORTAS', 2, 0, NULL, NOW(), NULL, NOW()),
('4bcbd941-600e-4cee-b780-3635bab8ef36', 'hortas_editar', 2, 'Permissão de EDITAR no módulo HORTAS', 2, 0, NULL, NOW(), NULL, NOW()),
('04ac29ba-925e-4162-aed0-610091c403f9', 'hortas_deletar', 3, 'Permissão de DELETAR no módulo HORTAS', 2, 0, NULL, NOW(), NULL, NOW()),

-- ENDERECOS (3)
('c3450084-bc37-4be7-ac6a-5e6785c78d9f', 'enderecos_ler', 0, 'Permissão de LER no módulo ENDERECOS', 3, 0, NULL, NOW(), NULL, NOW()),
('7e4630e5-ae65-4357-8331-ea39b18550f5', 'enderecos_criar', 1, 'Permissão de CRIAR no módulo ENDERECOS', 3, 0, NULL, NOW(), NULL, NOW()),
('91821196-642f-4fd2-b03e-09fc2aee041c', 'enderecos_editar', 2, 'Permissão de EDITAR no módulo ENDERECOS', 3, 0, NULL, NOW(), NULL, NOW()),
('286964b2-c85c-4b68-b8cf-0568fbc83b98', 'enderecos_deletar', 3, 'Permissão de DELETAR no módulo ENDERECOS', 3, 0, NULL, NOW(), NULL, NOW()),

-- CANTEIROS (4)
('4d42bb66-46d2-4164-a6d0-a465fc0c13fc', 'canteiros_ler', 0, 'Permissão de LER no módulo CANTEIROS', 4, 0, NULL, NOW(), NULL, NOW()),
('e02c0be3-64b1-4e33-a98c-7fd6881ce9dd', 'canteiros_criar', 1, 'Permissão de CRIAR no módulo CANTEIROS', 4, 0, NULL, NOW(), NULL, NOW()),
('36431518-086a-492d-8f1f-94b9686f6162', 'canteiros_editar', 2, 'Permissão de EDITAR no módulo CANTEIROS', 4, 0, NULL, NOW(), NULL, NOW()),
('1f404e6c-4774-4325-986f-bdcd0ed6bdb5', 'canteiros_deletar', 3, 'Permissão de DELETAR no módulo CANTEIROS', 4, 0, NULL, NOW(), NULL, NOW()),

-- CANTEIROS_E_USUARIOS (5)
('fdf55dac-145d-4127-8c53-d2cce41278ee', 'canteiros_e_usuarios_ler', 0, 'Permissão de LER no módulo CANTEIROS_E_USUARIOS', 5, 0, NULL, NOW(), NULL, NOW()),
('a03a29fa-fba1-49b5-8fe0-349a5e32bacf', 'canteiros_e_usuarios_criar', 1, 'Permissão de CRIAR no módulo CANTEIROS_E_USUARIOS', 5, 0, NULL, NOW(), NULL, NOW()),
('4a5398e7-1e69-462c-a865-a9c9ac70e220', 'canteiros_e_usuarios_editar', 2, 'Permissão de EDITAR no módulo CANTEIROS_E_USUARIOS', 5, 0, NULL, NOW(), NULL, NOW()),
('635ac3cf-86c7-4e85-9076-d0f31ef6e617', 'canteiros_e_usuarios_deletar', 3, 'Permissão de DELETAR no módulo CANTEIROS_E_USUARIOS', 5, 0, NULL, NOW(), NULL, NOW()),

-- CARGOS (6)
('0194ff59-b345-4d8a-9d54-bddfd51a89df', 'cargos_ler', 0, 'Permissão de LER no módulo CARGOS', 6, 0, NULL, NOW(), NULL, NOW()),
('e8e6fa46-a1ab-4311-9181-2f93b483eebf', 'cargos_criar', 1, 'Permissão de CRIAR no módulo CARGOS', 6, 0, NULL, NOW(), NULL, NOW()),
('049fa3d4-7ac6-4ea1-8f84-bf0385476a92', 'cargos_editar', 2, 'Permissão de EDITAR no módulo CARGOS', 6, 0, NULL, NOW(), NULL, NOW()),
('5de35d85-bb06-4f2c-a9f2-2c381aa9d628', 'cargos_deletar', 3, 'Permissão de DELETAR no módulo CARGOS', 6, 0, NULL, NOW(), NULL, NOW()),

-- PERMISSOES (7)
('4ea31b6e-6aec-4c48-be67-1cc2b53fd3c6', 'permissoes_ler', 0, 'Permissão de LER no módulo PERMISSOES', 7, 0, NULL, NOW(), NULL, NOW()),
('32a323a8-2de9-493d-9f29-7a1422584b73', 'permissoes_criar', 1, 'Permissão de CRIAR no módulo PERMISSOES', 7, 0, NULL, NOW(), NULL, NOW()),
('8ffeb069-4a9c-4cb8-9f0c-1ca8fd956fea', 'permissoes_editar', 2, 'Permissão de EDITAR no módulo PERMISSOES', 7, 0, NULL, NOW(), NULL, NOW()),
('3754150e-c389-426e-a023-6d07d793c660', 'permissoes_deletar', 3, 'Permissão de DELETAR no módulo PERMISSOES', 7, 0, NULL, NOW(), NULL, NOW()),

-- PERMISSOES_DE_CARGO (8)
('a9c3991a-d5c4-4dc7-b68f-f720cd617272', 'permissoes_de_cargo_ler', 0, 'Permissão de LER no módulo PERMISSOES_DE_CARGO', 8, 0, NULL, NOW(), NULL, NOW()),
('56e48937-b394-4c11-8a2d-75b65b44ee8b', 'permissoes_de_cargo_criar', 1, 'Permissão de CRIAR no módulo PERMISSOES_DE_CARGO', 8, 0, NULL, NOW(), NULL, NOW()),
('507dfd3d-73d8-4679-9035-be3d7f4128ef', 'permissoes_de_cargo_editar', 2, 'Permissão de EDITAR no módulo PERMISSOES_DE_CARGO', 8, 0, NULL, NOW(), NULL, NOW()),
('b8d7e2e1-f723-411f-b96a-f31644f22c7d', 'permissoes_de_cargo_deletar', 3, 'Permissão de DELETAR no módulo PERMISSOES_DE_CARGO', 8, 0, NULL, NOW(), NULL, NOW()),

-- PERMISSOES_DE_EXCECAO (9)
('6f27f620-dc9b-459b-82c9-ab0021b41383', 'permissoes_de_excecao_ler', 0, 'Permissão de LER no módulo PERMISSOES_DE_EXCECAO', 9, 0, NULL, NOW(), NULL, NOW()),
('2ab7adb9-ca9c-4e24-b8c1-5d90720dbd5c', 'permissoes_de_excecao_criar', 1, 'Permissão de CRIAR no módulo PERMISSOES_DE_EXCECAO', 9, 0, NULL, NOW(), NULL, NOW()),
('c10ab6c5-5f63-4dea-8cfc-cd41f0411369', 'permissoes_de_excecao_editar', 2, 'Permissão de EDITAR no módulo PERMISSOES_DE_EXCECAO', 9, 0, NULL, NOW(), NULL, NOW()),
('ad91c0fe-0d45-42c0-ba2e-a71f0f4d7e49', 'permissoes_de_excecao_deletar', 3, 'Permissão de DELETAR no módulo PERMISSOES_DE_EXCECAO', 9, 0, NULL, NOW(), NULL, NOW()),

-- CATEGORIAS_FINANCEIRAS (10)
('78c334b8-916e-4dc9-a1d7-36d86c9c8c5b', 'categorias_financeiras_ler', 0, 'Permissão de LER no módulo CATEGORIAS_FINANCEIRAS', 10, 0, NULL, NOW(), NULL, NOW()),
('1142bfc2-9ae5-456c-83aa-05dd8f6b63bd', 'categorias_financeiras_criar', 1, 'Permissão de CRIAR no módulo CATEGORIAS_FINANCEIRAS', 10, 0, NULL, NOW(), NULL, NOW()),
('2d633cb1-664e-4174-a004-141552f63c1b', 'categorias_financeiras_editar', 2, 'Permissão de EDITAR no módulo CATEGORIAS_FINANCEIRAS', 10, 0, NULL, NOW(), NULL, NOW()),
('4b35bd1f-f9b2-49af-a59c-963489a66e3a', 'categorias_financeiras_deletar', 3, 'Permissão de DELETAR no módulo CATEGORIAS_FINANCEIRAS', 10, 0, NULL, NOW(), NULL, NOW()),

-- FINANCEIRO_HORTA (11)
('4267f2e8-5ef4-46cc-a9c8-52a07d1f0bcb', 'financeiro_horta_ler', 0, 'Permissão de LER no módulo FINANCEIRO_HORTA', 11, 0, NULL, NOW(), NULL, NOW()),
('33403846-3fe5-4c16-92ef-fea51a460fa0', 'financeiro_horta_criar', 1, 'Permissão de CRIAR no módulo FINANCEIRO_HORTA', 11, 0, NULL, NOW(), NULL, NOW()),
('d12505b8-8b29-4876-bb89-3b5a7d55d64b', 'financeiro_horta_editar', 2, 'Permissão de EDITAR no módulo FINANCEIRO_HORTA', 11, 0, NULL, NOW(), NULL, NOW()),
('9d6ec83b-2b4d-4c0c-bf89-c73baf316c3e', 'financeiro_horta_deletar', 3, 'Permissão de DELETAR no módulo FINANCEIRO_HORTA', 11, 0, NULL, NOW(), NULL, NOW()),

-- FINANCEIRO_ASSOCIACAO (12)
('61622fc1-f276-4db5-90f0-50e3925ec46b', 'financeiro_associacao_ler', 0, 'Permissão de LER no módulo FINANCEIRO_ASSOCIACAO', 12, 0, NULL, NOW(), NULL, NOW()),
('f3268b41-b7e8-4ee2-84fa-3d2e4c3d55a7', 'financeiro_associacao_criar', 1, 'Permissão de CRIAR no módulo FINANCEIRO_ASSOCIACAO', 12, 0, NULL, NOW(), NULL, NOW()),
('0b7e6e1f-b5b5-44fa-bd3e-0ebf0577b2b5', 'financeiro_associacao_editar', 2, 'Permissão de EDITAR no módulo FINANCEIRO_ASSOCIACAO', 12, 0, NULL, NOW(), NULL, NOW()),
('b2f0ecb6-ef83-4f29-82b6-1a99a37c91f0', 'financeiro_associacao_deletar', 3, 'Permissão de DELETAR no módulo FINANCEIRO_ASSOCIACAO', 12, 0, NULL, NOW(), NULL, NOW()),

-- MENSALIDADES_DA_ASSOCIACAO (13)
('07f5f3e6-1058-44cb-83d8-f5b526ea2c7a', 'mensalidades_da_associacao_ler', 0, 'Permissão de LER no módulo MENSALIDADES_DA_ASSOCIACAO', 13, 0, NULL, NOW(), NULL, NOW()),
('b1e4977c-1c3e-4f1a-a3fc-68d1f0f720c0', 'mensalidades_da_associacao_criar', 1, 'Permissão de CRIAR no módulo MENSALIDADES_DA_ASSOCIACAO', 13, 0, NULL, NOW(), NULL, NOW()),
('c963c064-2f90-4b2e-9cbb-b18c0f2e4561', 'mensalidades_da_associacao_editar', 2, 'Permissão de EDITAR no módulo MENSALIDADES_DA_ASSOCIACAO', 13, 0, NULL, NOW(), NULL, NOW()),
('827d7b5c-5b5a-48f3-a3fa-045c2a95d6f2', 'mensalidades_da_associacao_deletar', 3, 'Permissão de DELETAR no módulo MENSALIDADES_DA_ASSOCIACAO', 13, 0, NULL, NOW(), NULL, NOW()),

-- MENSALIDADES_DA_PLATAFORMA (14)
('c8b3f1f7-0e6d-4fc3-9cde-1d9fa8fbb7ef', 'mensalidades_da_plataforma_ler', 0, 'Permissão de LER no módulo MENSALIDADES_DA_PLATAFORMA', 14, 0, NULL, NOW(), NULL, NOW()),
('7a4d9e91-7a1b-4f49-9f35-15b7e1f7f3b9', 'mensalidades_da_plataforma_criar', 1, 'Permissão de CRIAR no módulo MENSALIDADES_DA_PLATAFORMA', 14, 0, NULL, NOW(), NULL, NOW()),
('d9158f38-10a2-4e3b-9d15-0b65ea9d4c72', 'mensalidades_da_plataforma_editar', 2, 'Permissão de EDITAR no módulo MENSALIDADES_DA_PLATAFORMA', 14, 0, NULL, NOW(), NULL, NOW()),
('12a4cb7a-2f36-42b5-b8c1-2f58d623f43d', 'mensalidades_da_plataforma_deletar', 3, 'Permissão de DELETAR no módulo MENSALIDADES_DA_PLATAFORMA', 14, 0, NULL, NOW(), NULL, NOW()),

-- PLANOS (15)
('e0f11c42-6f1f-46c1-8d44-1e7a9c7f0b33', 'planos_ler', 0, 'Permissão de LER no módulo PLANOS', 15, 0, NULL, NOW(), NULL, NOW()),
('b6a7b3c8-3c1b-4ed2-8c57-f20a0a2c8d6e', 'planos_criar', 1, 'Permissão de CRIAR no módulo PLANOS', 15, 0, NULL, NOW(), NULL, NOW()),
('c5a3e21d-9c10-44d1-9b85-14d0e9c0b2f9', 'planos_editar', 2, 'Permissão de EDITAR no módulo PLANOS', 15, 0, NULL, NOW(), NULL, NOW()),
('a3b2c1d4-5f1b-4d2c-8b3c-12a3f4e5b6c7', 'planos_deletar', 3, 'Permissão de DELETAR no módulo PLANOS', 15, 0, NULL, NOW(), NULL, NOW()),

-- RECURSOS_DO_PLANO (16)
('5a6b7c8d-9e0f-4a1b-8c2d-3e4f5a6b7c8d', 'recursos_do_plano_ler', 0, 'Permissão de LER no módulo RECURSOS_DO_PLANO', 16, 0, NULL, NOW(), NULL, NOW()),
('6c7d8e9f-0a1b-4c2d-8e3f-4a5b6c7d8e9f', 'recursos_do_plano_criar', 1, 'Permissão de CRIAR no módulo RECURSOS_DO_PLANO', 16, 0, NULL, NOW(), NULL, NOW()),
('7d8e9f0a-1b2c-4d3e-9f4a-5b6c7d8e9f0a', 'recursos_do_plano_editar', 2, 'Permissão de EDITAR no módulo RECURSOS_DO_PLANO', 16, 0, NULL, NOW(), NULL, NOW()),
('8e9f0a1b-2c3d-4e5f-0a1b-6c7d8e9f0a1b', 'recursos_do_plano_deletar', 3, 'Permissão de DELETAR no módulo RECURSOS_DO_PLANO', 16, 0, NULL, NOW(), NULL, NOW());
