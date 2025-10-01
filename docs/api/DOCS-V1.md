# 🥑 API REST + Regras de Negócio | Documentação

## 📑 Sumário
- [📗 Introdução](#introducao)
- [⏩ Início Rápido](#inicio-rapido)
- [🔒 Permissões por Cargo](#permissoes)
- [🧭 Rotas ](#rotas)
  - [📗 Login (POST)](#login-post)
  - [📗 Cadastro (POST)](#cadastro-post)
  - [📗 Associacoes (GET) ](#associacoes-get-list)
  - [📗 Associacoes (GET por UUID)](#associacoes-get-uuid)
  - [📗 Associacoes (POST)](#associacoes-post)
  - [📗 Associacoes (PUT)](#associacoes-put)
  - [📗 Associacoes (DELETE)](#associacoes-delete)
  - [📗 Canteiros-e-usuarios (GET) ](#canteiros-e-usuarios-get-list)
  - [📗 Canteiros-e-usuarios (GET por UUID)](#canteiros-e-usuarios-get-uuid)
  - [📗 Canteiros-e-usuarios (POST)](#canteiros-e-usuarios-post)
  - [📗 Canteiros-e-usuarios (PUT)](#canteiros-e-usuarios-put)
  - [📗 Canteiros-e-usuarios (DELETE)](#canteiros-e-usuarios-delete)
  - [📗 Canteiros (GET) ](#canteiros-get-list)
  - [📗 Canteiros (GET por UUID)](#canteiros-get-uuid)
  - [📗 Canteiros (POST)](#canteiros-post)
  - [📗 Canteiros (PUT)](#canteiros-put)
  - [📗 Canteiros (DELETE)](#canteiros-delete)
  - [📗 Cargos (GET) ](#cargos-get-list)
  - [📗 Cargos (GET por UUID)](#cargos-get-uuid)
  - [📗 Cargos (POST)](#cargos-post)
  - [📗 Cargos (PUT)](#cargos-put)
  - [📗 Cargos (DELETE)](#cargos-delete)
  - [📗 Categorias-financeiras (GET) ](#categorias-financeiras-get-list)
  - [📗 Categorias-financeiras (GET por UUID)](#categorias-financeiras-get-uuid)
  - [📗 Categorias-financeiras (GET) - Por Associacao](#categorias-financeiras-get-associacao)
  - [📗 Categorias-financeiras (GET) - Por Horta](#categorias-financeiras-get-horta)
  - [📗 Categorias-financeiras (POST)](#categorias-financeiras-post)
  - [📗 Categorias-financeiras (PUT)](#categorias-financeiras-put)
  - [📗 Categorias-financeiras (DELETE)](#categorias-financeiras-delete)
  - [📗 Chaves (GET) ](#chaves-get-list)
  - [📗 Chaves (GET por UUID)](#chaves-get-uuid)
  - [📗 Chaves (POST)](#chaves-post)
  - [📗 Chaves (PUT)](#chaves-put)
  - [📗 Chaves (DELETE)](#chaves-delete)
  - [📗 Enderecos (GET) ](#enderecos-get-list)
  - [📗 Enderecos (GET por UUID)](#enderecos-get-uuid)
  - [📗 Enderecos (POST)](#enderecos-post)
  - [📗 Enderecos (PUT)](#enderecos-put)
  - [📗 Enderecos (DELETE)](#enderecos-delete)
  - [📗 Fila-de-usuarios (GET) ](#fila-de-usuarios-get-list)
  - [📗 Fila-de-usuarios (GET por UUID)](#fila-de-usuarios-get-uuid)
  - [📗 Fila-de-usuarios (GET) - Por Horta](#fila-de-usuarios-get-horta)
  - [📗 Fila-de-usuarios (GET) - Por Usuario](#fila-de-usuarios-get-usuario)
  - [📗 Fila-de-usuarios (POST)](#fila-de-usuarios-post)
  - [📗 Fila-de-usuarios (PUT)](#fila-de-usuarios-put)
  - [📗 Fila-de-usuarios (DELETE)](#fila-de-usuarios-delete)
  - [📗 Financeiro da Associação (lançamentos) (GET) ](#financeiro-da-associacao-get-list)
  - [📗 Financeiro da Associação (lançamentos) (GET por UUID)](#financeiro-da-associacao-get-uuid)
  - [📗 Financeiro da Associação (lançamentos) (GET) - Por Associacao](#financeiro-da-associacao-get-associacao)
  - [📗 Financeiro da Associação (lançamentos) (POST)](#financeiro-da-associacao-post)
  - [📗 Financeiro da Associação (lançamentos) (PUT)](#financeiro-da-associacao-put)
  - [📗 Financeiro da Associação (lançamentos) (DELETE)](#financeiro-da-associacao-delete)
  - [📗 Financeiro da horta (lançamentos) (GET) ](#financeiro-da-horta-get-list)
  - [📗 Financeiro da horta (lançamentos) (GET por UUID)](#financeiro-da-horta-get-uuid)
  - [📗 Financeiro da horta (lançamentos) (GET) - Por Horta](#financeiro-da-horta-get-horta)
  - [📗 Financeiro da horta (lançamentos) (POST)](#financeiro-da-horta-post)
  - [📗 Financeiro da horta (lançamentos) (PUT)](#financeiro-da-horta-put)
  - [📗 Financeiro da horta (lançamentos) (DELETE)](#financeiro-da-horta-delete)
  - [📗 Hortas (GET) ](#hortas-get-list)
  - [📗 Hortas (GET por UUID)](#hortas-get-uuid)
  - [📗 Hortas (POST)](#hortas-post)
  - [📗 Hortas (PUT)](#hortas-put)
  - [📗 Hortas (DELETE)](#hortas-delete)
  - [📗 Mensalidades da plataforma (lançamentos) (GET) ](#mensalidades-da-associacao-get-list)
  - [📗 Mensalidades da plataforma (lançamentos) (GET por UUID)](#mensalidades-da-associacao-get-uuid)
  - [📗 Mensalidades da plataforma (lançamentos) (GET) - Por Associacao](#mensalidades-da-associacao-get-associacao)
  - [📗 Mensalidades da plataforma (lançamentos) (GET) - Por Usuario](#mensalidades-da-associacao-get-usuario)
  - [📗 Mensalidades da plataforma (lançamentos) (POST)](#mensalidades-da-associacao-post)
  - [📗 Mensalidades da plataforma (lançamentos) (PUT)](#mensalidades-da-associacao-put)
  - [📗 Mensalidades da plataforma (lançamentos) (DELETE)](#mensalidades-da-associacao-delete)
  - [📗 Mensalidades da associação (lançamentos) (GET) ](#mensalidades-da-plataforma-get-list)
  - [📗 Mensalidades da associação (lançamentos) (GET por UUID)](#mensalidades-da-plataforma-get-uuid)
  - [📗 Mensalidades da associação (lançamentos) (GET) - Por Usuario](#mensalidades-da-plataforma-get-usuario)
  - [📗 Mensalidades da associação (lançamentos) (POST)](#mensalidades-da-plataforma-post)
  - [📗 Mensalidades da associação (lançamentos) (PUT)](#mensalidades-da-plataforma-put)
  - [📗 Mensalidades da associação (lançamentos) (DELETE)](#mensalidades-da-plataforma-delete)
  - [📗 Permissões de cargo (GET) ](#permissoes-de-cargo-get-list)
  - [📗 Permissões de cargo (GET por UUID)](#permissoes-de-cargo-get-uuid)
  - [📗 Permissões de cargo (GET) - Por Cargo](#permissoes-de-cargo-get-cargo)
  - [📗 Permissões de cargo (POST)](#permissoes-de-cargo-post)
  - [📗 Permissões de cargo (PUT)](#permissoes-de-cargo-put)
  - [📗 Permissões de cargo (DELETE)](#permissoes-de-cargo-delete)
  - [📗 Permissões de exceção (GET) ](#permissoes-de-excecao-get-list)
  - [📗 Permissões de exceção (GET por UUID)](#permissoes-de-excecao-get-uuid)
  - [📗 Permissões de exceção (POST)](#permissoes-de-excecao-post)
  - [📗 Permissões de exceção (PUT)](#permissoes-de-excecao-put)
  - [📗 Permissões de exceção (DELETE)](#permissoes-de-excecao-delete)
  - [📗 Permissões do Usuário (GET por Usuário UUID)](#permissoes-do-usuario-get)
  - [📗 Permissões (GET) ](#permissoes-get-list)
  - [📗 Permissões (GET por UUID)](#permissoes-get-uuid)
  - [📗 Permissões (POST)](#permissoes-post)
  - [📗 Permissões (PUT)](#permissoes-put)
  - [📗 Permissões (DELETE)](#permissoes-delete)
  - [📗 Planos (GET) ](#planos-get-list)
  - [📗 Planos (GET por UUID)](#planos-get-uuid)
  - [📗 Planos (GET) - Por Usuario](#planos-get-usuario)
  - [📗 Planos (POST)](#planos-post)
  - [📗 Planos (PUT)](#planos-put)
  - [📗 Planos (DELETE)](#planos-delete)
  - [📗 Recursos do plano (GET) ](#recursos-do-plano-get-list)
  - [📗 Recursos do plano (GET por UUID)](#recursos-do-plano-get-uuid)
  - [📗 Recursos do plano (GET) - Por Plano](#recursos-do-plano-get-plano)
  - [📗 Recursos do plano (POST)](#recursos-do-plano-post)
  - [📗 Recursos do plano (PUT)](#recursos-do-plano-put)
  - [📗 Recursos do plano (DELETE)](#recursos-do-plano-delete)
  - [📗 Usuarios (GET) ](#usuarios-get-list)
  - [📗 Usuarios (GET por UUID)](#usuarios-get-uuid)
  - [📗 Usuarios (POST)](#usuarios-post)
  - [📗 Usuarios (PUT)](#usuarios-put)
  - [📗 Usuarios (DELETE)](#usuarios-delete)


<h1 id="introducao">📗 Introdução</h1>

⚠️ **Importante:** Usamos o Claude Sonnet 4 para revisão e formatação dessa documentação. Qualquer erro aparente é decorrente desse robo maldito que tanto nos auxilia.

Essa documentação compreende as rotas da API REST do projeto. O objetivo é listar todas as rotas, quais inputs e outputs elas tem, e quais as regras de negócio aplicadas nelas que devem ser respeitadas no(s) front-end(s).

<h2 id="inicio-rapido">⏩ Inicio rápido</h2>

Primeiro, siga o tópico [📁 Estrutura do Projeto](https://github.com/thiagohome2/hortas-comunitarias-univille?tab=readme-ov-file#-estrutura-do-projeto) no README.md, nele você fará o setup local da aplicação, incluindo banco de dados com INSERTs iniciais necessários.

Exceto pela rota Sessões (POST), todas as rotas exigem uso do JWT e analisarão as permissões do usuário via validação do JWT informado. O JWT gerado para o login efetuado em Sessões (POST) terá um UUID de usuário e UUID de cargo com todas as permissões, por isso ele é utilizado para testes.

Para gerar o seu JWT pela rota de Sessões (POST) informe o body:

```json
{
    "email": "admin_hortas_comunitarias@univille.br",
    "senha": "senha12345"
}
```

Aqui consideramos o uso do Postman como client de uso, portanto os templates disponíveis são para uso com ele informando o JWT na aba Authorization com tipo Bearer Token.

Em geral, o cabeçalho da requisição deve conter o token JWT no formato Bearer, ou seja: Authorization: Bearer {token}.

<h1 id="permissoes">🔒 Permissões por Cargo</h1>

| Permissão | Administração da Plataforma | Administração da Associação | Administração da Horta | Canteirista | Dependente |
|-----------|----------------------------|----------------------------|-----------------------|------------|-----------|
| `usuarios_ler` | ✅ | ✅ | ✅ |  |  |
| `usuarios_criar` | ✅ | ✅ | ✅ |  |  |
| `usuarios_editar` | ✅ | ✅ | ✅ |  |  |
| `usuarios_deletar` | ✅ | ✅ | ✅ |  |  |
| `associacoes_ler` | ✅ |  |  |  |  |
| `associacoes_criar` | ✅ |  |  |  |  |
| `associacoes_editar` | ✅ |  |  |  |  |
| `associacoes_deletar` | ✅ |  |  |  |  |
| `hortas_ler` | ✅ | ✅ | ✅ |  |  |
| `hortas_criar` | ✅ | ✅ |  |  |  |
| `hortas_editar` | ✅ | ✅ |  |  |  |
| `hortas_deletar` | ✅ | ✅ |  |  |  |
| `enderecos_ler` | ✅ | ✅ | ✅ |  |  |
| `enderecos_criar` | ✅ | ✅ | ✅ |  |  |
| `enderecos_editar` | ✅ | ✅ | ✅ |  |  |
| `enderecos_deletar` | ✅ | ✅ | ✅ |  |  |
| `canteiros_ler` | ✅ | ✅ | ✅ | ✅ | ✅ |
| `canteiros_criar` | ✅ | ✅ | ✅ |  |  |
| `canteiros_editar` | ✅ |✅  | ✅ |  |  |
| `canteiros_deletar` | ✅ |✅  | ✅ |  |  |
| `canteiros_usuarios_ler` | ✅ | ✅ | ✅ | ✅ | ✅ |
| `canteiros_usuarios_criar` | ✅ |✅  | ✅ |  |  |
| `canteiros_usuarios_editar` | ✅ | ✅ | ✅ |  |  |
| `canteiros_usuarios_deletar` | ✅ | ✅ | ✅ |  |  |
| `cargos_ler` | ✅ | ✅ | ✅ |  |  |
| `cargos_criar` | ✅ |  |  |  |  |
| `cargos_editar` | ✅ |  |  |  |  |
| `cargos_deletar` | ✅ |  |  |  |  |
| `permissoes_ler` | ✅ |  |  |  |  |
| `permissoes_criar` | ✅ |  |  |  |  |
| `permissoes_editar` | ✅ |  |  |  |  |
| `permissoes_deletar` | ✅ |  |  |  |  |
| `permissoes_cargo_ler` | ✅ | ✅ |  |  |  |
| `permissoes_cargo_criar` | ✅ |  |  |  |  |
| `permissoes_cargo_editar` | ✅ |  |  |  |  |
| `permissoes_cargo_deletar` | ✅ |  |  |  |  |
| `permissoes_excecao_ler` | ✅ | ✅ |  |  |  |
| `permissoes_excecao_criar` | ✅ | ✅ |  |  |  |
| `permissoes_excecao_editar` | ✅ | ✅ |  |  |  |
| `permissoes_excecao_deletar` | ✅ | ✅ |  |  |  |
| `permissoes_usuario_ler` | ✅ | ✅ | ✅ | ✅ | ✅ |
| `categorias_financeiras_ler` | ✅ | ✅ | ✅ |  |  |
| `categorias_financeiras_criar` | ✅ | ✅ | ✅ |  |  |
| `categorias_financeiras_editar` | ✅ | ✅ | ✅ |  |  |
| `categorias_financeiras_deletar` | ✅ | ✅ | ✅ |  |  |
| `financeiro_horta_ler` | ✅ | ✅ | ✅ | ✅ | ✅ |
| `financeiro_horta_criar` | ✅ | ✅ | ✅ |  |  |
| `financeiro_horta_editar` | ✅ | ✅ | ✅ |  |  |
| `financeiro_horta_deletar` | ✅ | ✅ | ✅ |  |  |
| `financeiro_associacao_ler` | ✅ | ✅ | ✅ | ✅ | ✅ |
| `financeiro_associacao_criar` | ✅ | ✅ | ✅ |  |  |
| `financeiro_associacao_editar` | ✅ | ✅ | ✅ |  |  |
| `financeiro_associacao_deletar` | ✅ | ✅ | ✅ |  |  |
| `mensalidades_associacao_ler` | ✅ | ✅ |  |  |  |
| `mensalidades_associacao_criar` | ✅ |  |  |  |  |
| `mensalidades_associacao_editar` | ✅ |  |  |  |  |
| `mensalidades_associacao_deletar` | ✅ |  |  |  |  |
| `mensalidades_plataforma_ler` | ✅ | ✅ |  |  |  |
| `mensalidades_plataforma_criar` | ✅ |  |  |  |  |
| `mensalidades_plataforma_editar` | ✅ |  |  |  |  |
| `mensalidades_plataforma_deletar` | ✅ |  |  |  |  |
| `planos_ler` | ✅ | ✅ |  |  |  |
| `planos_criar` | ✅ |  |  |  |  |
| `planos_editar` | ✅ |  |  |  |  |
| `planos_deletar` | ✅ |  |  |  |  |
| `recursos_plano_ler` | ✅ |  |  |  |  |
| `recursos_plano_criar` | ✅ |  |  |  |  |
| `recursos_plano_editar` | ✅ |  |  |  |  |
| `recursos_plano_deletar` | ✅ |  |  |  |  |
| `chaves_ler` | ✅ | ✅ | ✅ |  | |
| `chaves_criar` | ✅ | ✅ | ✅ |  |  |
| `chaves_editar` | ✅ | ✅ | ✅ |  |  |
| `chaves_deletar` | ✅ | ✅ | ✅ |  |  |
| `fila_usuarios_ler` | ✅ | ✅ | ✅ | ✅ | ✅ |
| `fila_usuarios_criar` | ✅ |✅  | ✅ |  |  |
| `fila_usuarios_editar` | ✅ | ✅ | ✅ |  |  |
| `fila_usuarios_deletar` | ✅ | ✅ | ✅ |  |  |


<h1 id="rotas">🧭 Rotas</h1>

À seguir, disponibilizamos a lista de rotas da aplicação e a regra de negócio para cada usuário. Aproveite!

<h3 id="login-post">📗 Login (POST)</h3>

Rota pública.

<h3 id="cadastro-post">📗 Cadastro (POST)</h3>

Rota pública.

<h3 id="associacoes-get-list">📗 Associacoes (GET) </h3>

#### Administração da Plataforma
**Acesso:** à todos os registros não excluídos.

<h3 id="associacoes-get-uuid">📗 Associacoes (GET por UUID)</h3>

#### Administração da Plataforma
**Acesso:** à todos os registros não excluídos.

<h3 id="associacoes-post">📗 Associacoes (POST)</h3>

#### Administração da Plataforma
**Acesso:** à todos os registros não excluídos.

<h3 id="associacoes-put">📗 Associacoes (PUT)</h3>

#### Administração da Plataforma
**Acesso:** à todos os registros não excluídos.

<h3 id="associacoes-delete">📗 Associacoes (DELETE)</h3>

#### Administração da Plataforma
**Acesso:** à todos os registros não excluídos.
 
<h3 id="canteiros-e-usuarios-get-list">📗 Canteiros & Usuários (GET)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID
#### Canteirista
  **Acesso:** à todos os registros não excluídos para sua Horta UUID
#### Dependente
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="canteiros-e-usuarios-get-uuid">📗 Canteiros & Usuários (GET  por UUID)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID
#### Canteirista
  **Acesso:** à todos os registros não excluídos para sua Horta UUID
#### Dependente
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="canteiros-e-usuarios-post">📗 Canteiros & Usuários (POST)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="canteiros-e-usuarios-put">📗 Canteiros & Usuários (PUT)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="canteiros-e-usuarios-delete">📗 Canteiros & Usuários (DELETE)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="canteiros-get-list">📗 Canteiros (GET) </h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID
#### Canteirista
  **Acesso:** à todos os registros não excluídos para sua Horta UUID
#### Dependente
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="canteiros-get-uuid">📗 Canteiros (GET por UUID)</h3>
 
#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID
#### Canteirista
  **Acesso:** à todos os registros não excluídos para sua Horta UUID
#### Dependente
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="canteiros-post">📗 Canteiros (POST)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="canteiros-put">📗 Canteiros (PUT)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="canteiros-delete">📗 Canteiros (DELETE)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="cargos-get-list">📗 Cargos (GET) </h3>

#### Administração da Plataforma
**Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos.

<h3 id="cargos-get-uuid">📗 Cargos (GET por UUID)</h3>

#### Administração da Plataforma
**Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos.

<h3 id="cargos-post">📗 Cargos (POST)</h3>

#### Administração da Plataforma
**Acesso:** à todos os registros não excluídos.

<h3 id="cargos-put">📗 Cargos (PUT)</h3>

#### Administração da Plataforma**
Acesso:** à todos os registros não excluídos.

<h3 id="cargos-delete">📗 Cargos (DELETE)</h3>

#### Administração da Plataforma**
Acesso:** à todos os registros não excluídos.

<h3 id="categorias-financeiras-get-list">📗 Categorias financeiras (GET) </h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID, e da sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="categorias-financeiras-get-uuid">📗 Categorias-financeiras (GET por UUID)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID, e da sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="categorias-financeiras-get-associacao">📗 Categorias-financeiras (GET) - Por Associacao</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos da sua Associação UUID.


<h3 id="categorias-financeiras-get-horta">📗 Categorias-financeiras (GET) - Por Horta</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="categorias-financeiras-post">📗 Categorias financeiras (POST)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="categorias-financeiras-put">📗 Categorias financeiras (PUT)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="categorias-financeiras-delete">📗 Categorias financeiras (DELETE)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="chaves-get-list">📗 Chaves (GET) </h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="chaves-get-uuid">📗 Chaves (GET por UUID)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="chaves-post">📗 Chaves (POST)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="chaves-put">📗 Chaves (PUT)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="chaves-delete">📗 Chaves (DELETE)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="enderecos-get-list">📗 Enderecos (GET) </h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="enderecos-get-uuid">📗 Enderecos (GET por UUID)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="enderecos-post">📗 Enderecos (POST)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="enderecos-put">📗 Enderecos (PUT)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="enderecos-delete">📗 Enderecos (DELETE)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="fila-de-usuarios-get-list">📗 Fila de Usuários (GET)</h3>

#### Administração da Plataforma

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID
#### Canteirista
  **Acesso:** à todos os registros não excluídos para sua Horta UUID
#### Dependente
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="fila-de-usuarios-get-uuid">📗 Fila de Usuários (GET por UUID)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID
#### Canteirista
  **Acesso:** à todos os registros não excluídos para sua Horta UUID
#### Dependente
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="fila-de-usuarios-get-horta">📗 Fila de Usuários (GET por Horta UUID)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID
#### Canteirista
  **Acesso:** à todos os registros não excluídos para sua Horta UUID
#### Dependente
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="fila-de-usuarios-get-usuario">📗 Fila de Usuários (GET) - Por Usuario</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID
#### Canteirista
  **Acesso:** à todos os registros não excluídos para sua Horta UUID
#### Dependente
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="fila-de-usuarios-post">📗 Fila de Usuários (POST)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID
#### Canteirista
  **Acesso:** à todos os registros não excluídos para sua Horta UUID
#### Dependente
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="fila-de-usuarios-put">📗 Fila de Usuários (PUT)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID
#### Canteirista
  **Acesso:** à todos os registros não excluídos para sua Horta UUID
#### Dependente
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="fila-de-usuarios-delete">📗 Fila-de-usuarios (DELETE)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID
#### Canteirista
  **Acesso:** à todos os registros não excluídos para sua Horta UUID
#### Dependente
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="financeiro-da-associacao-get-list">📗 Financeiro da Associação (lançamentos) (GET) </h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos de sua Associação UUID
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos de sua Associação UUID
#### Canteirista
  **Acesso:** à todos os registros não excluídos de sua Associação UUID
#### Dependente
  **Acesso:** à todos os registros não excluídos de sua Associação UUID

<h3 id="financeiro-da-associacao-get-uuid">📗 Financeiro da Associação (lançamentos) (GET por UUID)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos de sua Associação UUID
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos de sua Associação UUID
#### Canteirista
  **Acesso:** à todos os registros não excluídos de sua Associação UUID
#### Dependente
  **Acesso:** à todos os registros não excluídos de sua Associação UUID

<h3 id="financeiro-da-associacao-get-associacao">📗 Financeiro da Associação (lançamentos) (GET) - Por Associacao</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="financeiro-da-associacao-post">📗 Financeiro da Associação (lançamentos) (POST)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="financeiro-da-associacao-put">📗 Financeiro da Associação (lançamentos) (PUT)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="financeiro-da-associacao-delete">📗 Financeiro da Associação (lançamentos) (DELETE)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="financeiro-da-horta-get-list">📗 Financeiro da horta (lançamentos) (GET) </h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID de sua Associação UUID
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID
#### Canteirista
  **Acesso:** à todos os registros não excluídos para sua Horta UUID
#### Dependente
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="financeiro-da-horta-get-uuid">📗 Financeiro da horta (lançamentos) (GET por UUID)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID de sua Associação UUID
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID
#### Canteirista
  **Acesso:** à todos os registros não excluídos para sua Horta UUID
#### Dependente
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="financeiro-da-horta-get-horta">📗 Financeiro da horta (lançamentos) (GET) - Por Horta</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID de sua Associação UUID
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID
#### Canteirista
  **Acesso:** à todos os registros não excluídos para sua Horta UUID
#### Dependente
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="financeiro-da-horta-post">📗 Financeiro da horta (lançamentos) (POST)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="financeiro-da-horta-put">📗 Financeiro da horta (lançamentos) (PUT)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="financeiro-da-horta-delete">📗 Financeiro da horta (lançamentos) (DELETE)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="hortas-get-list">📗 Hortas (GET) </h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="hortas-get-uuid">📗 Hortas (GET por UUID)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="hortas-post">📗 Hortas (POST)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="hortas-put">📗 Hortas (PUT)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="hortas-delete">📗 Hortas (DELETE)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para Hortas UUID atreladas a sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos para sua Horta UUID

<h3 id="mensalidades-da-associacao-get-list">📗 Mensalidades da Associação (GET)</h3>

#### Administração da Plataforma
**Acesso:** todos os registros não excluídos.

#### Administração da Associação
**Acesso:** todos os registros não excluídos da sua Associação UUID.

#### Administração da Horta
**Acesso:** todos os registros não excluídos de usuários com a sua Horta UUID.

#### Canteirista / Dependente
**Acesso:** apenas os registros não excluídos do próprio usuário.

---

<h3 id="mensalidades-da-associacao-get-uuid">📗 Mensalidades da Associação (GET por UUID)</h3>

#### Administração da Plataforma
**Acesso:** qualquer registro não excluído.

#### Administração da Associação
**Acesso:** apenas registros da sua Associação UUID.

#### Administração da Horta
**Acesso:** apenas registros de usuários com a sua Horta UUID.

#### Canteirista / Dependente
**Acesso:** apenas registros do próprio usuário.

---

<h3 id="mensalidades-da-associacao-get-associacao">📗 Mensalidades da Associação (GET por Associação UUID)</h3>

#### Administração da Plataforma
**Acesso:** todos os registros da associação solicitada.

#### Administração da Associação
**Acesso:** todos os registros apenas se for da sua própria Associação UUID.

#### Administração da Horta
**Acesso:** registros filtrados apenas de usuários com a sua Horta UUID (dentro da sua Associação).

#### Canteirista / Dependente
**Acesso:** registros filtrados apenas do próprio usuário dentro da associação solicitada.

---

<h3 id="mensalidades-da-associacao-get-usuario">📗 Mensalidades da Associação (GET por Usuário UUID)</h3>

#### Administração da Plataforma
**Acesso:** todos os registros do usuário solicitado.

#### Administração da Associação
**Acesso:** todos os registros do usuário, apenas se ele pertencer à sua Associação UUID.

#### Administração da Horta
**Acesso:** todos os registros do usuário, apenas se ele pertencer à sua Horta UUID.

#### Canteirista / Dependente
**Acesso:** apenas os próprios registros (se o UUID solicitado for o próprio).

---

<h3 id="mensalidades-da-associacao-post">📗 Mensalidades da Associação (POST)</h3>

#### Administração da Plataforma
**Permissão:** pode criar mensalidades para qualquer associação e usuário.

#### Administração da Associação
**Permissão:** pode criar mensalidades apenas para a sua própria Associação UUID.

#### Outros Cargos
**Permissão:** negada.

---

<h3 id="mensalidades-da-associacao-put">📗 Mensalidades da Associação (PUT)</h3>

#### Administração da Plataforma
**Permissão:** pode editar qualquer mensalidade.

#### Administração da Associação
**Permissão:** pode editar mensalidades apenas da sua própria Associação UUID.

#### Outros Cargos
**Permissão:** negada.

---

<h3 id="mensalidades-da-associacao-delete">📗 Mensalidades da Associação (DELETE)</h3>

#### Administração da Plataforma
**Permissão:** pode deletar qualquer mensalidade.

#### Administração da Associação
**Permissão:** pode deletar mensalidades apenas da sua própria Associação UUID.

#### Outros Cargos
**Permissão:** negada.

---

<h3 id="mensalidades-da-plataforma-get-list">📗 Mensalidades da Plataforma (GET)</h3>

#### Administração da Plataforma
**Acesso:** todos os registros não excluídos.

#### Administração da Associação
**Acesso:** todos os registros não excluídos de usuários atrelados à sua Associação UUID.

---

<h3 id="mensalidades-da-plataforma-get-uuid">📗 Mensalidades da Plataforma (GET por UUID)</h3>

#### Administração da Plataforma
**Acesso:** qualquer registro não excluído.

#### Administração da Associação
**Acesso:** apenas registros de usuários atrelados à sua Associação UUID.

---

<h3 id="mensalidades-da-plataforma-get-usuario">📗 Mensalidades da Plataforma (GET por Usuário UUID)</h3>

#### Administração da Plataforma
**Acesso:** todos os registros do usuário solicitado.

#### Outros Cargos
**Permissão:** negada.

---

<h3 id="mensalidades-da-plataforma-post">📗 Mensalidades da Plataforma (POST)</h3>

#### Administração da Plataforma
**Permissão:** pode criar mensalidades para qualquer usuário.

#### NEW_ACCOUNT (Cadastro Especial)
**Permissão:** pode criar mensalidade durante o processo de cadastro.

#### Outros Cargos
**Permissão:** negada.

---

<h3 id="mensalidades-da-plataforma-put">📗 Mensalidades da Plataforma (PUT)</h3>

#### Administração da Plataforma
**Permissão:** pode editar qualquer mensalidade.

#### Outros Cargos
**Permissão:** negada.

---

<h3 id="mensalidades-da-plataforma-delete">📗 Mensalidades da Plataforma (DELETE)</h3>

#### Administração da Plataforma
**Permissão:** pode deletar qualquer mensalidade.

#### Outros Cargos
**Permissão:** negada.

<h3 id="permissoes-de-cargo-get-list">📗 Permissões de cargo (GET) </h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="permissoes-de-cargo-get-uuid">📗 Permissões de cargo (GET por UUID)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="permissoes-de-cargo-get-cargo">📗 Permissões de cargo (GET) - Por Cargo</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="permissoes-de-cargo-post">📗 Permissões de cargo (POST)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="permissoes-de-cargo-put">📗 Permissões de cargo (PUT)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="permissoes-de-cargo-delete">📗 Permissões de cargo (DELETE)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="permissoes-de-excecao-get-list">📗 Permissões de exceção (GET) </h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="permissoes-de-excecao-get-uuid">📗 Permissões de exceção (GET por UUID)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="permissoes-de-excecao-post">📗 Permissões de exceção (POST)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="permissoes-de-excecao-put">📗 Permissões de exceção (PUT)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="permissoes-de-excecao-delete">📗 Permissões de exceção (DELETE)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="permissoes-do-usuario-get">📗 Permissões do Usuário (GET por Usuário UUID)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros para seu próprio UUID
#### Administração da Horta
  **Acesso:** à todos os registros para seu próprio UUID
#### Canteirista
  **Acesso:** à todos os registros para seu próprio UUID
#### Dependente
  **Acesso:** à todos os registros para seu próprio UUID

<h3 id="permissoes-get-list">📗 Permissões (GET) </h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="permissoes-get-uuid">📗 Permissões (GET por UUID)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="permissoes-post">📗 Permissões (POST)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="permissoes-put">📗 Permissões (PUT)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="permissoes-delete">📗 Permissões (DELETE)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="planos-get-list">📗 Planos (GET) </h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="planos-get-uuid">📗 Planos (GET por UUID)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="planos-get-usuario">📗 Planos (GET) - Por Usuario</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="planos-post">📗 Planos (POST)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="planos-put">📗 Planos (PUT)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="planos-delete">📗 Planos (DELETE)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="recursos-do-plano-get-list">📗 Recursos do plano (GET) </h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="recursos-do-plano-get-uuid">📗 Recursos do plano (GET por UUID)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="recursos-do-plano-get-plano">📗 Recursos do plano (GET) - Por Plano</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="recursos-do-plano-post">📗 Recursos do plano (POST)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="recursos-do-plano-put">📗 Recursos do plano (PUT)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="recursos-do-plano-delete">📗 Recursos do plano (DELETE)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.

<h3 id="usuarios-get-list">📗 Usuarios (GET) </h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos atrelados a sua Horta UUID 

<h3 id="usuarios-get-uuid">📗 Usuarios (GET por UUID)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos atrelados a sua Horta UUID 

<h3 id="usuarios-post">📗 Usuarios (POST)</h3> ✅

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos atrelados a sua Horta UUID 

<h3 id="usuarios-put">📗 Usuarios (PUT)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos atrelados a sua Horta UUID 

<h3 id="usuarios-delete">📗 Usuarios (DELETE)</h3>

#### Administração da Plataforma
  **Acesso:** à todos os registros não excluídos.
#### Administração da Associação
  **Acesso:** à todos os registros não excluídos para sua Associação UUID.
#### Administração da Horta
  **Acesso:** à todos os registros não excluídos atrelados a sua Horta UUID 


<h1 id="fluxos">🪴 Fluxos</h1>

<h1 id="fluxos">🪴 Fluxo de Cadastro</h1>

-> Cria uma Associação
-> Cria um Usuário que terá por padrão cargo Adminstrador da Plataforma

--> Demais dados devem ser preenchidos depois

<h1 id="dados-teste">🎲 Dados teste</h1>

## 🌱 Associações

* **Hortas SP**

  * Razão Social: Associação Hortas Urbanas 1
  * CNPJ: 11.111.111/0001-11
  * Endereço: São Paulo - SP

* **Hortas RJ**

  * Razão Social: Associação Hortas Urbanas 2
  * CNPJ: 22.222.222/0001-22
  * Endereço: Rio de Janeiro - RJ

---

## 🥕 Hortas

* **Horta Comunitária SP**

  * Associação vinculada: Hortas SP
  * Percentual taxa associado: 10%

* **Horta Comunitária RJ**

  * Associação vinculada: Hortas RJ
  * Percentual taxa associado: 12.5%

---

## 👥 Usuários

| Usuário                | Cargo                  | Email                                                         | Senha      |
| ---------------------- | ---------------------- | ------------------------------------------------------------- | ---------- |
| Carlos Admin SP        | admin_associacao_geral | [admin_assoc_1@example.com](mailto:admin_assoc_1@example.com) | senha12345 |
| Mariana Admin RJ       | admin_associacao_geral | [admin_assoc_2@example.com](mailto:admin_assoc_2@example.com) | senha12345 |
| João Horta SP          | admin_horta_geral      | [admin_horta_1@example.com](mailto:admin_horta_1@example.com) | senha12345 |
| Ana Horta RJ           | admin_horta_geral      | [admin_horta_2@example.com](mailto:admin_horta_2@example.com) | senha12345 |
| Pedro Canteiro SP      | canteirista            | [canteirista_1@example.com](mailto:canteirista_1@example.com) | senha12345 |
| Julia Canteiro RJ      | canteirista            | [canteirista_2@example.com](mailto:canteirista_2@example.com) | senha12345 |
| Lucas Dependente SP    | dependente             | [dependente_1@example.com](mailto:dependente_1@example.com)   | senha12345 |
| Fernanda Dependente RJ | dependente             | [dependente_2@example.com](mailto:dependente_2@example.com)   | senha12345 |


<h1 id="pendencias">⚠️ Pendências: Aplicação de regras de negócio nos endpoints</h1> 

## 🔴 Rotas EXCLUSIVAS - Administração da Plataforma

### Associações
- [x] Associações (GET)
- [x] Associações (GET por UUID)
- [x] Associações (POST)
- [x] Associações (PUT)
- [x] Associações (DELETE)

### Permissões
- [x] Permissões (GET)
- [x] Permissões (GET por UUID)
- [x] Permissões (POST)
- [x] Permissões (PUT)
- [x] Permissões (DELETE)

### Permissões de Cargo
- [x] Permissões de Cargo (GET)
- [x] Permissões de Cargo (GET por UUID)
- [x] Permissões de Cargo (GET) - Por Cargo
- [x] Permissões de Cargo (POST)
- [x] Permissões de Cargo (PUT)
- [x] Permissões de Cargo (DELETE)

### Permissões de Exceção
- [x] Permissões de Exceção (GET)
- [x] Permissões de Exceção (GET por UUID)
- [x] Permissões de Exceção (POST)
- [x] Permissões de Exceção (PUT)
- [x] Permissões de Exceção (DELETE)

### Permissões do Usuário
- [x] Permissões do Usuário (GET)

### Cargos (Modificação)
- [x] Cargos (POST)
- [x] Cargos (PUT)
- [x] Cargos (DELETE)

### Planos
- [x] Planos (GET)
- [x] Planos (GET por UUID)
- [x] Planos (GET) - Por Usuário
- [x] Planos (POST)
- [x] Planos (PUT)
- [x] Planos (DELETE)

### Recursos do Plano
- [x] Recursos do Plano (GET)
- [x] Recursos do Plano (GET por UUID)
- [x] Recursos do Plano (GET) - Por Plano
- [x] Recursos do Plano (POST)
- [x] Recursos do Plano (PUT)
- [x] Recursos do Plano (DELETE)

### Mensalidades da Plataforma (Modificação)
- [x] Mensalidades da Plataforma (GET por Associação UUID)
- [x] Mensalidades da Plataforma (GET por Usuário UUID)
- [x] Mensalidades da Plataforma (POST)
- [x] Mensalidades da Plataforma (PUT)
- [x] Mensalidades da Plataforma (DELETE)

## 🟡 Rotas COMPARTILHADAS - Plataforma + Associação

### Financeiro da Associação (Modificação) 
- [x] Financeiro da Associação (POST)
- [x] Financeiro da Associação (PUT)
- [x] Financeiro da Associação (DELETE)

### Mensalidades da Plataforma (Leitura)
- [x] Mensalidades da Plataforma (GET)
- [x] Mensalidades da Plataforma (GET por UUID)

### Mensalidades da Associação (Modificação)
- [x] Mensalidades da Associação (POST)
- [x] Mensalidades da Associação (PUT)
- [x] Mensalidades da Associação (DELETE)


## 🟢 Rotas COMPARTILHADAS - Plataforma + Associação + Horta

### Cargos (Leitura)
- [x] Cargos (GET)
- [x] Cargos (GET por UUID)

### Usuários
- [x] Usuários (GET)
- [x] Usuários (GET por UUID)
- [x] Usuários (POST)
- [x] Usuários (PUT)
- [x] Usuários (DELETE)

### Hortas 
- [x] Hortas (POST)
- [x] Hortas (PUT)
- [x] Hortas (DELETE)

### Endereços
- [x] Endereços (POST)
- [x] Endereços (PUT)
- [x] Endereços (DELETE)

### Categorias Financeiras
- [ ] Categorias Financeiras (GET)
- [ ] Categorias Financeiras (GET por UUID)
- [ ] Categorias Financeiras (GET) - Por Associação
- [ ] Categorias Financeiras (GET) - Por Horta
- [ ] Categorias Financeiras (POST)
- [ ] Categorias Financeiras (PUT)
- [ ] Categorias Financeiras (DELETE)

### Chaves
- [ ] Chaves (GET)
- [ ] Chaves (GET por UUID)
- [ ] Chaves (POST)
- [ ] Chaves (PUT)
- [ ] Chaves (DELETE)

### Canteiros & Usuários (Modificação)
- [ ] Canteiros & Usuários (POST)
- [ ] Canteiros & Usuários (PUT)
- [ ] Canteiros & Usuários (DELETE)

### Canteiros (Modificação)
- [ ] Canteiros (POST)
- [ ] Canteiros (PUT)
- [ ] Canteiros (DELETE)

### Fila de Usuários (Modificação)
- [ ] Fila de Usuários (POST)
- [ ] Fila de Usuários (PUT)
- [ ] Fila de Usuários (DELETE)

### Financeiro da Horta (Modificação)
- [ ] Financeiro da Horta (POST)
- [ ] Financeiro da Horta (PUT)
- [ ] Financeiro da Horta (DELETE)

## 🔵 Rotas COMPARTILHADAS - Todos (Plataforma + Associação + Horta + Canteirista + Dependente)

### Mensalidades da Associação (Leitura)
- [x] Mensalidades da Associação (GET)
- [x] Mensalidades da Associação (GET por UUID)
- [x] Mensalidades da Associação (GET) - Por Usuário

### Financeiro da Associação (Modificação)
- [x] Financeiro da Associação (GET) 
- [x] Financeiro da Associação (GET por Associação UUID) 

### Canteiros & Usuários (Leitura)
- [ ] Canteiros & Usuários (GET)
- [ ] Canteiros & Usuários (GET por UUID)

### Canteiros (Leitura)
- [ ] Canteiros (GET)
- [ ] Canteiros (GET por UUID)

## Endereços
- [x] Endereços (GET)
- [x] Endereços (GET por UUID)

### Fila de Usuários (Leitura)
- [ ] Fila de Usuários (GET)
- [ ] Fila de Usuários (GET por UUID)
- [ ] Fila de Usuários (GET por Horta UUID)
- [ ] Fila de Usuários (GET) - Por Usuário

### Financeiro da Associação (Leitura)
- [x] Financeiro da Associação (GET)
- [x] Financeiro da Associação (GET por UUID)

### Financeiro da Horta (Leitura)
- [ ] Financeiro da Horta (GET)
- [ ] Financeiro da Horta (GET por UUID)
- [ ] Financeiro da Horta (GET) - Por Horta

### Hortas
- [x] Hortas (GET)
- [x] Hortas (GET por UUID)

## ⚪ Rotas PÚBLICAS
- [x] Login (POST)
- [x] Cadastro (POST)

---

**Total: 111 rotas**
**Progresso: 65%** 