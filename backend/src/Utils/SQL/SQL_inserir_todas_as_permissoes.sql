-- Limpa tabela
TRUNCATE TABLE permissoes;

-- ================= USUARIOS =================
INSERT INTO permissoes (uuid, slug, tipo, descricao, modulo, excluido, usuario_criador_uuid, data_de_criacao, usuario_alterador_uuid, data_de_ultima_alteracao) VALUES
('4af63cef-b6b5-4f33-b6bd-f347bf2456bf', 'usuarios_ler', 0, 'Permissão de LER no módulo USUARIOS', 0, 0, NULL, NOW(), NULL, NOW()),
('7be5c59e-978c-495f-b48a-f66400a2ffc3', 'usuarios_criar', 1, 'Permissão de CRIAR no módulo USUARIOS', 0, 0, NULL, NOW(), NULL, NOW()),
('7e2a2a54-d142-4e7c-8974-5d9ead9c5b0d', 'usuarios_editar', 2, 'Permissão de EDITAR no módulo USUARIOS', 0, 0, NULL, NOW(), NULL, NOW()),
('5042c4c5-c8aa-4d58-ae09-e546542300e0', 'usuarios_deletar', 3, 'Permissão de DELETAR no módulo USUARIOS', 0, 0, NULL, NOW(), NULL, NOW());

-- ================= ASSOCIACOES =================
INSERT INTO permissoes VALUES
('d281acb5-6759-4c3b-acf8-9b4c4e568ade', 'associacoes_ler', 0, 'Permissão de LER no módulo ASSOCIACOES', 1, 0, NULL, NOW(), NULL, NOW()),
('8d6009c7-8e43-4378-9ff2-52ef342a3674', 'associacoes_criar', 1, 'Permissão de CRIAR no módulo ASSOCIACOES', 1, 0, NULL, NOW(), NULL, NOW()),
('419f796c-376f-4c9b-a7f1-356d6c74826a', 'associacoes_editar', 2, 'Permissão de EDITAR no módulo ASSOCIACOES', 1, 0, NULL, NOW(), NULL, NOW()),
('45e1d7c2-6d91-4954-a084-002cafdbe4cb', 'associacoes_deletar', 3, 'Permissão de DELETAR no módulo ASSOCIACOES', 1, 0, NULL, NOW(), NULL, NOW());

-- ================= HORTAS =================
INSERT INTO permissoes VALUES
('87ac1d25-5f97-4fbb-bdf8-5e57dc0a56f9', 'hortas_ler', 0, 'Permissão de LER no módulo HORTAS', 2, 0, NULL, NOW(), NULL, NOW()),
('b4e1a7d3-1e2c-4e37-9e0d-36bc799bcf6c', 'hortas_criar', 1, 'Permissão de CRIAR no módulo HORTAS', 2, 0, NULL, NOW(), NULL, NOW()),
('2d92a8cf-2f0c-40a4-9204-53d63b64a1bc', 'hortas_editar', 2, 'Permissão de EDITAR no módulo HORTAS', 2, 0, NULL, NOW(), NULL, NOW()),
('3f29b4d0-497b-463b-8469-49c8dc2e6fae', 'hortas_deletar', 3, 'Permissão de DELETAR no módulo HORTAS', 2, 0, NULL, NOW(), NULL, NOW());

-- ================= ENDERECOS =================
INSERT INTO permissoes VALUES
('1f92c8a4-2a1e-4375-8d25-98cfb7f64e88', 'enderecos_ler', 0, 'Permissão de LER no módulo ENDERECOS', 3, 0, NULL, NOW(), NULL, NOW()),
('6e7d9f77-0c2d-4b38-aed1-229c05f3a9f1', 'enderecos_criar', 1, 'Permissão de CRIAR no módulo ENDERECOS', 3, 0, NULL, NOW(), NULL, NOW()),
('3c7d9e11-90fb-4c6b-8e3d-2bfc30b1c88e', 'enderecos_editar', 2, 'Permissão de EDITAR no módulo ENDERECOS', 3, 0, NULL, NOW(), NULL, NOW()),
('b9aeb1fc-2f61-4db0-a123-5cb41659f645', 'enderecos_deletar', 3, 'Permissão de DELETAR no módulo ENDERECOS', 3, 0, NULL, NOW(), NULL, NOW());

