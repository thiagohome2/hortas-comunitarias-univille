# 🎲 Documentação do Banco de Dados v1 | 11-09-2025

**Criado e mantido pelos senhores:** Felipe Mourão, João Alencar, Lucas Reinaldo, Marcelo Fiedler e Marcos Will
_7º Semestre de Engenharia de Software e Sistemas de Informação da UNIVILLE_


# 📗Introdução

A maneira como projetamos o esquema do banco foi pensado num banco MySQL, sem manter tabelas para auth (utilizar JWT para isso, com salt sendo o JWT secret, onde o payload conterá cargo.codigo e usuario.uuid para obter informações e autorizar recursos).

Deixamos os nomes das variáveis e colunas em português 🇧🇷 mas podemos traduzir para inglês 🇺🇸 caso seja necessário. Fizemos assim para agilizar a definição de banco de dados e regras de negócios.

Todas as entidades (tabelas) terão os campos úteis para suporte e validação de ações dos usuários, para manter logs:

- Data de criação → Quando foi criado o registro na tabela
- Usuário de criação → Quem criou o registro na tabela
- Data de alteração → Quando foi alterado o registro na tabela
- Usuário de alteração → alteração alterou o registro na tabela

Optamos por utilizar **exclusão lógica** no banco de dados, ou seja, as entidades excluídas terão o campo “excluido” definido como “1” ou `true`, dessa forma mantemos o registro dela e seus campos úteis mencionados acima para poder validar em casos de exclusão indevida ou acesso invadido.

Campos de arquivos foram definidos como URL, ou “link”, dessa forma a camada de aplicação pode tratar os arquivos, guardar em um armazenamento como S3 da AWS, ou o próprio usuário pode salvar num armazenamento como Google Drive e salvar a URL no campo. Dessa forma economizamos com salvamento de blobs e ferramentas externas.

O prefixo “bd” na menção dos nomes das tabelas é genérico, o nome do banco de dados precisará ser definido, geralmente usamos o nome da aplicação e ambiente (ex: “comunortas-sandbox”).

Usamos os nomes de tabela no plural mas pode ser alterado (como todo o resto).

A seção de Tabelas Principais aborda as principais entidades.

A seção de Tabelas Sugeridas aborda as tabelas de Lançamento financeiro (entradas e saídas) usada para calculo de caixa, e Mensalidades usada para gestão de pagamento dos associados.

# 📗Tabelas core da plataforma

Tabelas necessárias para manter uma base de staff (admins da plataforma em si), base de usuários, e gerenciar acesso aos recursos do “módulo” financeiro. Futuramente, com outros tipos de recursos como recursos de inventário ou estoque das produções das hortas, ou estoque de equipamentos e infraestrutura, essas tabelas podem servir de base para "beber" desses dados no gerenciamento de funcionalidades.

## 1. USUÁRIOS | `bd.usuarios`

| Nome do Campo | Nome Coluna | Tipo | Observação |
| --- | --- | --- | --- |
| UUID | uuid | CHAR(36) | Chave primária |
| Nome Completo | nome_completo | VARCHAR(255) NOT NULL | Nome completo do usuário |
| CPF | cpf | VARCHAR(14) UNIQUE NOT NULL | CPF do usuário |
| Email | email | VARCHAR(255) UNIQUE NOT NULL | Email do usuário |
| Data de Nascimento | data_de_nascimento | DATE | Data de nascimento |
| Cargo UUID | cargo_uuid | CHAR(36) NOT NULL | UUID do cargo |
| Taxa de Associado | taxa_associado_em_centavos | BIGINT DEFAULT 0 | Valor pago como associado em centavos (R$ 1,00 = 100) |
| Endereço | endereco_uuid | CHAR(36) | UUID do endereço |
| Associação UUID | associacao_uuid | CHAR(36) | UUID da associação |
| Horta UUID | horta_uuid | CHAR(36) | UUID da horta |
| Usuário Associado | usuario_associado_uuid | CHAR(36) | Para dependentes - UUID do usuário principal |
| Status de Acesso | status_de_acesso | TINYINT DEFAULT 1 | 0 = Bloqueado, 1 = Ativo, 2 = Suspenso, 3 = Pendente aprovação. Validado mediante pagamento aprovado na tabela Mensalidades. |
| Data Bloqueio Acesso | data_bloqueio_acesso | TIMESTAMP | Data em que o acesso foi bloqueado |
| Motivo Bloqueio Acesso | motivo_bloqueio_acesso | TEXT | Motivo do bloqueio de acesso |
| Excluído | excluido | BOOLEAN DEFAULT FALSE | Exclusão lógica |
| Usuário Criador | usuario_criador_uuid | CHAR(36) | UUID do usuário que criou |
| Data de Criação | data_de_criacao | TIMESTAMP DEFAULT NOW() | Data/hora da criação |
| Usuário Alterador | usuario_alterador_uuid | CHAR(36) | UUID do último usuário que alterou |
| Data da Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração |

