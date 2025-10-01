-- ================= Usuário Dummy serve para testar condições na camada de aplicação, terá todas as permissões mas não o cargo =================
-- Precisa atribuir a algum usuário o cargo dummy
-- Adicionar cargo dummy
INSERT INTO cargos (uuid, codigo, slug, nome, descricao, cor, excluido, usuario_criador_uuid, usuario_alterador_uuid)
VALUES (UUID(), 99, 'dummy', 'Dummy Admin', 'Cargo de teste com permissões de admin mas não é admin.', '#00FFFF', 0, NULL, NULL);

-- Permissões para o cargo dummy (já está no seu arquivo, linha após o admin_plataforma)
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
WHERE c.slug = 'dummy'
AND p.slug NOT IN ('sessoes_login', 'sessoes_cadastro');

-- ================= ENDEREÇOS =================
INSERT INTO enderecos (uuid, tipo_logradouro, logradouro, numero, bairro, cidade, estado, cep, excluido)
VALUES 
(UUID(), 'Rua', 'das Palmeiras', '100', 'Centro', 'São Paulo', 'SP', '01001-000', 0),
(UUID(), 'Avenida', 'Brasil', '2000', 'Jardins', 'Rio de Janeiro', 'RJ', '20000-000', 0),
(UUID(), 'Travessa', 'Floriano', '55', 'Boa Vista', 'Curitiba', 'PR', '80000-000', 0);

-- ================= ASSOCIAÇÕES =================
INSERT INTO associacoes (uuid, cnpj, razao_social, nome_fantasia, endereco_uuid,url_estatuto_social_pdf,url_ata_associacao_pdf, status_aprovacao, excluido)
SELECT UUID(), '11.111.111/0001-21', 'Associação Hortas Urbanas 1', 'Hortas SP', e.uuid,"https://www.google.com", "https://www.google.com", 1, 0
FROM enderecos e LIMIT 1;

INSERT INTO associacoes (uuid, cnpj, razao_social, nome_fantasia, endereco_uuid, url_estatuto_social_pdf,url_ata_associacao_pdf, status_aprovacao, excluido)
SELECT UUID(), '22.222.222/0001-23', 'Associação Hortas Urbanas 2', 'Hortas RJ', e.uuid, "https://www.google.com", "https://www.google.com", 1, 0
FROM enderecos e ORDER BY data_de_criacao DESC LIMIT 1;

-- ================= HORTAS =================
INSERT INTO hortas (uuid, nome_da_horta, endereco_uuid, associacao_vinculada_uuid, percentual_taxa_associado, excluido)
SELECT UUID(), 'Horta Comunitária SP', e.uuid, a.uuid, 10.00, 0
FROM enderecos e
JOIN associacoes a ON a.razao_social = 'Associação Hortas Urbanas 1'
LIMIT 1;

INSERT INTO hortas (uuid, nome_da_horta, endereco_uuid, associacao_vinculada_uuid, percentual_taxa_associado, excluido)
SELECT UUID(), 'Horta Comunitária RJ', e.uuid, a.uuid, 12.50, 0
FROM enderecos e
JOIN associacoes a ON a.razao_social = 'Associação Hortas Urbanas 2'
LIMIT 1;

-- ================= USUÁRIOS =================
-- 2 usuários de cada cargo a partir de admin_associacao_geral
-- Cada usuário vinculado a uma associação e horta

-- Admin Associação Geral (2 usuários, 1 em cada associação/horta)
INSERT INTO usuarios (uuid, nome_completo, cpf, email, senha, cargo_uuid, endereco_uuid, associacao_uuid, horta_uuid, status_de_acesso, excluido)
SELECT UUID(), 'Carlos Admin SP', '111.111.111-23', 'admin_assoc_1@example.com', '$2y$10$TUHWKOcJj85/pMDxEg7eTu3zGDlE2sfOdVn4dfSN5JzMIqssNISYG',
       c.uuid, e.uuid, a.uuid, h.uuid, 'ativo', 0
FROM cargos c
JOIN enderecos e ON e.cidade = 'São Paulo'
JOIN associacoes a ON a.nome_fantasia = 'Hortas SP'
JOIN hortas h ON h.nome_da_horta = 'Horta Comunitária SP'
WHERE c.slug = 'admin_associacao_geral'
LIMIT 1;

INSERT INTO usuarios (uuid, nome_completo, cpf, email, senha, cargo_uuid, endereco_uuid, associacao_uuid, horta_uuid, status_de_acesso, excluido)
SELECT UUID(), 'Mariana Admin RJ', '222.222.222-23', 'admin_assoc_2@example.com', '$2y$10$TUHWKOcJj85/pMDxEg7eTu3zGDlE2sfOdVn4dfSN5JzMIqssNISYG',
       c.uuid, e.uuid, a.uuid, h.uuid, 'ativo', 0
FROM cargos c
JOIN enderecos e ON e.cidade = 'Rio de Janeiro'
JOIN associacoes a ON a.nome_fantasia = 'Hortas RJ'
JOIN hortas h ON h.nome_da_horta = 'Horta Comunitária RJ'
WHERE c.slug = 'admin_associacao_geral'
LIMIT 1;

-- Admin Horta Geral (2 usuários)
INSERT INTO usuarios (uuid, nome_completo, cpf, email, senha, cargo_uuid, endereco_uuid, associacao_uuid, horta_uuid, status_de_acesso, excluido)
SELECT UUID(), 'João Horta SP', '333.333.333-53', 'admin_horta_1@example.com', '$2y$10$TUHWKOcJj85/pMDxEg7eTu3zGDlE2sfOdVn4dfSN5JzMIqssNISYG',
       c.uuid, e.uuid, a.uuid, h.uuid, 'ativo', 0