-- ================= CANTEIROS =================
INSERT INTO permissoes VALUES
('7c3b70b1-0d89-4a3d-b7a4-3f9f68c3d91f', 'canteiros_ler', 0, 'Permissão de LER no módulo CANTEIROS', 4, 0, NULL, NOW(), NULL, NOW()),
('9a4c12b5-41ea-4b1a-8434-3f607e9e2b6f', 'canteiros_criar', 1, 'Permissão de CRIAR no módulo CANTEIROS', 4, 0, NULL, NOW(), NULL, NOW()),
('f2a1d2e5-6e35-4c2b-9f52-5f8a9c63b2f4', 'canteiros_editar', 2, 'Permissão de EDITAR no módulo CANTEIROS', 4, 0, NULL, NOW(), NULL, NOW()),
('c3f5d8b9-5a1f-4e1b-bb60-9a5d8f6a5e7b', 'canteiros_deletar', 3, 'Permissão de DELETAR no módulo CANTEIROS', 4, 0, NULL, NOW(), NULL, NOW());

-- ================= CANTEIROS_E_USUARIOS =================
INSERT INTO permissoes VALUES
('b7c0a5f4-3b9d-4c5f-9b0e-5f8d6c7a8f9b', 'canteiros_usuarios_ler', 0, 'Permissão de LER no módulo CANTEIROS_E_USUARIOS', 5, 0, NULL, NOW(), NULL, NOW()),
('e8f5a4b3-0d7c-4f9b-b5c1-2a7e8c1d9f4b', 'canteiros_usuarios_criar', 1, 'Permissão de CRIAR no módulo CANTEIROS_E_USUARIOS', 5, 0, NULL, NOW(), NULL, NOW()),
('f1a4c2d5-8b9c-4e1a-9d2b-5f6a9b8d2c3e', 'canteiros_usuarios_editar', 2, 'Permissão de EDITAR no módulo CANTEIROS_E_USUARIOS', 5, 0, NULL, NOW(), NULL, NOW()),
('d3e4b5f6-1c2b-4a3e-b4f5-9c6d7e8f9a1b', 'canteiros_usuarios_deletar', 3, 'Permissão de DELETAR no módulo CANTEIROS_E_USUARIOS', 5, 0, NULL, NOW(), NULL, NOW());

-- ================= CARGOS =================
INSERT INTO permissoes VALUES
('a1b2c3d4-e5f6-4a1b-9c2d-5e6f7a8b9c0d', 'cargos_ler', 0, 'Permissão de LER no módulo CARGOS', 6, 0, NULL, NOW(), NULL, NOW()),
('b2c3d4e5-f6a7-4b2c-9d3e-6f7a8b9c0d1e', 'cargos_criar', 1, 'Permissão de CRIAR no módulo CARGOS', 6, 0, NULL, NOW(), NULL, NOW()),
('c3d4e5f6-a7b8-4c3d-9e4f-7a8b9c0d1e2f', 'cargos_editar', 2, 'Permissão de EDITAR no módulo CARGOS', 6, 0, NULL, NOW(), NULL, NOW()),
('d4e5f6a7-b8c9-4d4e-9f5a-8b9c0d1e2f3a', 'cargos_deletar', 3, 'Permissão de DELETAR no módulo CARGOS', 6, 0, NULL, NOW(), NULL, NOW());

-- ================= PERMISSOES =================
INSERT INTO permissoes VALUES
('e5f6a7b8-c9d0-4e5f-9a6b-9c0d1e2f3a4b', 'permissoes_ler', 0, 'Permissão de LER no módulo PERMISSOES', 7, 0, NULL, NOW(), NULL, NOW()),
('f6a7b8c9-d0e1-4f6a-9b7c-0d1e2f3a4b5c', 'permissoes_criar', 1, 'Permissão de CRIAR no módulo PERMISSOES', 7, 0, NULL, NOW(), NULL, NOW()),
('a7b8c9d0-e1f2-4a7b-9c8d-1e2f3a4b5c6d', 'permissoes_editar', 2, 'Permissão de EDITAR no módulo PERMISSOES', 7, 0, NULL, NOW(), NULL, NOW()),
('b8c9d0e1-f2a3-4b8c-9d9e-2f3a4b5c6d7e', 'permissoes_deletar', 3, 'Permissão de DELETAR no módulo PERMISSOES', 7, 0, NULL, NOW(), NULL, NOW());