Consideramos que usuários só poderão ter um cargo por vez. Exceções tratadas na tabela respectiva.

### Relacionamentos de USUÁRIOS:

- **cargo_uuid** → cargos.uuid (N:1)
- **endereco_uuid** → enderecos.uuid (N:1)
- **associacao_uuid** → associacoes.uuid (N:1)
- **horta_uuid** → hortas.uuid (N:1)
- **usuario_associado_uuid** → usuarios.uuid (N:1) - Self reference para dependentes
- **usuario_criador_uuid** → usuarios.uuid (N:1)
- **usuario_alterador_uuid** → usuarios.uuid (N:1)

---

## 2. ASSOCIAÇÕES | `bd.associacoes`

| Nome do Campo | Nome Coluna | Tipo | Observação |
| --- | --- | --- | --- |
| UUID | uuid | CHAR(36) | Chave primária |
| CNPJ | cnpj | VARCHAR(18) UNIQUE NOT NULL | CNPJ da associação |
| Razão Social | razao_social | VARCHAR(255) NOT NULL | Nome oficial da empresa |
| Nome Fantasia | nome_fantasia | VARCHAR(255) | Nome comercial |
| Endereço | endereco_uuid | CHAR(36) | UUID do endereço |
| URL Estatuto Social PDF | url_estatuto_social_pdf | TEXT | Link para o PDF do estatuto |
| URL Ata da Associação PDF | url_ata_associacao_pdf | TEXT | Link para o PDF da ata |
| Status de Aprovação | status_aprovacao | TINYINT DEFAULT 0 | 0 = pendente, 1 = aprovado, 2 = rejeitado |
| Excluído | excluido | BOOLEAN DEFAULT FALSE | Exclusão lógica |
| Usuário Responsável | usuario_responsavel_uuid | CHAR(36) | UUID do usuário responsavel pela associação, que criou seu cadastro |
| Usuário Criador | usuario_criador_uuid | CHAR(36) | UUID do usuário que criou |
| Data de Criação | data_de_criacao | TIMESTAMP DEFAULT NOW() | Data/hora da criação |
| Usuário Alterador | usuario_alterador_uuid | CHAR(36) | UUID do último usuário que alterou |
| Data da Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração |

### Relacionamentos de ASSOCIAÇÕES:

- **endereco_uuid** → enderecos.uuid (N:1)
- **usuario_responsavel_uuid** → usuarios.uuid (N:1)
- **usuario_criador_uuid** → usuarios.uuid (N:1)
- **usuario_alterador_uuid** → usuarios.uuid (N:1)

---

## 3. HORTAS | `bd.hortas`

| Nome do Campo | Nome Coluna | Tipo | Observação |
| --- | --- | --- | --- |
| UUID | uuid | CHAR(36) | Chave primária |
| Nome da Horta | nome_da_horta | VARCHAR(255) NOT NULL | Nome identificador da horta |
| Endereço | endereco_uuid | CHAR(36) NOT NULL | UUID do endereço |
| Associação Vinculada | associacao_vinculada_uuid | CHAR(36) NOT NULL | UUID da associação responsável |
| Percentual Taxa Associado | percentual_taxa_associado | DECIMAL(5,2) NOT NULL | % que fica para o caixa da horta |
| Excluído | excluido | BOOLEAN DEFAULT FALSE | Exclusão lógica |
| Usuário Criador | usuario_criador_uuid | CHAR(36) | UUID do usuário que criou |
| Data de Criação | data_de_criacao | TIMESTAMP DEFAULT NOW() | Data/hora da criação |
| Usuário Alterador | usuario_alterador_uuid | CHAR(36) | UUID do último usuário que alterou |
| Data da Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração |

### Relacionamentos de HORTAS:

