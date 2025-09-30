# 🥑 Banco de Dados | Documentação

## 📑 Sumário
- [📗 Introdução](#introducao)
- [🎲 Stack](#stack)
- [📝 Auditoria](#auditoria)
- [📚 Decisões Gerais](#decisões-gerais)
- [📗 Tabelas Principais](#tabelas-principais)
  - [Usuários](#1-usuários--bdusuarios)
  - [Associações](#2-associações--bdassociacoes)
  - [Hortas](#3-hortas--bdhortas)
  - [Endereços](#4-endereços--bdenderecos)
  - [Canteiros](#5-canteiros--bdcanteiros)
  - [Canteiros e Usuários](#6-canteiros-e-usuários--bdcanteiros_e_usuarios)
  - [Chaves](#7-chaves--bdchaves)
  - [Fila de Usuários](#8-fila-de-usuários--bdfila_de_usuarios)
- [📗 Tabelas para Controle de Acesso a Recursos | RBAC Híbrido](#tabelas-para-controle-de-acesso-a-recursos--rbac-híbrido)
  - [Cargos](#1-cargos--bdcargos)
  - [Permissões](#2-permissões--bdpermissoes)
  - [Permissões de Cargo](#3-permissões-de-cargo--bdpermissoes_de_cargo)
  - [Permissões de Exceção](#4-permissões-de-exceção--bdpermissoes_de_excecao)
- [📗 Tabelas para Gestão Financeira](#tabelas-para-gestao-financeira)
  - [1. Categorias Financeiras | `bd.categorias_financeiras`](#1-categorias-financeiras--bdcategorias_financeiras)
  - [2. Financeiro da Horta | `bd.financeiro_da_horta`](#2-financeiro-da_horta--bdfinanceiro_da_horta)
  - [3. Financeiro da Associação | `bd.financeiro_da_associacao`](#3-financeiro-da-associação--bdfinanceiro_da_associacao)
  - [4. Mensalidades da Associação | `bd.mensalidades_da_associacao`](#4-mensalidades-da-associação--bdmensalidades_da_associacao)
  - [5. Mensalidades da Plataforma | `bd.mensalidades_da_plataforma`](#5-mensalidades-da-plataforma--bdmensalidades_da_plataforma)
  - [6. Planos | `bd.planos`](#6-planos--bdplanos)
  - [7. Recursos do Plano | `bd.recursos_do_plano`](#7-recursos-do-plano--bdrecursos_do_plano)
- [📋 Índices Recomendados](#indices-recomendados)

<h1 id="introducao">📗 Introdução</h1>

⚠️ **Importante:** Usamos o Claude Sonnet 4 para revisão e formatação dessa documentação. Qualquer erro aparente é decorrente desse robo maldito que tanto nos auxilia.

<h2 id="stack">🎲 Stack</h2>

O banco de dados foi projetado seguindo algumas definições técnicas:

- **MySQL 8.0:** Tipos de dados dos campos e funcionalidades compatíveis com essa versão
- **JWT para autenticação e autorização:** Não serão mantidas tabelas para autenticação e sessões. Utilizaremos uma estratégia de JWT tokens com payloads contendo UUID dos usuários + UUID dos cargos dos usuários e eventuais novas gerações de token mediante a alteração no usuário
- **Linguagem PT-BR:** Os nomes das variáveis e colunas estão em português do Brasil
- **Redis:** Principal uso será para o cacheamento de permissões do usuário, que serão calculadas no fluxo de permissões explicado mais adiante
 
<h2 id="auditoria">📝 Auditoria</h2>

Todas as tabelas têm campos destinados para auditoria, suporte técnico e histórico de ações dos usuários:

| Nome do Campo | Nome da Coluna | Tipo de Dado |
| --- | --- | --- |
| **Data de criação** | `data_de_criacao` | TIMESTAMP DEFAULT NOW() |
| **Usuário de criação** | `usuario_criador_uuid` | CHAR(36) |
| **Data de Última Alteração** | `data_de_ultima_alteracao` | TIMESTAMP DEFAULT NOW() |
| **Usuário de alteração** | `usuario_alterador_uuid` | CHAR(36) |

Optamos por utilizar **exclusão lógica** no banco de dados, o que significa que entidades excluídas terão o campo `excluido` definido como `TRUE`, mantendo o registro fisicamente no banco para consultas futuras.

<h2 id="decisões-gerais">📚 Decisões Gerais</h2>

- **Campos `url_*` em algumas tabelas:** Destinados a arquivos, definidos como URL (links) para que a camada de aplicação possa tratar os arquivos, guardar em um armazenamento como S3 da AWS e salvar o link no campo, ou o próprio usuário pode salvar em armazenamento como Google Drive e informar a URL no frontend. Dessa forma economizamos com salvamento de blobs e/ou contratação de ferramentas externas no MVP

- **Prefixo `bd.*` nos nomes das tabelas:** É genérico, o nome do banco de dados precisará ser definido conforme o nome da plataforma, geralmente usamos o nome da aplicação e ambiente (ex: "comunortas-sandbox.tabela", aqui só "bd.tabela")

- **Plural:** Usamos os nomes de tabela no plural

- **Autenticação e Autorização:** Optamos por utilizar o RBAC (Role Based Access Control) híbrido com Feature Flag. Cada usuário terá um conjunto de permissões advindas do seu cargo, e também um outro conjunto de permissões advindas de flags de exceção. A junção desses dois conjuntos resulta num set final que representa as permissões reais daquele usuário. Isso permite que as flags de exceção adicionem ou removam acesso de alguma funcionalidade que pelo cargo do usuário deveria ser o oposto. Dessa forma temos um controle granular de permissões sem precisar gerar diversos cargos praticamente iguais com leves variações

- **Envio de email:** Para alguns cenários cabe o envio de email, como informar da aprovação da conta, lembrar do pagamento do plano, redefinição de senha, etc. Para o MVP da plataforma deixamos manual - os usuários staff (administradores da plataforma) serão injetados no banco, e caberá a eles gerenciar essas demandas

- **Gateway de Pagamento:** Não foi definido um gateway de pagamento. A princípio as configurações de pagamento de mensalidades à associação e mensalidades à plataforma deverão ser feitas manualmente pelos usuários com cargos relevantes. Entretanto, já pensamos nessas funcionalidades para futura integração com webhooks que atualizam os registros relevantes - futuramente basta plugar os SDKs nos módulos relevantes e adicionar colunas/tabelas necessárias

- **Planos da Plataforma:** Atualmente criamos 3 planos fictícios apenas para iniciar a funcionalidade. Como as tabelas relevantes possuem a capacidade de vincular restrições aos planos, basta adicionar as regras dos planos futuramente. O desenvolvimento da camada de aplicação deverá respeitar essas definições. **Planos criados:**
  - 🥉 **0 - Bronze:** 1 usuário responsável + 1 usuário de cargo administrativo + infinitos canteiristas e dependentes
  - 🥈 **1 - Prata:** 1 usuário responsável + 2 usuários de cargo administrativo + infinitos canteiristas e dependentes
  - 🥇 **2 - Ouro:** 1 usuário responsável + 3 usuários de cargo administrativo + infinitos canteiristas e dependentes

<h1 id="tabelas-principais">📗 Tabelas Principais</h1>

Tabelas necessárias para manter uma base de staff (administradores da plataforma), base de usuários, e gerenciar acesso aos recursos do módulo financeiro. Futuramente, com outros tipos de recursos como inventário ou estoque das produções das hortas, ou estoque de equipamentos e infraestrutura, essas tabelas podem servir de base para o gerenciamento de funcionalidades.

## 1. USUÁRIOS | `bd.usuarios`

| Nome do Campo | Nome da Coluna | Tipo | Observação |
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
| Apelido | apelido | VARCHAR(100) | Nome informal do usuário |
| Dias Ausente | dias_ausente | INT | Número de dias consecutivos de ausência |
| Chave UUID | chave_uuid | CHAR(36) | UUID da chave associada ao usuário |
| Status de Acesso | status_de_acesso | TINYINT DEFAULT 1 | 0 = Bloqueado, 1 = Ativo, 2 = Suspenso, 3 = Pendente aprovação |
| Responsável da Conta | responsavel_da_conta | BOOLEAN DEFAULT FALSE | Se é o criador da conta na plataforma e responsável por ela |
| Data Bloqueio Acesso | data_bloqueio_acesso | TIMESTAMP | Data em que o acesso foi bloqueado |
| Motivo Bloqueio Acesso | motivo_bloqueio_acesso | TEXT | Motivo do bloqueio de acesso |
| Excluído | excluido | BOOLEAN DEFAULT FALSE | Exclusão lógica |
| Usuário Criador | usuario_criador_uuid | CHAR(36) | UUID do usuário que criou |
| Data de Criação | data_de_criacao | TIMESTAMP DEFAULT NOW() | Data/hora da criação |
| Usuário Alterador | usuario_alterador_uuid | CHAR(36) | UUID do último usuário que alterou |
| Data de Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração |

Consideramos que usuários só poderão ter um cargo por vez. Exceções tratadas na tabela respectiva.

### Relacionamentos de USUÁRIOS:
- **cargo_uuid** → cargos.uuid (N:1)
- **endereco_uuid** → enderecos.uuid (N:1)
- **associacao_uuid** → associacoes.uuid (N:1)
- **horta_uuid** → hortas.uuid (N:1)
- **usuario_associado_uuid** → usuarios.uuid (N:1) - Self reference para dependentes
- **usuario_criador_uuid** → usuarios.uuid (N:1)
- **usuario_alterador_uuid** → usuarios.uuid (N:1)
- **chave_uuid** → chaves.uuid (N:1)

---

## 2. ASSOCIAÇÕES | `bd.associacoes`

| Nome do Campo | Nome da Coluna | Tipo | Observação |
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
| Usuário Responsável | usuario_responsavel_uuid | CHAR(36) | UUID do usuário responsável pela associação |
| Usuário Criador | usuario_criador_uuid | CHAR(36) | UUID do usuário que criou |
| Data de Criação | data_de_criacao | TIMESTAMP DEFAULT NOW() | Data/hora da criação |
| Usuário Alterador | usuario_alterador_uuid | CHAR(36) | UUID do último usuário que alterou |
| Data de Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração |

### Relacionamentos de ASSOCIAÇÕES:
- **endereco_uuid** → enderecos.uuid (N:1)
- **usuario_responsavel_uuid** → usuarios.uuid (N:1)
- **usuario_criador_uuid** → usuarios.uuid (N:1)
- **usuario_alterador_uuid** → usuarios.uuid (N:1)

---

## 3. HORTAS | `bd.hortas`

| Nome do Campo | Nome da Coluna | Tipo | Observação |
| --- | --- | --- | --- |
| UUID | uuid | CHAR(36) | Chave primária |
| Nome da Horta | nome_da_horta | VARCHAR(255) NOT NULL | Nome identificador da horta |
| Endereço | endereco_uuid | CHAR(36) NOT NULL | UUID do endereço |
| Associação Vinculada | associacao_vinculada_uuid | CHAR(36) NOT NULL | UUID da associação responsável |
| Percentual Taxa Associado | percentual_taxa_associado | DECIMAL(5,2) NOT NULL | % que fica para o caixa da horta |
| Excluído | excluido | BOOLEAN DEFAULT FALSE | Exclusão lógica |
| Usuário Criador | usuario_criador_uuid | CHAR(36) | UUID do usuário que criou |
| Tipo de Liberação da Horta | tipo_de_liberacao | TINYINT DEFAULT 1 | 1 = Concessão, 2 = Permissão, 3 = Irregular |
| Data de Criação | data_de_criacao | TIMESTAMP DEFAULT NOW() | Data/hora da criação |
| Usuário Alterador | usuario_alterador_uuid | CHAR(36) | UUID do último usuário que alterou |
| Data de Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração |

### Relacionamentos de HORTAS:
- **endereco_uuid** → enderecos.uuid (N:1)
- **associacao_vinculada_uuid** → associacoes.uuid (N:1)
- **usuario_criador_uuid** → usuarios.uuid (N:1)
- **usuario_alterador_uuid** → usuarios.uuid (N:1)

---

## 4. ENDEREÇOS | `bd.enderecos`

| Nome do Campo | Nome da Coluna | Tipo | Observação |
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
| Data de Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração |

### Relacionamentos de ENDEREÇOS:
- **usuario_criador_uuid** → usuarios.uuid (N:1)
- **usuario_alterador_uuid** → usuarios.uuid (N:1)

---

## 5. CANTEIROS | `bd.canteiros`

| Nome do Campo | Nome da Coluna | Tipo | Observação |
| --- | --- | --- | --- |
| UUID | uuid | CHAR(36) | Chave primária |
| Número Identificador | numero_identificador | VARCHAR(20) NOT NULL | Único dentro da horta |
| Tamanho m² | tamanho_m2 | DECIMAL(8,2) NOT NULL | Tamanho em metros quadrados |
| Horta | horta_uuid | CHAR(36) NOT NULL | UUID da horta |
| Usuário Anterior | usuario_anterior_uuid | CHAR(36) | UUID do último usuário que esteve atrelado |
| Excluído | excluido | BOOLEAN DEFAULT FALSE | Exclusão lógica |
| Usuário Criador | usuario_criador_uuid | CHAR(36) | UUID do usuário que criou |
| Data de Criação | data_de_criacao | TIMESTAMP DEFAULT NOW() | Data/hora da criação |
| Usuário Alterador | usuario_alterador_uuid | CHAR(36) | UUID do último usuário que alterou |
| Data de Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração |

### Sobre a multiplicidade
A tabela de canteiros foi modificada para suportar múltiplos proprietários por canteiro através da tabela de vínculo `canteiros_e_usuarios` descrita abaixo.

### Relacionamentos de CANTEIROS:
- **horta_uuid** → hortas.uuid (N:1)
- **usuario_criador_uuid** → usuarios.uuid (N:1)
- **usuario_anterior_uuid** → usuarios.uuid (N:1)
- **usuario_alterador_uuid** → usuarios.uuid (N:1)

---

## 6. CANTEIROS E USUÁRIOS | `bd.canteiros_e_usuarios`

Tabela de vínculo N:N entre canteiros e usuários, permitindo copropriedade de canteiros.

| Nome do Campo | Nome da Coluna | Tipo | Observação |
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
| Data de Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração |

### Relacionamentos de CANTEIROS E USUÁRIOS:
- **canteiro_uuid** → canteiros.uuid (N:1)
- **usuario_uuid** → usuarios.uuid (N:1)
- **usuario_criador_uuid** → usuarios.uuid (N:1)
- **usuario_alterador_uuid** → usuarios.uuid (N:1)

## 7. CHAVES | `bd.chaves`

Tabela de vínculo N:N entre chaves e usuários, representa as chaves físicas da horta.

| Nome do Campo | Nome da Coluna | Tipo | Observação |
| --- | --- | --- | --- |
| UUID | uuid | CHAR(36) | Chave primária |
| Código | uuid | a definir | Código na tag da chave |
| Horta UUID | horta_uuid | CHAR(36) NOT NULL | UUID da horta |
| Observações | observacoes | TEXT | Observações sobre o item |
| Disponivel | disponivel | BOOLEAN DEFAULT TRUE | Status se disponivel |
| Excluído | excluido | BOOLEAN DEFAULT FALSE | Exclusão lógica |
| Usuário Criador | usuario_criador_uuid | CHAR(36) | UUID do usuário que criou |
| Data de Criação | data_de_criacao | TIMESTAMP DEFAULT NOW() | Data/hora da criação |
| Usuário Alterador | usuario_alterador_uuid | CHAR(36) | UUID do último usuário que alterou |
| Data de Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração |

### Relacionamentos de CANTEIROS E USUÁRIOS:
- **horta_uuid** → hortas.uuid (N:1)
- **usuario_uuid** → usuarios.uuid (N:1)
- **usuario_criador_uuid** → usuarios.uuid (N:1)
- **usuario_alterador_uuid** → usuarios.uuid (N:1)

## 8 FILA DE USUÁRIOS | `bd.fila_de_usuarios`

Representa fila para entrar na horta.

| Nome do Campo            | Nome da Coluna           | Tipo                    | Observação                                   |
| ------------------------ | ------------------------ | ----------------------- | -------------------------------------------- |
| UUID                     | uuid                     | CHAR(36)                | Chave primária                               |
| Usuário UUID             | usuario_uuid             | CHAR(36) NOT NULL       | Usuário que entrou na fila                   |
| Horta UUID               | horta_uuid               | CHAR(36) NOT NULL       | Horta para a qual o usuário aguarda canteiro |
| Data de Entrada          | data_entrada             | TIMESTAMP DEFAULT NOW() | Momento em que o usuário entrou na fila      |
| Ordem                    | ordem                    | INT AUTO_INCREMENT      | Ordem de chegada na fila (controle interno)  |
| Excluído                 | excluido                 | BOOLEAN DEFAULT FALSE   | Exclusão lógica                              |
| Usuário Criador          | usuario_criador_uuid     | CHAR(36)                | UUID do usuário que criou                    |
| Data de Criação          | data_de_criacao          | TIMESTAMP DEFAULT NOW() | Data/hora da criação                         |
| Usuário Alterador        | usuario_alterador_uuid   | CHAR(36)                | UUID do último usuário que alterou           |
| Data de Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração                |

### Relacionamentos de FILA DE USUÁRIOS:

- **usuario_uuid** → usuarios.uuid (N:1)
- **horta_uuid** → hortas.uuid (N:1)
- **usuario_criador_uuid** → usuarios.uuid (N:1)
- **usuario_alterador_uuid** → usuarios.uuid (N:1)


---

<h1 id="tabelas-para-controle-de-acesso-a-recursos--rbac-híbrido">📗 Tabelas para Controle de Acesso a Recursos | RBAC Híbrido</h1>

O controle de acesso às funcionalidades e recursos da aplicação será feito via RBAC híbrido (mistura de RBAC com feature flag).

No Role Based Access Control - RBAC padrão, os cargos têm um conjunto de permissões atreladas.

Porém, para organizações com múltiplos cenários, fica complicado desenhar as permissões desses cargos para atender a todos os possíveis casos de uso.

Com o uso de feature flag somada, podemos criar cenários onde o usuário tem todas as permissões de seu cargo base e também permissões extras, ou então tem todas as permissões do cargo exceto algumas.

Essa foi a maneira mais otimizada considerando os trade-offs em outros tipos de controle.

O foco aqui é modularização, para permitir o sistema crescer de forma orgânica sem criar dependências sobre dependências.

### Fluxo de Permissões

Supondo que o usuário ID 99999 logou e queremos as permissões, o tratamento feito será:

→ Selecionar todas as permissões para o cargo_uuid dele

→ Selecionar todas as exceções para o user_uuid dele  

→ Concatenar ambas, isso vai gerar um "set" de permissões

Essa concatenação prioriza as exceções como verdade, pois elas que sobreescrevem as permissões de cargo e não faria sentido ser o oposto.

Essas permissões podem ser acessadas em um endpoint `user/permissions/` com UUID do user fornecido no header da requisição via JWT. Essas permissões podem ser cacheadas, e atualizadas a cada X minutos ou Y eventos.

Dessa forma, evitamos uma tabela de permissões do usuário com dezenas ou centenas de linhas para um único usuário. Teremos as permissões dos cargos, e alguns "ajustes" para o caso de uso de cada Associação ou Horta.

## 1. CARGOS | `bd.cargos`

Armazena os cargos possíveis no sistema. Atualmente temos 5 cargos base.

| Nome do Campo | Nome da Coluna | Tipo | Observação |
| --- | --- | --- | --- |
| UUID | uuid | CHAR(36) | Chave primária |
| Código | codigo | INT UNIQUE NOT NULL | 0-4 conforme especificação |
| Slug | slug | VARCHAR(100) UNIQUE NOT NULL | Identificador amigável |
| Nome | nome | VARCHAR(100) NOT NULL | Nome do cargo |
| Descrição | descricao | TEXT | Descrição do cargo |
| Cor | cor | VARCHAR(7) | Código hexadecimal da cor |
| Excluído | excluido | BOOLEAN DEFAULT FALSE | Exclusão lógica |
| Usuário Criador | usuario_criador_uuid | CHAR(36) | UUID do usuário que criou |
| Data de Criação | data_de_criacao | TIMESTAMP DEFAULT NOW() | Data/hora da criação |
| Usuário Alterador | usuario_alterador_uuid | CHAR(36) | UUID do último usuário que alterou |
| Data de Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração |

### Relacionamentos de CARGOS:
- **usuario_criador_uuid** → usuarios.uuid (N:1)
- **usuario_alterador_uuid** → usuarios.uuid (N:1)

### Definição de Cargos:

Utilizando um número como código podemos deixar a camada de aplicação 100% pronta sem depender do tratamento de UUIDs. Por exemplo:

```php
if ($usuario['cargo']['slug'] === "admin_platafora") {
    echo "Usuário é Administração da Associação Geral";
}
```

| Nome do Cargo | Slug | Código |
| --- | --- | --- |
| Administração da Plataforma | admin_plataforma | 0 |
| Administração da Associação | admin_associacao_geral | 1 |
| Administração da Horta | admin_horta_geral | 2 |
| Canteirista | canteirista | 3 |
| Dependente | dependente | 4 |

⚠️ **Importante:** Os registros em `bd.usuarios` que tiverem o campo de usuário ao qual dependem, ou seja, são dependentes, não deverão ter o valor de mensalidade preenchível pois em teoria não pagam taxa de associado - só quem paga é o associado principal.

## 2. PERMISSÕES | `bd.permissoes`

| Nome do Campo | Nome da Coluna | Tipo | Observação |
| --- | --- | --- | --- |
| UUID | uuid | CHAR(36) | Chave primária |
| Slug da Permissão | slug | VARCHAR(100) UNIQUE NOT NULL | Identificador amigável |
| tipo | tipo | TINYINT NOT NULL | Tipo da permissão (0 - criar, 1 - atualizar, 2 - ler, 3 - deletar) |
| Módulo | modulo | TINYINT NOT NULL | Módulo do sistema |
| Descrição | descricao | TEXT | Descrição da permissão |
| Excluído | excluido | BOOLEAN DEFAULT FALSE | Exclusão lógica |
| Usuário Criador | usuario_criador_uuid | CHAR(36) | UUID do usuário que criou |
| Data de Criação | data_de_criacao | TIMESTAMP DEFAULT NOW() | Data/hora da criação |
| Usuário Alterador | usuario_alterador_uuid | CHAR(36) | UUID do último usuário que alterou |
| Data de Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração |

### Relacionamentos de PERMISSÕES:
- **usuario_criador_uuid** → usuarios.uuid (N:1)
- **usuario_alterador_uuid** → usuarios.uuid (N:1)

Sobre as permissões, atualmente temos:
```php
enum Permissoes: int
{
    case LER = 0;
    case CRIAR = 1;
    case EDITAR = 2;
    case DELETAR = 3;
}
```
Sobre os módulos, atualmente temos:

```php
enum Modulos: int
{
    case USUARIOS = 0;
    case ASSOCIACOES = 1;
    case HORTAS = 2;
    case ENDERECOS = 3;
    case CANTEIROS = 4;
    case CANTEIROS_E_USUARIOS = 5;
    case CARGOS = 6;
    case PERMISSOES = 7;
    case PERMISSOES_DE_CARGO = 8;
    case PERMISSOES_DE_EXCECAO = 9;
    case CATEGORIAS_FINANCEIRAS = 10;
    case FINANCEIRO_HORTA = 11;
    case FINANCEIRO_ASSOCIACAO = 12;
    case MENSALIDADES_DA_ASSOCIACAO = 13;
    case MENSALIDADES_DA_PLATAFORMA = 14;
    case PLANOS = 15;
    case RECURSOS_DO_PLANO = 16;
    case CHAVES = 17;
    case FILA_DE_USUARIO = 18;
}
```

Uma permissão se dá por X, Y onde X = módulo e Y = tipo de permissão.

---

## 3. PERMISSÕES DE CARGO | `bd.permissoes_de_cargo`

Tabela que armazena o que cada cargo pode fazer, por padrão, na plataforma.

| Nome do Campo | Nome da Coluna | Tipo | Observação |
| --- | --- | --- | --- |
| UUID | uuid | CHAR(36) | Chave primária |
| Cargo UUID | cargo_uuid | CHAR(36) NOT NULL | UUID do cargo |
| Permissão UUID | permissao_uuid | CHAR(36) NOT NULL | UUID da permissão |
| Excluído | excluido | BOOLEAN DEFAULT FALSE | Exclusão lógica |
| Usuário Criador | usuario_criador_uuid | CHAR(36) | UUID do usuário que criou |
| Data de Criação | data_de_criacao | TIMESTAMP DEFAULT NOW() | Data/hora da criação |
| Usuário Alterador | usuario_alterador_uuid | CHAR(36) | UUID do último usuário que alterou |
| Data de Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração |

### Relacionamentos de PERMISSÕES DE CARGO:
- **cargo_uuid** → cargos.uuid (N:1)
- **permissao_uuid** → permissoes.uuid (N:1)
- **usuario_criador_uuid** → usuarios.uuid (N:1)
- **usuario_alterador_uuid** → usuarios.uuid (N:1)

## 4. PERMISSÕES DE EXCEÇÃO | `bd.permissoes_de_excecao`

| Nome do Campo | Nome da Coluna | Tipo | Observação |
| --- | --- | --- | --- |
| UUID | uuid | CHAR(36) | Chave primária |
| Usuário UUID | usuario_uuid | CHAR(36) NOT NULL | UUID do usuário |
| Permissão UUID | permissao_uuid | CHAR(36) NOT NULL | UUID da permissão |
| Liberado | liberado | BOOLEAN DEFAULT FALSE | Status da permissão para o usuário |
| Excluído | excluido | BOOLEAN DEFAULT FALSE | Exclusão lógica |
| Usuário Criador | usuario_criador_uuid | CHAR(36) | UUID do usuário que criou |
| Data de Criação | data_de_criacao | TIMESTAMP DEFAULT NOW() | Data/hora da criação |
| Usuário Alterador | usuario_alterador_uuid | CHAR(36) | UUID do último usuário que alterou |
| Data de Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração |

### Relacionamentos de PERMISSÕES DE EXCEÇÃO:
- **usuario_uuid** → usuarios.uuid (N:1)
- **permissao_uuid** → permissoes.uuid (N:1)
- **usuario_criador_uuid** → usuarios.uuid (N:1)
- **usuario_alterador_uuid** → usuarios.uuid (N:1)

---

# 
<h1 id="tabelas-para-gestao-financeira">📗 Tabelas para Gestão Financeira</h1>

## 1. CATEGORIAS FINANCEIRAS | `bd.categorias_financeiras`

Tabela para categorizar lançamentos financeiros, facilitando relatórios e controle.

| Nome do Campo | Nome da Coluna | Tipo | Observação |
| --- | --- | --- | --- |
| UUID | uuid | CHAR(36) | Chave primária |
| Nome | nome | VARCHAR(100) NOT NULL | Nome da categoria |
| Descrição | descricao | TEXT | Descrição da categoria |
| Tipo | tipo | TINYINT NOT NULL | 1 = Entrada, 2 = Saída, 3 = Ambos |
| Cor | cor | VARCHAR(7) | Código hexadecimal da cor para interface |
| Ícone | icone | VARCHAR(50) | Nome do ícone para interface |
| Associação UUID | associacao_uuid | CHAR(36) | UUID da associação (NULL = categoria de horta) |
| Horta UUID | horta_uuid | CHAR(36) | UUID da associação (NULL = categoria de associação |
| Excluído | excluido | BOOLEAN DEFAULT FALSE | Exclusão lógica |
| Usuário Criador | usuario_criador_uuid | CHAR(36) | UUID do usuário que criou |
| Data de Criação | data_de_criacao | TIMESTAMP DEFAULT NOW() | Data/hora da criação |
| Usuário Alterador | usuario_alterador_uuid | CHAR(36) | UUID do último usuário que alterou |
| Data de Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração |

### Relacionamentos de CATEGORIAS FINANCEIRAS:
- **associacao_uuid** → associacoes.uuid (N:1) - Opcional
- **horta_uuid** → associacoes.uuid (N:1) - Opcional
- **usuario_criador_uuid** → usuarios.uuid (N:1)
- **usuario_alterador_uuid** → usuarios.uuid (N:1)

### Categorias Padrão Sugeridas:
- Mensalidade
- Doação
- Manutenção
- Insumos
- Equipamentos
- Infraestrutura
- Taxa administrativa
- Outros

---

## 2. FINANCEIRO DA HORTA | `bd.financeiro_da_horta`

Tabela para manter um registro de caixa da Horta. Não comporta gestão de pagamento dos canteiristas, que será gerida pelas próximas tabelas.

| Nome do Campo | Nome da Coluna | Tipo | Observação |
| --- | --- | --- | --- |
| UUID | uuid | CHAR(36) | Chave primária |
| Valor em Centavos | valor_em_centavos | BIGINT NOT NULL | Valor da movimentação em centavos (R$ 1,00 = 100) |
| Descrição do Lançamento | descricao_do_lancamento | TEXT NOT NULL | Descrição detalhada |
| Categoria UUID | categoria_uuid | CHAR(36) | UUID da categoria financeira |
| URL Anexo | url_anexo | TEXT | Link para comprovante/recibo |
| Data do Lançamento | data_do_lancamento | DATE NOT NULL | Data em que ocorreu a movimentação |
| Horta UUID | horta_uuid | CHAR(36) NOT NULL | UUID da horta |
| Excluído | excluido | BOOLEAN DEFAULT FALSE | Exclusão lógica |
| Usuário Criador | usuario_criador_uuid | CHAR(36) | UUID do usuário que criou |
| Data de Criação | data_de_criacao | TIMESTAMP DEFAULT NOW() | Data/hora da criação |
| Usuário Alterador | usuario_alterador_uuid | CHAR(36) | UUID do último usuário que alterou |
| Data de Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração |

### Relacionamentos de FINANCEIRO DA HORTA:
- **horta_uuid** → hortas.uuid (N:1)
- **categoria_uuid** → categorias_financeiras.uuid (N:1)
- **usuario_criador_uuid** → usuarios.uuid (N:1)
- **usuario_alterador_uuid** → usuarios.uuid (N:1)

---

## 3. FINANCEIRO DA ASSOCIAÇÃO | `bd.financeiro_da_associacao`

Gera o caixa da associação, e permite que entradas no caixa sejam oriundas das mensalidades mantidas na tabela seguinte.

| Nome do Campo | Nome da Coluna | Tipo | Observação |
| --- | --- | --- | --- |
| UUID | uuid | CHAR(36) | Chave primária |
| Valor em Centavos | valor_em_centavos | BIGINT NOT NULL | Valor da movimentação em centavos (R$ 1,00 = 100) |
| Descrição do Lançamento | descricao_do_lancamento | TEXT NOT NULL | Descrição detalhada |
| Categoria UUID | categoria_uuid | CHAR(36) | UUID da categoria financeira |
| URL Anexo | url_anexo | TEXT | Link para comprovante/recibo |
| Data do Lançamento | data_do_lancamento | DATE NOT NULL | Data em que ocorreu a movimentação |
| Associação UUID | associacao_uuid | CHAR(36) NOT NULL | UUID da associação |
| Mensalidade UUID | mensalidade_uuid | CHAR(36) | FK opcional para vincular o lançamento a uma mensalidade |
| Excluído | excluido | BOOLEAN DEFAULT FALSE | Exclusão lógica |
| Usuário Criador | usuario_criador_uuid | CHAR(36) | UUID do usuário que criou |
| Data de Criação | data_de_criacao | TIMESTAMP DEFAULT NOW() | Data/hora da criação |
| Usuário Alterador | usuario_alterador_uuid | CHAR(36) | UUID do último usuário que alterou |
| Data de Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração |

### Relacionamentos de FINANCEIRO DA ASSOCIAÇÃO:
- **associacao_uuid** → associacoes.uuid (N:1)
- **categoria_uuid** → categorias_financeiras.uuid (N:1)
- **mensalidade_uuid** → mensalidades_da_associacao.uuid (N:1) - Opcional
- **usuario_criador_uuid** → usuarios.uuid (N:1)
- **usuario_alterador_uuid** → usuarios.uuid (N:1)

---

## 4. MENSALIDADES DA ASSOCIAÇÃO | `bd.mensalidades_da_associacao`

Gerencia as mensalidades dos associados.

Pode ser criada uma procedure no banco para que, ao ser atualizado o status para `2 - Compensado` em uma mensalidade, a tabela `Usuários` tenha o registro do usuário atrelado com status definido para liberado para usar a plataforma. Se o status for diferente de 2, o status será bloqueado.

Em caso de status = 2, que seja feita uma entrada na tabela de caixa da associação com o valor configurado que o usuário paga (por esse motivo não é configurado aqui o valor, é configurado no perfil do usuário quanto ele paga).

| Nome do Campo | Nome da Coluna | Tipo | Observação |
| --- | --- | --- | --- |
| UUID | uuid | CHAR(36) | Chave primária |
| Usuário | usuario_uuid | CHAR(36) NOT NULL | FK para usuários (quem paga a mensalidade) |
| Associação | associacao_uuid | CHAR(36) NOT NULL | FK para a associação dona do vínculo |
| Valor em Centavos | valor_em_centavos | BIGINT NOT NULL | Valor da mensalidade em centavos (copiado de usuarios.taxa_associado_em_centavos) |
| Data de Vencimento | data_vencimento | DATE NOT NULL | Data que deveria pagar |
| Data de Pagamento | data_pagamento | DATE | Preenchido quando efetivamente pago |
| Status | status | TINYINT NOT NULL DEFAULT 0 | 0 = aguardando pagamento, 1 = pago, 2 = compensado/concluído, 3 = cancelado, 4 = em atraso |
| Dias de Atraso | dias_atraso | INT DEFAULT 0 | Calculado automaticamente |
| URL Anexo | url_anexo | TEXT | Link para boleto, ordem de pagamento, etc |
| URL Recibo | url_anexo | TEXT | Link para comprovante, recibo, nota fiscal, etc |
| Excluído | excluido | BOOLEAN DEFAULT FALSE | Exclusão lógica |
| Usuário Criador | usuario_criador_uuid | CHAR(36) | UUID do usuário que criou |
| Data de Criação | data_de_criacao | TIMESTAMP DEFAULT NOW() | Data/hora da criação |
| Usuário Alterador | usuario_alterador_uuid | CHAR(36) | UUID do último usuário que alterou |
| Data de Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração |

### Relacionamentos de MENSALIDADES DA ASSOCIAÇÃO:
- **usuario_uuid** → usuarios.uuid (N:1)
- **associacao_uuid** → associacoes.uuid (N:1)
- **usuario_criador_uuid** → usuarios.uuid (N:1)
- **usuario_alterador_uuid** → usuarios.uuid (N:1)

---

## 5. MENSALIDADES DA PLATAFORMA | `bd.mensalidades_da_plataforma`

O usuário que criar a conta será o usuário responsável da conta por padrão, e é a ele que a mensalidade será atribuída.

| Nome do Campo | Nome da Coluna | Tipo | Observação |
| --- | --- | --- | --- |
| UUID | uuid | CHAR(36) | Chave primária |
| Usuário | usuario_uuid | CHAR(36) NOT NULL | FK para usuários (quem paga a mensalidade) |
| Associação | associacao_uuid | CHAR(36) NOT NULL | FK para a associação dona do vínculo |
| Valor em Centavos | valor_em_centavos | BIGINT NOT NULL | Valor da mensalidade em centavos |
| Mês Referência | mes_referencia | DATE NOT NULL | Primeiro dia do mês de referência (YYYY-MM-01) |
| Plano UUID | plano_uuid | CHAR(36) | UUID do plano |
| Data de Vencimento | data_vencimento | DATE NOT NULL | Data que deveria pagar |
| Data de Pagamento | data_pagamento | DATE | Preenchido quando efetivamente pago |
| Status | status | TINYINT NOT NULL DEFAULT 0 | 0 = aguardando pagamento, 1 = pago, 2 = compensado/concluído, 3 = cancelado, 4 = em atraso |
| Dias de Atraso | dias_atraso | INT DEFAULT 0 | Calculado automaticamente |
| URL Anexo | url_anexo | TEXT | Link para boleto, ordem de pagamento, etc |
| URL Recibo | url_anexo | TEXT | Link para comprovante, recibo, nota fiscal, etc |
| Excluído | excluido | BOOLEAN DEFAULT FALSE | Exclusão lógica |
| Usuário Criador | usuario_criador_uuid | CHAR(36) | UUID do usuário que criou |
| Data de Criação | data_de_criacao | TIMESTAMP DEFAULT NOW() | Data/hora da criação |
| Usuário Alterador | usuario_alterador_uuid | CHAR(36) | UUID do último usuário que alterou |
| Data de Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração |

### Relacionamentos de MENSALIDADES DA PLATAFORMA:
- **usuario_uuid** → usuarios.uuid (N:1)
- **associacao_uuid** → associacoes.uuid (N:1)
- **usuario_criador_uuid** → usuarios.uuid (N:1)
- **usuario_alterador_uuid** → usuarios.uuid (N:1)
- **plano_uuid** → planos.uuid (N:1)

---

## 6. PLANOS | `bd.planos`

| Nome do Campo | Nome da Coluna | Tipo | Observação |
| --- | --- | --- | --- |
| UUID | uuid | CHAR(36) | Chave primária |
| Código | codigo | INT UNIQUE NOT NULL | 0-2 inicialmente |
| Slug | slug | VARCHAR(100) UNIQUE NOT NULL | Identificador amigável |
| Valor em Centavos | valor_em_centavos | BIGINT NOT NULL | Valor da movimentação em centavos (R$ 1,00 = 100) |
| Nome | nome | VARCHAR(100) NOT NULL | Nome do plano |
| Descrição | descricao | TEXT | Descrição do plano |
| Excluído | excluido | BOOLEAN DEFAULT FALSE | Exclusão lógica |
| Usuário Criador | usuario_criador_uuid | CHAR(36) | UUID do usuário que criou |
| Data de Criação | data_de_criacao | TIMESTAMP DEFAULT NOW() | Data/hora da criação |
| Usuário Alterador | usuario_alterador_uuid | CHAR(36) | UUID do último usuário que alterou |
| Data de Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração |

### Relacionamentos de PLANOS:
- **usuario_criador_uuid** → usuarios.uuid (N:1)
- **usuario_alterador_uuid** → usuarios.uuid (N:1)

---

## 7. RECURSOS DO PLANO | `bd.recursos_do_plano`

| Nome do Campo | Nome da Coluna | Tipo | Observação |
| --- | --- | --- | --- |
| UUID | uuid | CHAR(36) | Chave primária |
| Plano UUID | plano_uuid | CHAR(36) NOT NULL | UUID do plano |
| Nome do Recurso | nome_do_recurso | VARCHAR(100) NOT NULL | Nome do recurso |
| Quantidade | quantidade | INT | Quantidade do recurso |
| Descrição | descricao | TEXT | Descrição do recurso |
| Excluído | excluido | BOOLEAN DEFAULT FALSE | Exclusão lógica |
| Usuário Criador | usuario_criador_uuid | CHAR(36) | UUID do usuário que criou |
| Data de Criação | data_de_criacao | TIMESTAMP DEFAULT NOW() | Data/hora da criação |
| Usuário Alterador | usuario_alterador_uuid | CHAR(36) | UUID do último usuário que alterou |
| Data de Última Alteração | data_de_ultima_alteracao | TIMESTAMP DEFAULT NOW() | Data/hora da última alteração |

### Relacionamentos de RECURSOS DO PLANO:
- **plano_uuid** → planos.uuid (N:1)
- **usuario_criador_uuid** → usuarios.uuid (N:1)
- **usuario_alterador_uuid** → usuarios.uuid (N:1)

---

<h2 id="indices-recomendados">📋 Índices Recomendados</h2>

Para otimizar a performance do banco de dados, recomenda-se criar os seguintes índices:

## Índices de Performance:
```sql
-- Usuários
CREATE INDEX idx_usuarios_cpf ON bd.usuarios(cpf);
CREATE INDEX idx_usuarios_email ON bd.usuarios(email);
CREATE INDEX idx_usuarios_cargo_uuid ON bd.usuarios(cargo_uuid);
CREATE INDEX idx_usuarios_associacao_uuid ON bd.usuarios(associacao_uuid);
CREATE INDEX idx_usuarios_status_acesso ON bd.usuarios(status_de_acesso);

-- Associações
CREATE INDEX idx_associacoes_cnpj ON bd.associacoes(cnpj);
CREATE INDEX idx_associacoes_status_aprovacao ON bd.associacoes(status_aprovacao);

-- Hortas
CREATE INDEX idx_hortas_associacao_vinculada ON bd.hortas(associacao_vinculada_uuid);

-- Canteiros
CREATE INDEX idx_canteiros_horta_uuid ON bd.canteiros(horta_uuid);
CREATE INDEX idx_canteiros_numero_horta ON bd.canteiros(numero_identificador, horta_uuid);

-- Financeiro
CREATE INDEX idx_financeiro_horta_data ON bd.financeiro_horta(data_do_lancamento);
CREATE INDEX idx_financeiro_associacao_data ON bd.financeiro_associacao(data_do_lancamento);
CREATE INDEX idx_mensalidades_associacao_mes ON bd.mensalidades_da_associacao(mes_referencia);
CREATE INDEX idx_mensalidades_plataforma_mes ON bd.mensalidades_da_plataforma(mes_referencia);

-- RBAC
CREATE INDEX idx_permissoes_cargo ON bd.permissoes_de_cargo(cargo_uuid, liberado);
CREATE INDEX idx_permissoes_excecao ON bd.permissoes_de_excecao(usuario_uuid, liberado);
```
Futuramente vamos revisitar essa seção para ver como isso auxilia o uso do Redis.

---

# 🔧 Constraints e Validações

## Constraints de Integridade:
- Todos os UUIDs devem seguir o padrão UUID v4
- CPF deve ser validado usando algoritmo de validação
- CNPJ deve ser validado usando algoritmo de validação
- Email deve seguir formato válido
- CEP deve seguir formato brasileiro (99999-999)
- Percentuais devem estar entre 0.00 e 100.00

## Validações de Negócio:
- Usuários dependentes não podem ter taxa de associado
- Canteiros devem ter pelo menos um proprietário principal ativo
- Soma dos percentuais de responsabilidade em canteiros não deve exceder 100%
- Status de acesso deve ser validado contra mensalidades em dia