-- ================= PERMISSOES_DE_CARGO =================
INSERT INTO permissoes VALUES
('c9d0e1f2-a3b4-4c9d-9e0f-3a4b5c6d7e8f', 'permissoes_cargo_ler', 0, 'Permissão de LER no módulo PERMISSOES_DE_CARGO', 8, 0, NULL, NOW(), NULL, NOW()),
('d0e1f2a3-b4c5-4d0e-9f1a-4b5c6d7e8f9a', 'permissoes_cargo_criar', 1, 'Permissão de CRIAR no módulo PERMISSOES_DE_CARGO', 8, 0, NULL, NOW(), NULL, NOW()),
('e1f2a3b4-c5d6-4e1f-9a2b-5c6d7e8f9a0b', 'permissoes_cargo_editar', 2, 'Permissão de EDITAR no módulo PERMISSOES_DE_CARGO', 8, 0, NULL, NOW(), NULL, NOW()),
('f2a3b4c5-d6e7-4f2a-9b3c-6d7e8f9a0b1c', 'permissoes_cargo_deletar', 3, 'Permissão de DELETAR no módulo PERMISSOES_DE_CARGO', 8, 0, NULL, NOW(), NULL, NOW());

-- ================= PERMISSOES_DE_EXCECAO =================
INSERT INTO permissoes VALUES
('a3b4c5d6-e7f8-4a3b-9c4d-7e8f9a0b1c2d', 'permissoes_excecao_ler', 0, 'Permissão de LER no módulo PERMISSOES_DE_EXCECAO', 9, 0, NULL, NOW(), NULL, NOW()),
('b4c5d6e7-f8a9-4b4c-9d5e-8f9a0b1c2d3e', 'permissoes_excecao_criar', 1, 'Permissão de CRIAR no módulo PERMISSOES_DE_EXCECAO', 9, 0, NULL, NOW(), NULL, NOW()),
('c5d6e7f8-a9b0-4c5d-9e6f-9a0b1c2d3e4f', 'permissoes_excecao_editar', 2, 'Permissão de EDITAR no módulo PERMISSOES_DE_EXCECAO', 9, 0, NULL, NOW(), NULL, NOW()),
('d6e7f8a9-b0c1-4d6e-9f7a-0b1c2d3e4f5a', 'permissoes_excecao_deletar', 3, 'Permissão de DELETAR no módulo PERMISSOES_DE_EXCECAO', 9, 0, NULL, NOW(), NULL, NOW());

-- ================= PERMISSOES_DO_USUARIO =================
INSERT INTO permissoes VALUES
('e7f8a9b0-c1d2-4e7f-9a8b-1c2d3e4f5a6b', 'permissoes_usuario_ler', 0, 'Permissão de LER no módulo PERMISSOES_DO_USUARIO', 18, 0, NULL, NOW(), NULL, NOW());

-- ================= CATEGORIAS_FINANCEIRAS =================
INSERT INTO permissoes VALUES
('f8a9b0c1-d2e3-4f8a-9b0c-2d3e4f5a6b7c', 'categorias_financeiras_ler', 0, 'Permissão de LER no módulo CATEGORIAS_FINANCEIRAS', 10, 0, NULL, NOW(), NULL, NOW()),
('a9b0c1d2-e3f4-4a9b-9c1d-3e4f5a6b7c8d', 'categorias_financeiras_criar', 1, 'Permissão de CRIAR no módulo CATEGORIAS_FINANCEIRAS', 10, 0, NULL, NOW(), NULL, NOW()),
('b0c1d2e3-f4a5-4b0c-9d2e-4f5a6b7c8d9e', 'categorias_financeiras_editar', 2, 'Permissão de EDITAR no módulo CATEGORIAS_FINANCEIRAS', 10, 0, NULL, NOW(), NULL, NOW()),
('c1d2e3f4-a5b6-4c1d-9e3f-5a6b7c8d9e0f', 'categorias_financeiras_deletar', 3, 'Permissão de DELETAR no módulo CATEGORIAS_FINANCEIRAS', 10, 0, NULL, NOW(), NULL, NOW());

