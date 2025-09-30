# 🥑 API REST + Regras de Negócio | Documentação

## 📑 Sumário
- [📗 Introdução](#introducao)
- [⏩ Início Rápido](#inicio-rapido)
- [🔒 Permissões por Cargo](#permissoes)
- [🧭 Rotas ](#rotas)
  - [📗 Associacoes (GET) - Lista](#associacoes-get-list)
  - [📗 Associacoes (GET) - Por UUID](#associacoes-get-uuid)
  - [📗 Associacoes (POST)](#associacoes-post)
  - [📗 Associacoes (PUT)](#associacoes-put)
  - [📗 Associacoes (DELETE)](#associacoes-delete)
  - [📗 Canteiros-e-usuarios (GET) - Lista](#canteiros-e-usuarios-get-list)
  - [📗 Canteiros-e-usuarios (GET) - Por UUID](#canteiros-e-usuarios-get-uuid)
  - [📗 Canteiros-e-usuarios (POST)](#canteiros-e-usuarios-post)
  - [📗 Canteiros-e-usuarios (PUT)](#canteiros-e-usuarios-put)
  - [📗 Canteiros-e-usuarios (DELETE)](#canteiros-e-usuarios-delete)
  - [📗 Canteiros (GET) - Lista](#canteiros-get-list)
  - [📗 Canteiros (GET) - Por UUID](#canteiros-get-uuid)
  - [📗 Canteiros (POST)](#canteiros-post)
  - [📗 Canteiros (PUT)](#canteiros-put)
  - [📗 Canteiros (DELETE)](#canteiros-delete)
  - [📗 Cargos (GET) - Lista](#cargos-get-list)
  - [📗 Cargos (GET) - Por UUID](#cargos-get-uuid)
  - [📗 Cargos (POST)](#cargos-post)
  - [📗 Cargos (PUT)](#cargos-put)
  - [📗 Cargos (DELETE)](#cargos-delete)
  - [📗 Categorias-financeiras (GET) - Lista](#categorias-financeiras-get-list)
  - [📗 Categorias-financeiras (GET) - Por UUID](#categorias-financeiras-get-uuid)
  - [📗 Categorias-financeiras (GET) - Por Associacao](#categorias-financeiras-get-associacao)
  - [📗 Categorias-financeiras (GET) - Por Horta](#categorias-financeiras-get-horta)
  - [📗 Categorias-financeiras (POST)](#categorias-financeiras-post)
  - [📗 Categorias-financeiras (PUT)](#categorias-financeiras-put)
  - [📗 Categorias-financeiras (DELETE)](#categorias-financeiras-delete)
  - [📗 Chaves (GET) - Lista](#chaves-get-list)
  - [📗 Chaves (GET) - Por UUID](#chaves-get-uuid)
  - [📗 Chaves (POST)](#chaves-post)
  - [📗 Chaves (PUT)](#chaves-put)
  - [📗 Chaves (DELETE)](#chaves-delete)
  - [📗 Enderecos (GET) - Lista](#enderecos-get-list)
  - [📗 Enderecos (GET) - Por UUID](#enderecos-get-uuid)
  - [📗 Enderecos (POST)](#enderecos-post)
  - [📗 Enderecos (PUT)](#enderecos-put)
  - [📗 Enderecos (DELETE)](#enderecos-delete)
  - [📗 Fila-de-usuarios (GET) - Lista](#fila-de-usuarios-get-list)
  - [📗 Fila-de-usuarios (GET) - Por UUID](#fila-de-usuarios-get-uuid)
  - [📗 Fila-de-usuarios (GET) - Por Horta](#fila-de-usuarios-get-horta)
  - [📗 Fila-de-usuarios (GET) - Por Usuario](#fila-de-usuarios-get-usuario)
  - [📗 Fila-de-usuarios (POST)](#fila-de-usuarios-post)
  - [📗 Fila-de-usuarios (PUT)](#fila-de-usuarios-put)
  - [📗 Fila-de-usuarios (DELETE)](#fila-de-usuarios-delete)
  - [📗 Financeiro-da-associacao (GET) - Lista](#financeiro-da-associacao-get-list)
  - [📗 Financeiro-da-associacao (GET) - Por UUID](#financeiro-da-associacao-get-uuid)
  - [📗 Financeiro-da-associacao (GET) - Por Associacao](#financeiro-da-associacao-get-associacao)
  - [📗 Financeiro-da-associacao (POST)](#financeiro-da-associacao-post)
  - [📗 Financeiro-da-associacao (PUT)](#financeiro-da-associacao-put)
  - [📗 Financeiro-da-associacao (DELETE)](#financeiro-da-associacao-delete)
  - [📗 Financeiro-da-horta (GET) - Lista](#financeiro-da-horta-get-list)
  - [📗 Financeiro-da-horta (GET) - Por UUID](#financeiro-da-horta-get-uuid)
  - [📗 Financeiro-da-horta (GET) - Por Horta](#financeiro-da-horta-get-horta)
  - [📗 Financeiro-da-horta (POST)](#financeiro-da-horta-post)
  - [📗 Financeiro-da-horta (PUT)](#financeiro-da-horta-put)
  - [📗 Financeiro-da-horta (DELETE)](#financeiro-da-horta-delete)
  - [📗 Hortas (GET) - Lista](#hortas-get-list)
  - [📗 Hortas (GET) - Por UUID](#hortas-get-uuid)
  - [📗 Hortas (POST)](#hortas-post)
  - [📗 Hortas (PUT)](#hortas-put)
  - [📗 Hortas (DELETE)](#hortas-delete)
  - [📗 Mensalidades-da-associacao (GET) - Lista](#mensalidades-da-associacao-get-list)
  - [📗 Mensalidades-da-associacao (GET) - Por UUID](#mensalidades-da-associacao-get-uuid)
  - [📗 Mensalidades-da-associacao (GET) - Por Associacao](#mensalidades-da-associacao-get-associacao)
  - [📗 Mensalidades-da-associacao (GET) - Por Usuario](#mensalidades-da-associacao-get-usuario)
  - [📗 Mensalidades-da-associacao (POST)](#mensalidades-da-associacao-post)
  - [📗 Mensalidades-da-associacao (PUT)](#mensalidades-da-associacao-put)
  - [📗 Mensalidades-da-associacao (DELETE)](#mensalidades-da-associacao-delete)
  - [📗 Mensalidades-da-plataforma (GET) - Lista](#mensalidades-da-plataforma-get-list)
  - [📗 Mensalidades-da-plataforma (GET) - Por UUID](#mensalidades-da-plataforma-get-uuid)
  - [📗 Mensalidades-da-plataforma (GET) - Por Usuario](#mensalidades-da-plataforma-get-usuario)
  - [📗 Mensalidades-da-plataforma (POST)](#mensalidades-da-plataforma-post)
  - [📗 Mensalidades-da-plataforma (PUT)](#mensalidades-da-plataforma-put)
  - [📗 Mensalidades-da-plataforma (DELETE)](#mensalidades-da-plataforma-delete)
  - [📗 Permissoes-de-cargo (GET) - Lista](#permissoes-de-cargo-get-list)
  - [📗 Permissoes-de-cargo (GET) - Por UUID](#permissoes-de-cargo-get-uuid)
  - [📗 Permissoes-de-cargo (GET) - Por Cargo](#permissoes-de-cargo-get-cargo)
  - [📗 Permissoes-de-cargo (POST)](#permissoes-de-cargo-post)
  - [📗 Permissoes-de-cargo (PUT)](#permissoes-de-cargo-put)
  - [📗 Permissoes-de-cargo (DELETE)](#permissoes-de-cargo-delete)
  - [📗 Permissoes-de-excecao (GET) - Lista](#permissoes-de-excecao-get-list)
  - [📗 Permissoes-de-excecao (GET) - Por UUID](#permissoes-de-excecao-get-uuid)
  - [📗 Permissoes-de-excecao (POST)](#permissoes-de-excecao-post)
  - [📗 Permissoes-de-excecao (PUT)](#permissoes-de-excecao-put)
  - [📗 Permissoes-de-excecao (DELETE)](#permissoes-de-excecao-delete)
  - [📗 Permissoes-do-usuario (GET)](#permissoes-do-usuario-get)
  - [📗 Permissoes (GET) - Lista](#permissoes-get-list)
  - [📗 Permissoes (GET) - Por UUID](#permissoes-get-uuid)
  - [📗 Permissoes (POST)](#permissoes-post)
  - [📗 Permissoes (PUT)](#permissoes-put)
  - [📗 Permissoes (DELETE)](#permissoes-delete)
  - [📗 Planos (GET) - Lista](#planos-get-list)
  - [📗 Planos (GET) - Por UUID](#planos-get-uuid)
  - [📗 Planos (GET) - Por Usuario](#planos-get-usuario)
  - [📗 Planos (POST)](#planos-post)
  - [📗 Planos (PUT)](#planos-put)
  - [📗 Planos (DELETE)](#planos-delete)
  - [📗 Recursos-do-plano (GET) - Lista](#recursos-do-plano-get-list)
  - [📗 Recursos-do-plano (GET) - Por UUID](#recursos-do-plano-get-uuid)
  - [📗 Recursos-do-plano (GET) - Por Plano](#recursos-do-plano-get-plano)
  - [📗 Recursos-do-plano (POST)](#recursos-do-plano-post)
  - [📗 Recursos-do-plano (PUT)](#recursos-do-plano-put)
  - [📗 Recursos-do-plano (DELETE)](#recursos-do-plano-delete)
  - [📗 Sessoes (POST)](#sessoes-post)
  - [📗 Usuarios (GET) - Lista](#usuarios-get-list)
  - [📗 Usuarios (GET) - Por UUID](#usuarios-get-uuid)
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
| `enderecos_ler` | ✅ | ✅ |  |  |  |
| `enderecos_criar` | ✅ | ✅ |  |  |  |
| `enderecos_editar` | ✅ | ✅ |  |  |  |
| `enderecos_deletar` | ✅ | ✅ |  |  |  |
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
| `chaves_ler` | ✅ | ✅ | ✅ | ✅ |✅ |
| `chaves_criar` | ✅ | ✅ | ✅ |  |  |
| `chaves_editar` | ✅ | ✅ | ✅ |  |  |
| `chaves_deletar` | ✅ | ✅ | ✅ |  |  |
| `fila_usuarios_ler` | ✅ | ✅ | ✅ | ✅ | ✅ |
| `fila_usuarios_criar` | ✅ |✅  | ✅ |  |  |
| `fila_usuarios_editar` | ✅ | ✅ | ✅ |  |  |
| `fila_usuarios_deletar` | ✅ | ✅ | ✅ |  |  |


<h1 id="rotas">🧭 Rotas</h1>

À seguir, disponibilizamos a lista de rotas da aplicação e a regra de negócio para cada usuário. Aproveite!

<h3 id="associacoes-get-list">📗 Associacoes (GET) - Lista</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.

<h3 id="associacoes-get-uuid">📗 Associacoes (GET) - Por UUID</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.

<h3 id="associacoes-post">📗 Associacoes (POST)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.

<h3 id="associacoes-put">📗 Associacoes (PUT)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.

<h3 id="associacoes-delete">📗 Associacoes (DELETE)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.

<h3 id="canteiros-e-usuarios-get-list">📗 Canteiros & Usuários (GET)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.

#### Administração da Associação

Vê todos os registros não excluídos para Horta UUID atrelado a sua Associação UUID.

#### Administração da Horta

#### Canteirista
#### Dependente

<h3 id="canteiros-e-usuarios-get-uuid">📗 Canteiros & Usuários (GET por UUID)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="canteiros-e-usuarios-post">📗 Canteiros-e-usuarios (POST)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="canteiros-e-usuarios-put">📗 Canteiros-e-usuarios (PUT)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="canteiros-e-usuarios-delete">📗 Canteiros-e-usuarios (DELETE)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="canteiros-get-list">📗 Canteiros (GET) - Lista</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="canteiros-get-uuid">📗 Canteiros (GET) - Por UUID</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="canteiros-post">📗 Canteiros (POST)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="canteiros-put">📗 Canteiros (PUT)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="canteiros-delete">📗 Canteiros (DELETE)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="cargos-get-list">📗 Cargos (GET) - Lista</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="cargos-get-uuid">📗 Cargos (GET) - Por UUID</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="cargos-post">📗 Cargos (POST)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="cargos-put">📗 Cargos (PUT)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="cargos-delete">📗 Cargos (DELETE)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="categorias-financeiras-get-list">📗 Categorias-financeiras (GET) - Lista</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="categorias-financeiras-get-uuid">📗 Categorias-financeiras (GET) - Por UUID</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="categorias-financeiras-get-associacao">📗 Categorias-financeiras (GET) - Por Associacao</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="categorias-financeiras-get-horta">📗 Categorias-financeiras (GET) - Por Horta</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="categorias-financeiras-post">📗 Categorias-financeiras (POST)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="categorias-financeiras-put">📗 Categorias-financeiras (PUT)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="categorias-financeiras-delete">📗 Categorias-financeiras (DELETE)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="chaves-get-list">📗 Chaves (GET) - Lista</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="chaves-get-uuid">📗 Chaves (GET) - Por UUID</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="chaves-post">📗 Chaves (POST)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="chaves-put">📗 Chaves (PUT)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="chaves-delete">📗 Chaves (DELETE)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="enderecos-get-list">📗 Enderecos (GET) - Lista</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="enderecos-get-uuid">📗 Enderecos (GET) - Por UUID</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="enderecos-post">📗 Enderecos (POST)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="enderecos-put">📗 Enderecos (PUT)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="enderecos-delete">📗 Enderecos (DELETE)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="fila-de-usuarios-get-list">📗 Fila-de-usuarios (GET) - Lista</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="fila-de-usuarios-get-uuid">📗 Fila-de-usuarios (GET) - Por UUID</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="fila-de-usuarios-get-horta">📗 Fila-de-usuarios (GET) - Por Horta</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="fila-de-usuarios-get-usuario">📗 Fila-de-usuarios (GET) - Por Usuario</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="fila-de-usuarios-post">📗 Fila-de-usuarios (POST)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="fila-de-usuarios-put">📗 Fila-de-usuarios (PUT)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="fila-de-usuarios-delete">📗 Fila-de-usuarios (DELETE)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="financeiro-da-associacao-get-list">📗 Financeiro-da-associacao (GET) - Lista</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="financeiro-da-associacao-get-uuid">📗 Financeiro-da-associacao (GET) - Por UUID</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="financeiro-da-associacao-get-associacao">📗 Financeiro-da-associacao (GET) - Por Associacao</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="financeiro-da-associacao-post">📗 Financeiro-da-associacao (POST)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="financeiro-da-associacao-put">📗 Financeiro-da-associacao (PUT)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="financeiro-da-associacao-delete">📗 Financeiro-da-associacao (DELETE)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="financeiro-da-horta-get-list">📗 Financeiro-da-horta (GET) - Lista</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="financeiro-da-horta-get-uuid">📗 Financeiro-da-horta (GET) - Por UUID</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="financeiro-da-horta-get-horta">📗 Financeiro-da-horta (GET) - Por Horta</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="financeiro-da-horta-post">📗 Financeiro-da-horta (POST)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="financeiro-da-horta-put">📗 Financeiro-da-horta (PUT)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="financeiro-da-horta-delete">📗 Financeiro-da-horta (DELETE)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="hortas-get-list">📗 Hortas (GET) - Lista</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="hortas-get-uuid">📗 Hortas (GET) - Por UUID</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="hortas-post">📗 Hortas (POST)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="hortas-put">📗 Hortas (PUT)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="hortas-delete">📗 Hortas (DELETE)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="mensalidades-da-associacao-get-list">📗 Mensalidades-da-associacao (GET) - Lista</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="mensalidades-da-associacao-get-uuid">📗 Mensalidades-da-associacao (GET) - Por UUID</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="mensalidades-da-associacao-get-associacao">📗 Mensalidades-da-associacao (GET) - Por Associacao</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="mensalidades-da-associacao-get-usuario">📗 Mensalidades-da-associacao (GET) - Por Usuario</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="mensalidades-da-associacao-post">📗 Mensalidades-da-associacao (POST)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="mensalidades-da-associacao-put">📗 Mensalidades-da-associacao (PUT)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="mensalidades-da-associacao-delete">📗 Mensalidades-da-associacao (DELETE)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="mensalidades-da-plataforma-get-list">📗 Mensalidades-da-plataforma (GET) - Lista</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="mensalidades-da-plataforma-get-uuid">📗 Mensalidades-da-plataforma (GET) - Por UUID</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="mensalidades-da-plataforma-get-usuario">📗 Mensalidades-da-plataforma (GET) - Por Usuario</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="mensalidades-da-plataforma-post">📗 Mensalidades-da-plataforma (POST)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="mensalidades-da-plataforma-put">📗 Mensalidades-da-plataforma (PUT)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="mensalidades-da-plataforma-delete">📗 Mensalidades-da-plataforma (DELETE)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="permissoes-de-cargo-get-list">📗 Permissoes-de-cargo (GET) - Lista</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="permissoes-de-cargo-get-uuid">📗 Permissoes-de-cargo (GET) - Por UUID</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="permissoes-de-cargo-get-cargo">📗 Permissoes-de-cargo (GET) - Por Cargo</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="permissoes-de-cargo-post">📗 Permissoes-de-cargo (POST)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="permissoes-de-cargo-put">📗 Permissoes-de-cargo (PUT)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="permissoes-de-cargo-delete">📗 Permissoes-de-cargo (DELETE)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="permissoes-de-excecao-get-list">📗 Permissoes-de-excecao (GET) - Lista</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="permissoes-de-excecao-get-uuid">📗 Permissoes-de-excecao (GET) - Por UUID</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="permissoes-de-excecao-post">📗 Permissoes-de-excecao (POST)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="permissoes-de-excecao-put">📗 Permissoes-de-excecao (PUT)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="permissoes-de-excecao-delete">📗 Permissoes-de-excecao (DELETE)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="permissoes-do-usuario-get">📗 Permissoes-do-usuario (GET)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="permissoes-get-list">📗 Permissoes (GET) - Lista</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="permissoes-get-uuid">📗 Permissoes (GET) - Por UUID</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="permissoes-post">📗 Permissoes (POST)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="permissoes-put">📗 Permissoes (PUT)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="permissoes-delete">📗 Permissoes (DELETE)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="planos-get-list">📗 Planos (GET) - Lista</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="planos-get-uuid">📗 Planos (GET) - Por UUID</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="planos-get-usuario">📗 Planos (GET) - Por Usuario</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="planos-post">📗 Planos (POST)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="planos-put">📗 Planos (PUT)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="planos-delete">📗 Planos (DELETE)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="recursos-do-plano-get-list">📗 Recursos-do-plano (GET) - Lista</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="recursos-do-plano-get-uuid">📗 Recursos-do-plano (GET) - Por UUID</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="recursos-do-plano-get-plano">📗 Recursos-do-plano (GET) - Por Plano</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="recursos-do-plano-post">📗 Recursos-do-plano (POST)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="recursos-do-plano-put">📗 Recursos-do-plano (PUT)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="recursos-do-plano-delete">📗 Recursos-do-plano (DELETE)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="sessoes-post">📗 Sessoes (POST)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="usuarios-get-list">📗 Usuarios (GET) - Lista</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.

#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="usuarios-get-uuid">📗 Usuarios (GET) - Por UUID</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.

#### Administração da Associação

#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="usuarios-post">📗 Usuarios (POST)</h3> ✅

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="usuarios-put">📗 Usuarios (PUT)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente

<h3 id="usuarios-delete">📗 Usuarios (DELETE)</h3>

#### Administração da Plataforma

Vê todos os registros não excluídos.
#### Administração da Associação
#### Administração da Horta
#### Canteirista
#### Dependente



<h1 id="fluxos">🪴 Fluxos</h1>

<h1 id="fluxos">🪴 Fluxo de Cadastro</h1>

-> Cria uma Associação
-> Cria um Usuário que terá por padrão cargo Adminstrador da Plataforma

--> Demais dados devem ser preenchidos depois

<h1 id="pendencias">⚠️ Pendências</h1>