- **endereco_uuid** → enderecos.uuid (N:1)
- **associacao_vinculada_uuid** → associacoes.uuid (N:1)
- **usuario_criador_uuid** → usuarios.uuid (N:1)
- **usuario_alterador_uuid** → usuarios.uuid (N:1)

---

## 4. ENDEREÇOS | `bd.enderecos`

| Nome do Campo | Nome Coluna | Tipo | Observação |
| --- | --- | --- | --- |
| UUID | uuid | CHAR(36) | Chave primária |
| Tipo de Logradouro | tipo_logradouro | VARCHAR(50) | Ex: Rua, Avenida, Travessa |
| Logradouro | logradouro | VARCHAR(255) | Nome da rua/avenida |
| Número | numero | VARCHAR(20) | Número do endereço |
| Complemento | complemento | VARCHAR(100) | Apartamento, bloco, etc. |
| Bairro | bairro | VARCHAR(100) | Nome do bairro |
| Cidade | cidade | VARCHAR(100) | Nome da cidade |
| Estado | estado | VARCHAR(2) | Sigla do estado (UF) |
| CEP | cep | VARCHAR(9) | CEP formatado |
| Latitude | latitude | DECIMAL(10,8) | Coordenada geográfica |
| Longitude | longitude | DECIMAL(11,8) | Coordenada geográfica |
| Excluído | excluido | BOOLEAN DEFAULT FALSE | Exclusão lógica |
| Usuário Criador | usuario_criador_uuid | CHAR(36) | UUID do usuário que criou |
| Data de Criação | data_de_criacao | TIMESTAMP DEFAULT NOW() | Data/hora da criação |
| Usuário Alterador | usuario_alterador_uuid | CHAR(36) | UUID do último usuário que alterou |
| Data da Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração |

### Relacionamentos de ENDEREÇOS:

- **usuario_criador_uuid** → usuarios.uuid (N:1)
- **usuario_alterador_uuid** → usuarios.uuid (N:1)

---

## 5. CANTEIROS | `bd.canteiros`

| Nome do Campo | Nome Coluna | Tipo | Observação |
| --- | --- | --- | --- |
| UUID | uuid | CHAR(36) | Chave primária |
| Número Identificador | numero_identificador | VARCHAR(20) NOT NULL | Único dentro da horta |
| Tamanho m² | tamanho_m2 | DECIMAL(8,2) NOT NULL | Tamanho em metros quadrados |
| Horta | horta_uuid | CHAR(36) NOT NULL | UUID da horta |
| Excluído | excluido | BOOLEAN DEFAULT FALSE | Exclusão lógica |
| Usuário Criador | usuario_criador_uuid | CHAR(36) | UUID do usuário que criou |
| Data de Criação | data_de_criacao | TIMESTAMP DEFAULT NOW() | Data/hora da criação |
| Usuário Alterador | usuario_alterador_uuid | CHAR(36) | UUID do último usuário que alterou |
| Data da Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração |

### Sobre a multiplicidade

A tabela de canteiros foi modificada para suportar múltiplos proprietários por canteiro através da tabela de vínculo `canteiros_usuarios` descrita abaixo.

### Relacionamentos de CANTEIROS:

- **horta_uuid** → hortas.uuid (N:1)
- **usuario_criador_uuid** → usuarios.uuid (N:1)
- **usuario_alterador_uuid** → usuarios.uuid (N:1)

---

## 6. CANTEIROS E USUÁRIOS | `bd.canteiros_e_usuarios`

Tabela de vínculo N:N entre canteiros e usuários, permitindo copropriedade de canteiros caso ela seja necessária.

| Nome do Campo | Nome Coluna | Tipo | Observação |
| --- | --- | --- | --- |
| UUID | uuid | CHAR(36) | Chave primária |
| Canteiro UUID | canteiro_uuid | CHAR(36) NOT NULL | UUID do canteiro |
| Usuário UUID | usuario_uuid | CHAR(36) NOT NULL | UUID do usuário |
| Tipo de Vínculo | tipo_vinculo | TINYINT DEFAULT 1 | 1 = Proprietário principal, 2 = Coproprietário, 3 = Responsável temporário |
| Data Início | data_inicio | DATE NOT NULL | Data de início do vínculo |
| Data Fim | data_fim | DATE | Data de fim do vínculo (NULL = ativo) |
| Percentual Responsabilidade | percentual_responsabilidade | DECIMAL(5,2) DEFAULT 100.00 | % de responsabilidade sobre o canteiro |
| Observações | observacoes | TEXT | Observações sobre o vínculo |
| Ativo | ativo | BOOLEAN DEFAULT TRUE | Status do vínculo |
| Excluído | excluido | BOOLEAN DEFAULT FALSE | Exclusão lógica |
| Usuário Criador | usuario_criador_uuid | CHAR(36) | UUID do usuário que criou |
| Data de Criação | data_de_criacao | TIMESTAMP DEFAULT NOW() | Data/hora da criação |
| Usuário Alterador | usuario_alterador_uuid | CHAR(36) | UUID do último usuário que alterou |
| Data da Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração |

### Relacionamentos de CANTEIROS USUÁRIOS:

- **canteiro_uuid** → canteiros.uuid (N:1)
- **usuario_uuid** → usuarios.uuid (N:1)
- **usuario_criador_uuid** → usuarios.uuid (N:1)
- **usuario_alterador_uuid** → usuarios.uuid (N:1)

---

# 📗Tabelas para controle de acesso a recursos | RBAC híbrido

O modo que o controle de acesso as funcionalidades e recursos da aplicação será feito vai ser via RBAC híbrido (mistura de RBAC com feature flag).

No Role Based Access Control - RBAC padrão, os cargos tem um conjunto de permissões atrelados.

Porém, para organizações com multiplos cenários, fica complicado desenhar as permissões desses cargos para atender a todos os possíveis casos de uso.

Então com o uso de feature flag somada, podemos criar cenários onde o usuário tem todas as permissões de seu cargo base e também permissões extras, ou então tem todas as permissões do cargo exceto algumas.

Essa foi a maneira mais otimizada considerando os trade-offs em outros tipos de controle.

O foco aqui é modularização, para permitir o sistema crescer de forma orgânica sem criar dependências sobre dependências.

A tabela `Cargos` vai armazenar os cargos base (roles).

Os cargos já vão ter uma rotina de insert para as permissões padrões dele. Essa entidade em teoria não terá muitos inserts novos. Mas pode ser possível criar cargos com um set de permissões.

A tabela `Permissões`vai armazenar as permissões de recursos do sistema (resources)

Quando uma permissão for adicionada, um novo recurso for adicionado, automaticamente já deve ser escolhido quais cargos tem acesso ao que nessa permissão, para evitar um cenário onde uma permissão não tem ninguém com acesso. Essa definição vai salvar na tabela à seguir.

A tabela `Permissões de Cargo` vai armazenar as permissões base para os cargos (role_permissions)

A tabela `Permissões de Exceção` vai armazenar as permissões extras para os usuários (user_permission_exception)


Supondo que o usuário ID 99999 logou e queremos as permissões. O tratamento feito será:
→ Selecionar todas as permissões para o cargo_uuid dele
→ Selecionar todas as exceções para o user_uuid dele
→ Concatenar ambas, isso vai gerar um "set" de permissões

Essas permissões podem ser acessadas em um endpoint user/permissions/ com UUID do user fornecido no header da requisição via JWT
Essas permissões podem ser cacheadas, e refresh'adas a cada X minutos ou Y eventos

Dessa forma, evitamos uma tabela por exemplo de permissões do usuário com dezenas ou centenas de linhas para um único usuário( linhas multiplas com  "user.create = true", "user.update = true", etc). 

Teremos as permissões dos cargos, e alguns "ajustes" para o use case de cada Associação ou Horta.

## 1. CARGOS | `bd.cargos`

Armazena os cargo possíveis no sistema. Atualmente temos 5 cargos base.

| Nome do Campo | Nome Coluna | Tipo | Observação |
| --- | --- | --- | --- |
| UUID | uuid | CHAR(36) | Chave primária |
| Código | codigo | INT UNIQUE NOT NULL | 0-5 conforme especificação |
| Slug | slug | VARCHAR(100) UNIQUE NOT NULL | Identificador amigável |
| Nome | nome | VARCHAR(100) NOT NULL | Nome do cargo |
| Descrição | descricao | TEXT | Descrição do cargo |
| Cor | cor | VARCHAR(7) | Código hexadecimal da cor |
| Excluído | excluido | BOOLEAN DEFAULT FALSE | Exclusão lógica |
| Usuário Criador | usuario_criador_uuid | CHAR(36) | UUID do usuário que criou |
| Data de Criação | data_de_criacao | TIMESTAMP DEFAULT NOW() | Data/hora da criação |
| Usuário Alterador | usuario_alterador_uuid | CHAR(36) | UUID do último usuário que alterou |
| Data da Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração |

### Relacionamentos de CARGOS:

- **usuario_criador_uuid** → usuarios.uuid (N:1)
- **usuario_alterador_uuid** → usuarios.uuid (N:1)

### Definição de cargos:

Utilizando um número como código podemos deixar a camada de aplicação 100% pronta sem depender do tratamento de UUIDs. Por exemplo:

```php
if ($usuario['cargo']['codigo'] === 1) {
    echo "Usuário é Administração da Associação Geral";
}

```

| Nome do Cargo | Slug | Código (número para lógica) |
| --- | --- | --- |
| Administração da Plataforma | admin_plataforma | 0 |
| Administração da Associação | admin_associacao_geral | 1 |
| Administração da Horta | admin_horta_geral | 2 |
| Canteirista | canteirista | 3 |
| Dependente | dependente | 4 |

## 2. PERMISSÕES | `bd.permissoes`

| Nome do Campo | Nome Coluna | Tipo | Observação |
| --- | --- | --- | --- |
| UUID | uuid | CHAR(36) | Chave primária |
| Slug da Permissão | slug | VARCHAR(100) UNIQUE NOT NULL | Identificador amigável |
| Nome | nome | VARCHAR(100) NOT NULL | Nome da permissão |
| Descrição | descricao | TEXT | Descrição da permissão |
| Módulo | modulo | VARCHAR(50) | Módulo do sistema (usuários, financeiro, hortas, etc.) |
| Excluído | excluido | BOOLEAN DEFAULT FALSE | Exclusão lógica |
| Usuário Criador | usuario_criador_uuid | CHAR(36) | UUID do usuário que criou |
| Data de Criação | data_de_criacao | TIMESTAMP DEFAULT NOW() | Data/hora da criação |
| Usuário Alterador | usuario_alterador_uuid | CHAR(36) | UUID do último usuário que alterou |
| Data da Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração |

---

## 3. PERMISSÕES DE CARGO | `bd.permissoes_de_cargo`

Tabela que armazena o que cada cargo pode fazer, por padrão, na plataforma. Cada linha com a permissão UUID e seu status para o cargo.

| Nome do Campo | Nome Coluna | Tipo | Observação |
| --- | --- | --- | --- |
| UUID | uuid | CHAR(36) | Chave primária |
| Cargo UUID | cargo_uuid | CHAR(36) | UUID do cargo |
| Permissão UUID | permissao_uuid | CHAR(36) | UUID da permissão |
| Liberado | liberado | BOOLEAN DEFAULT FALSE | Lógica de liberação da permissão para o cargo |
| Excluído | excluido | BOOLEAN DEFAULT FALSE | Exclusão lógica |
| Usuário Criador | usuario_criador_uuid | CHAR(36) | UUID do usuário que criou |
| Data de Criação | data_de_criacao | TIMESTAMP DEFAULT NOW() | Data/hora da criação |
| Usuário Alterador | usuario_alterador_uuid | CHAR(36) | UUID do último usuário que alterou |
| Data da Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração |

### Relacionamentos de PERMISSÕES DE CARGOS:

- **cargo_uuid** → cargos.uuid
- **permissao_uuid** → permissoes.uuid
- **usuario_criador_uuid** → usuarios.uuid (N:1)
- **usuario_alterador_uuid** → usuarios.uuid (N:1)

## 4. PERMISSÕES DE EXCEÇÃO | `bd.permissoes_de_excecao`

| Nome do Campo | Nome Coluna | Tipo | Observação |
| --- | --- | --- | --- |
| UUID | uuid | CHAR(36) | Chave primária |
| Usuário UUID | usuario_uuid | CHAR(36) | UUID do usuário |
| Permissão UUID | permissao_uuid | CHAR(36) | UUID da permissão |
| Liberado | liberado | BOOLEAN DEFAULT FALSE | Lógica de liberação da permissão para o usuário nesta exceção |
| Excluído | excluido | BOOLEAN DEFAULT FALSE | Exclusão lógica |
| Usuário Criador | usuario_criador_uuid | CHAR(36) | UUID do usuário que criou |
| Data de Criação | data_de_criacao | TIMESTAMP DEFAULT NOW() | Data/hora da criação |
| Usuário Alterador | usuario_alterador_uuid | CHAR(36) | UUID do último usuário que alterou |
| Data da Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração |

### Relacionamentos de PERMISSÕES DE EXCEÇÃO:

- **usuario_uuid** → usuarios.uuid (N:1)
- **permissao_uuid** → permissoes.uuid (N:1)
- **usuario_criador_uuid** → usuarios.uuid (N:1)
- **usuario_alterador_uuid** → usuarios.uuid (N:1)

# 📗Tabelas para gestão financeira

## 1. CATEGORIAS FINANCEIRAS | `bd.categorias_financeiras`

Tabela para categorizar lançamentos financeiros, facilitando relatórios e controle.

| Nome do Campo | Nome Coluna | Tipo | Observação |
| --- | --- | --- | --- |
| UUID | uuid | CHAR(36) | Chave primária |
| Nome | nome | VARCHAR(100) NOT NULL | Nome da categoria |
| Descrição | descricao | TEXT | Descrição da categoria |
| Tipo | tipo | TINYINT NOT NULL | 1 = Entrada, 2 = Saída, 3 = Ambos |
| Cor | cor | VARCHAR(7) | Código hexadecimal da cor para interface |
| Ícone | icone | VARCHAR(50) | Nome do ícone para interface |
| Associação UUID | associacao_uuid | CHAR(36) | UUID da associação (NULL = categoria global) |
| Excluído | excluido | BOOLEAN DEFAULT FALSE | Exclusão lógica |
| Usuário Criador | usuario_criador_uuid | CHAR(36) | UUID do usuário que criou |
| Data de Criação | data_de_criacao | TIMESTAMP DEFAULT NOW() | Data/hora da criação |
| Usuário Alterador | usuario_alterador_uuid | CHAR(36) | UUID do último usuário que alterou |
| Data da Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração |

### Relacionamentos de CATEGORIAS FINANCEIRAS:

- **associacao_uuid** → associacoes.uuid (N:1) - Opcional
- **usuario_criador_uuid** → usuarios.uuid (N:1)
- **usuario_alterador_uuid** → usuarios.uuid (N:1)

### Categorias padrão sugeridas:

- Mensalidade
- Doação
- Manutenção
- Insumos
- Equipamentos
- Infraestrutura
- Taxa administrativa
- Outros

---

## 2. FINANCEIRO HORTA | `bd.financeiro_horta`

Tabela feita para manter um registro de caixa da Horta. Não comporta gestão de pagamento dos canteiristas, será gerido pelas próximas duas tabelas.

| Nome do Campo | Nome Coluna | Tipo | Observação |
| --- | --- | --- | --- |
| UUID | uuid | CHAR(36) | Chave primária |
| Tipo | tipo | TINYINT NOT NULL | 1 = Entrada, 2 = Saída |
| Valor em centavos | valor_em_centavos | BIGINT NOT NULL | Valor da movimentação em centavos (R$ 1,00 = 100) |
| Descrição do lançamento | descricao_do_lancamento | TEXT NOT NULL | Descrição detalhada |
| Categoria UUID | categoria_uuid | CHAR(36) | UUID da categoria financeira |
| URL Anexo | url_anexo | TEXT | Link para comprovante/recibo |
| Data do Lançamento | data_do_lancamento | DATE NOT NULL | Data em que ocorreu a movimentação |
| Horta UUID | horta_uuid | CHAR(36) | UUID da horta |
| Excluído | excluido | BOOLEAN DEFAULT FALSE | Exclusão lógica |
| Usuário Criador | usuario_criador_uuid | CHAR(36) | UUID do usuário que criou |
| Data de Criação | data_de_criacao | TIMESTAMP DEFAULT NOW() | Data/hora da criação |
| Usuário Alterador | usuario_alterador_uuid | CHAR(36) | UUID do último usuário que alterou |
| Data da Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração |

### Relacionamentos de FINANCEIRO HORTA:

- **horta_uuid** → hortas.uuid (N:1)
- **categoria_uuid** → categorias_financeiras.uuid (N:1)
- **usuario_criador_uuid** → usuarios.uuid (N:1)
- **usuario_alterador_uuid** → usuarios.uuid (N:1)

---

## 3. FINANCEIRO ASSOCIAÇÃO | `bd.financeiro_associacao`

Gera o caixa da associação, e permite que entradas no caixa sejam oriundas das mensalidades mantidas na tabela à seguir.