-- ================= FINANCEIRO_HORTA =================
INSERT INTO permissoes VALUES
('d2e3f4a5-b6c7-4d2e-9f4a-6b7c8d9e0f1a', 'financeiro_horta_ler', 0, 'Permissão de LER no módulo FINANCEIRO_HORTA', 11, 0, NULL, NOW(), NULL, NOW()),
('e3f4a5b6-c7d8-4e3f-9a5b-7c8d9e0f1a2b', 'financeiro_horta_criar', 1, 'Permissão de CRIAR no módulo FINANCEIRO_HORTA', 11, 0, NULL, NOW(), NULL, NOW()),
('f4a5b6c7-d8e9-4f4a-9b6c-8d9e0f1a2b3c', 'financeiro_horta_editar', 2, 'Permissão de EDITAR no módulo FINANCEIRO_HORTA', 11, 0, NULL, NOW(), NULL, NOW()),
('a5b6c7d8-e9f0-4a5b-9c7d-9e0f1a2b3c4d', 'financeiro_horta_deletar', 3, 'Permissão de DELETAR no módulo FINANCEIRO_HORTA', 11, 0, NULL, NOW(), NULL, NOW());

-- ================= FINANCEIRO_ASSOCIACAO =================
INSERT INTO permissoes VALUES
('b6c7d8e9-f0a1-4b6c-9d8e-0f1a2b3c4d5e', 'financeiro_associacao_ler', 0, 'Permissão de LER no módulo FINANCEIRO_ASSOCIACAO', 12, 0, NULL, NOW(), NULL, NOW()),
('c7d8e9f0-a1b2-4c7d-9e9f-1a2b3c4d5e6f', 'financeiro_associacao_criar', 1, 'Permissão de CRIAR no módulo FINANCEIRO_ASSOCIACAO', 12, 0, NULL, NOW(), NULL, NOW()),
('d8e9f0a1-b2c3-4d8e-9f0a-2b3c4d5e6f7a', 'financeiro_associacao_editar', 2, 'Permissão de EDITAR no módulo FINANCEIRO_ASSOCIACAO', 12, 0, NULL, NOW(), NULL, NOW()),
('e9f0a1b2-c3d4-4e9f-9a1b-3c4d5e6f7a8b', 'financeiro_associacao_deletar', 3, 'Permissão de DELETAR no módulo FINANCEIRO_ASSOCIACAO', 12, 0, NULL, NOW(), NULL, NOW());

-- ================= MENSALIDADES_DA_ASSOCIACAO =================
INSERT INTO permissoes VALUES
('f0a1b2c3-d4e5-4f0a-9b2c-4d5e6f7a8b9c', 'mensalidades_associacao_ler', 0, 'Permissão de LER no módulo MENSALIDADES_DA_ASSOCIACAO', 13, 0, NULL, NOW(), NULL, NOW()),
('a1b2c3d4-e5f6-4a1b-9c3d-5e6f7a8b9c0d', 'mensalidades_associacao_criar', 1, 'Permissão de CRIAR no módulo MENSALIDADES_DA_ASSOCIACAO', 13, 0, NULL, NOW(), NULL, NOW()),
('b2c3d4e5-f6a7-4b2c-9d4e-6f7a8b9c0d1e', 'mensalidades_associacao_editar', 2, 'Permissão de EDITAR no módulo MENSALIDADES_DA_ASSOCIACAO', 13, 0, NULL, NOW(), NULL, NOW()),
('c3d4e5f6-a7b8-4c3d-9e5f-7a8b9c0d1e2f', 'mensalidades_associacao_deletar', 3, 'Permissão de DELETAR no módulo MENSALIDADES_DA_ASSOCIACAO', 13, 0, NULL, NOW(), NULL, NOW());

-- ================= MENSALIDADES_DA_PLATAFORMA =================
INSERT INTO permissoes VALUES
('d4e5f6a7-b8c9-4d4e-9f6a-8b9c0d1e2f3a', 'mensalidades_plataforma_ler', 0, 'Permissão de LER no módulo MENSALIDADES_DA_PLATAFORMA', 14, 0, NULL, NOW(), NULL, NOW()),
('e5f6a7b8-c9d0-4e5f-9a7b-9c0d1e2f3a4b', 'mensalidades_plataforma_criar', 1, 'Permissão de CRIAR no módulo MENSALIDADES_DA_PLATAFORMA', 14, 0, NULL, NOW(), NULL, NOW()),
('f6a7b8c9-d0e1-4f6a-9b8c-0d1e2f3a4b5c', 'mensalidades_plataforma_editar', 2, 'Permissão de EDITAR no módulo MENSALIDADES_DA_PLATAFORMA', 14, 0, NULL, NOW(), NULL, NOW()),
('a7b8c9d0-e1f2-4a7b-9c9d-1e2f3a4b5c6d', 'mensalidades_plataforma_deletar', 3, 'Permissão de DELETAR no módulo MENSALIDADES_DA_PLATAFORMA', 14, 0, NULL, NOW(), NULL, NOW());