FROM cargos c
JOIN enderecos e ON e.cidade = 'São Paulo'
JOIN associacoes a ON a.nome_fantasia = 'Hortas SP'
JOIN hortas h ON h.nome_da_horta = 'Horta Comunitária SP'
WHERE c.slug = 'admin_horta_geral'
LIMIT 1;

INSERT INTO usuarios (uuid, nome_completo, cpf, email, senha, cargo_uuid, endereco_uuid, associacao_uuid, horta_uuid, status_de_acesso, excluido)
SELECT UUID(), 'Ana Horta RJ', '444.444.444-94', 'admin_horta_2@example.com', '$2y$10$TUHWKOcJj85/pMDxEg7eTu3zGDlE2sfOdVn4dfSN5JzMIqssNISYG',
       c.uuid, e.uuid, a.uuid, h.uuid, 'ativo', 0
FROM cargos c
JOIN enderecos e ON e.cidade = 'Rio de Janeiro'
JOIN associacoes a ON a.nome_fantasia = 'Hortas RJ'
JOIN hortas h ON h.nome_da_horta = 'Horta Comunitária RJ'
WHERE c.slug = 'admin_horta_geral'
LIMIT 1;

-- Canteirista (2 usuários)
INSERT INTO usuarios (uuid, nome_completo, cpf, email, senha, cargo_uuid, endereco_uuid, associacao_uuid, horta_uuid, status_de_acesso, excluido)
SELECT UUID(), 'Pedro Canteiro SP', '555.555.555-15', 'canteirista_1@example.com', '$2y$10$TUHWKOcJj85/pMDxEg7eTu3zGDlE2sfOdVn4dfSN5JzMIqssNISYG',
       c.uuid, e.uuid, a.uuid, h.uuid, 'ativo', 0
FROM cargos c
JOIN enderecos e ON e.cidade = 'São Paulo'
JOIN associacoes a ON a.nome_fantasia = 'Hortas SP'
JOIN hortas h ON h.nome_da_horta = 'Horta Comunitária SP'
WHERE c.slug = 'canteirista'
LIMIT 1;

INSERT INTO usuarios (uuid, nome_completo, cpf, email, senha, cargo_uuid, endereco_uuid, associacao_uuid, horta_uuid, status_de_acesso, excluido)
SELECT UUID(), 'Julia Canteiro RJ', '666.666.666-66', 'canteirista_2@example.com', '$2y$10$TUHWKOcJj85/pMDxEg7eTu3zGDlE2sfOdVn4dfSN5JzMIqssNISYG',
       c.uuid, e.uuid, a.uuid, h.uuid, 'ativo', 0
FROM cargos c
JOIN enderecos e ON e.cidade = 'Rio de Janeiro'
JOIN associacoes a ON a.nome_fantasia = 'Hortas RJ'
JOIN hortas h ON h.nome_da_horta = 'Horta Comunitária RJ'
WHERE c.slug = 'canteirista'
LIMIT 1;

-- Dependente (2 usuários)
INSERT INTO usuarios (uuid, nome_completo, cpf, email, senha, cargo_uuid, endereco_uuid, associacao_uuid, horta_uuid, status_de_acesso, excluido)
SELECT UUID(), 'Lucas Dependente SP', '717.777.777-17', 'dependente_1@example.com', '$2y$10$TUHWKOcJj85/pMDxEg7eTu3zGDlE2sfOdVn4dfSN5JzMIqssNISYG',
       c.uuid, e.uuid, a.uuid, h.uuid, 'ativo', 0
FROM cargos c
JOIN enderecos e ON e.cidade = 'São Paulo'
JOIN associacoes a ON a.nome_fantasia = 'Hortas SP'
JOIN hortas h ON h.nome_da_horta = 'Horta Comunitária SP'
WHERE c.slug = 'dependente'
LIMIT 1;

INSERT INTO usuarios (uuid, nome_completo, cpf, email, senha, cargo_uuid, endereco_uuid, associacao_uuid, horta_uuid, status_de_acesso, excluido)
SELECT UUID(), 'Fernanda Dependente RJ', '888.818.888-88', 'dependente_2@example.com', '$2y$10$TUHWKOcJj85/pMDxEg7eTu3zGDlE2sfOdVn4dfSN5JzMIqssNISYG',
       c.uuid, e.uuid, a.uuid, h.uuid, 'ativo', 0
FROM cargos c
JOIN enderecos e ON e.cidade = 'Rio de Janeiro'
JOIN associacoes a ON a.nome_fantasia = 'Hortas RJ'
JOIN hortas h ON h.nome_da_horta = 'Horta Comunitária RJ'
WHERE c.slug = 'dependente'
LIMIT 1;

INSERT INTO usuarios (uuid, nome_completo, cpf, email, senha, cargo_uuid, endereco_uuid, associacao_uuid, horta_uuid, status_de_acesso, excluido)
SELECT UUID(), 'Dummest Dummy', '888.818.888-88', 'dummy@example.com', '$2y$10$TUHWKOcJj85/pMDxEg7eTu3zGDlE2sfOdVn4dfSN5JzMIqssNISYG',
       c.uuid, e.uuid, a.uuid, h.uuid, 'ativo', 0
FROM cargos c
JOIN enderecos e ON e.cidade = 'Rio de Janeiro'
JOIN associacoes a ON a.nome_fantasia = 'Hortas RJ'
JOIN hortas h ON h.nome_da_horta = 'Horta Comunitária RJ'
WHERE c.slug = 'dummy'
LIMIT 1;
