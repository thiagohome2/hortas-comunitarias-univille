-- Tabela: Usuários | Cria validação de email único só para usuários ativos

-- cria coluna gerada virtual
ALTER TABLE usuarios 
ADD email_ativo VARCHAR(255) AS (CASE WHEN excluido = 0 THEN email ELSE NULL END) VIRTUAL;

-- cria índice único sobre a coluna gerada
CREATE UNIQUE INDEX usuarios_email_unique_active 
ON usuarios(email_ativo);