-- ================= PLANOS =================
INSERT INTO permissoes VALUES
('b8c9d0e1-f2a3-4b8c-9d0e-2f3a4b5c6d7e', 'planos_ler', 0, 'Permissão de LER no módulo PLANOS', 15, 0, NULL, NOW(), NULL, NOW()),
('c9d0e1f2-a3b4-4c9d-9e1f-3a4b5c6d7e8f', 'planos_criar', 1, 'Permissão de CRIAR no módulo PLANOS', 15, 0, NULL, NOW(), NULL, NOW()),
('d0e1f2a3-b4c5-4d0e-9f2a-4b5c6d7e8f9a', 'planos_editar', 2, 'Permissão de EDITAR no módulo PLANOS', 15, 0, NULL, NOW(), NULL, NOW()),
('e1f2a3b4-c5d6-4e1f-9a3b-5c6d7e8f9a0b', 'planos_deletar', 3, 'Permissão de DELETAR no módulo PLANOS', 15, 0, NULL, NOW(), NULL, NOW());
-- ================= RECURSOS_DO_PLANO =================
INSERT INTO permissoes VALUES
('f2a3b4c5-d6e7-4f2a-9b4c-6d7e8f9a0b1c', 'recursos_plano_ler', 0, 'Permissão de LER no módulo RECURSOS_DO_PLANO', 16, 0, NULL, NOW(), NULL, NOW()),
('a3b4c5d6-e7f8-4a3b-9c5d-7e8f9a0b1c2d', 'recursos_plano_criar', 1, 'Permissão de CRIAR no módulo RECURSOS_DO_PLANO', 16, 0, NULL, NOW(), NULL, NOW()),
('b4c5d6e7-f8a9-4b4c-9d6e-8f9a0b1c2d3e', 'recursos_plano_editar', 2, 'Permissão de EDITAR no módulo RECURSOS_DO_PLANO', 16, 0, NULL, NOW(), NULL, NOW()),
('c5d6e7f8-a9b0-4c5d-9e7f-9a0b1c2d3e4f', 'recursos_plano_deletar', 3, 'Permissão de DELETAR no módulo RECURSOS_DO_PLANO', 16, 0, NULL, NOW(), NULL, NOW());

-- ================= CHAVES =================
INSERT INTO permissoes VALUES
('d6e7f8a9-b0c1-4d6e-9f8a-0b1c2d3e4f5a', 'chaves_ler', 0, 'Permissão de LER no módulo CHAVES', 17, 0, NULL, NOW(), NULL, NOW()),
('e7f8a9b0-c1d2-4e7f-9a9b-1c2d3e4f5a6b', 'chaves_criar', 1, 'Permissão de CRIAR no módulo CHAVES', 17, 0, NULL, NOW(), NULL, NOW()),
('f8a9b0c1-d2e3-4f8a-9b0c-2d3e4f5a6b7c', 'chaves_editar', 2, 'Permissão de EDITAR no módulo CHAVES', 17, 0, NULL, NOW(), NULL, NOW()),
('a9b0c1d2-e3f4-4a9b-9c1d-3e4f5a6b7c8d', 'chaves_deletar', 3, 'Permissão de DELETAR no módulo CHAVES', 17, 0, NULL, NOW(), NULL, NOW());

-- ================= FILA_DE_USUARIO =================
INSERT INTO permissoes VALUES
('b0c1d2e3-f4a5-4b0c-9d2e-4f5a6b7c8d9e', 'fila_usuarios_ler', 0, 'Permissão de LER no módulo FILA_DE_USUARIO', 18, 0, NULL, NOW(), NULL, NOW()),
('c1d2e3f4-a5b6-4c1d-9e3f-5a6b7c8d9e0f', 'fila_usuarios_criar', 1, 'Permissão de CRIAR no módulo FILA_DE_USUARIO', 18, 0, NULL, NOW(), NULL, NOW()),
('d2e3f4a5-b6c7-4d2e-9f4a-6b7c8d9e0f1a', 'fila_usuarios_editar', 2, 'Permissão de EDITAR no módulo FILA_DE_USUARIO', 18, 0, NULL, NOW(), NULL, NOW()),
('e3f4a5b6-c7d8-4e3f-9a5b-7c8d9e0f1a2b', 'fila_usuarios_deletar', 3, 'Permissão de DELETAR no módulo FILA_DE_USUARIO', 18, 0, NULL, NOW(), NULL, NOW());