| Nome do Campo | Nome Coluna | Tipo | Observação |
| --- | --- | --- | --- |
| UUID | uuid | CHAR(36) | Chave primária |
| Tipo | tipo | TINYINT NOT NULL | 1 = Entrada, 2 = Saída |
| Valor em centavos | valor_em_centavos | BIGINT NOT NULL | Valor da movimentação em centavos (R$ 1,00 = 100) |
| Descrição do lançamento | descricao_do_lancamento | TEXT NOT NULL | Descrição detalhada |
| Categoria UUID | categoria_uuid | CHAR(36) | UUID da categoria financeira |
| URL Anexo | url_anexo | TEXT | Link para comprovante/recibo |
| Data do Lançamento | data_do_lancamento | DATE NOT NULL | Data em que ocorreu a movimentação |
| Associação UUID | associacao_uuid | CHAR(36) | UUID da associação |
| Mensalidade UUID | mensalidade_uuid | CHAR(36) | FK opcional para vincular o lançamento a uma mensalidade |
| Excluído | excluido | BOOLEAN DEFAULT FALSE | Exclusão lógica |
| Usuário Criador | usuario_criador_uuid | CHAR(36) | UUID do usuário que criou |
| Data de Criação | data_de_criacao | TIMESTAMP DEFAULT NOW() | Data/hora da criação |
| Usuário Alterador | usuario_alterador_uuid | CHAR(36) | UUID do último usuário que alterou |
| Data da Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração |

### Relacionamentos de FINANCEIRO ASSOCIAÇÃO:

- **associacao_uuid** → associacoes.uuid (N:1)
- **categoria_uuid** → categorias_financeiras.uuid (N:1)
- **mensalidade_uuid** → mensalidades.uuid (N:1) - Opcional
- **usuario_criador_uuid** → usuarios.uuid (N:1)
- **usuario_alterador_uuid** → usuarios.uuid (N:1)

---

## 4. MENSALIDADES | `bd.mensalidades`

Gere as mensalidades.

Pode ser criada uma procedure no próprio banco ao ser atualizado o status para `2 - Compensado` em uma mensalidade para que a tabela `Usuários` tenha o registro do usuário atrelado com status definido para liberado para usar a plataforma, ou se o status for diferente de 2 seja status bloqueado

Em caso de status = 2, que seja feito uma entrada na tabela de caixa da associação com o valor configurado que o usuário paga (por esse motivo não é configurado aqui o valor, é configurado no perfil do usuário quanto ele paga (se é que paga algo, vide dependentes).

| Nome do Campo | Nome Coluna | Tipo | Observação |
| --- | --- | --- | --- |
| UUID | uuid | CHAR(36) | Chave primária |
| Usuário | usuario_uuid | CHAR(36) | FK para usuários (quem paga a mensalidade) |
| Associação | associacao_uuid | CHAR(36) | FK para a associação dona do vínculo |
| Valor em centavos | valor_em_centavos | BIGINT NOT NULL | Valor da mensalidade em centavos (copiado de usuarios.taxa_associado_em_centavos) |
| Mês Referência | mes_referencia | DATE NOT NULL | Primeiro dia do mês de referência (YYYY-MM-01) |
| Data de Vencimento | data_vencimento | DATE NOT NULL | Data que deveria pagar |
| Data de Pagamento | data_pagamento | DATE | Preenchido quando efetivamente pago |
| Status | status | TINYINT NOT NULL DEFAULT 0 | 0 = aguardando pagamento, 1 = pago, 2 = compensado/concluído, 3 = cancelado, 4 = em atraso |
| Dias de Atraso | dias_atraso | INT DEFAULT 0 | Calculado automaticamente |
| Multa em centavos | multa_em_centavos | BIGINT DEFAULT 0 | Valor da multa por atraso |
| Juros em centavos | juros_em_centavos | BIGINT DEFAULT 0 | Valor dos juros por atraso |
| Valor Total em centavos | valor_total_em_centavos | BIGINT | valor_em_centavos + multa_em_centavos + juros_em_centavos |
| URL Anexo | url_anexo | TEXT | Link para comprovante/recibo |


# 📗Tabelas para gestão da plataforma

Inicialmente acordamos com o Thiago de deixar mais pra frente para implementar. Pensamos em uma tabela para Planos armazenando as informações de planos, uma tabela para Limites de Dados por plano. A gestão dos pagamentos já é comportada pelas tabelas acima.
