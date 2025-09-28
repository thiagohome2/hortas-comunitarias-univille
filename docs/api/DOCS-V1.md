# 🥑 API REST + Regras de Negócio | Documentação

## 📑 Sumário
- [📗 Introdução](#introducao)
- [⏩ Início Rápido](#inicio-rapido)
- [🧭 Rotas ](#rotas)
  - [Usuários](#usuarios)
    - [Usuários (GET)](#usuarios-get)
    - [Usuários (POST)](#usuarios-post)
    - [Usuários (PUT)](#usuarios-put)


<h1 id="introducao">📗 Introdução</h1>

⚠️ **Importante:** Usamos o Claude Sonnet 4 para revisão e formatação dessa documentação. Qualquer erro aparente é decorrente desse robo maldito que tanto nos auxilia.

Essa documentação compreende as rotas da API REST do projeto. O objetivo é listar todas as rotas, quais inputs e outputs elas tem, e quais as regras de negócio aplicadas nelas que devem ser respeitadas no(s) front-end(s).

<h2 id="inicio-rapido">⏩ Inicio rápido</h2>

Primeiro, siga o tópico [📁 Estrutura do Projeto](https://github.com/thiagohome2/hortas-comunitarias-univille?tab=readme-ov-file#-estrutura-do-projeto) no README.md, nele você fará o setup local da aplicação, incluindo banco de dados com INSERTs iniciais necessários.

Exceto pela rota Sessões (POST), todas as rotas exigem uso do JWT e analisarão as permissões do usuário via validação do JWT informado.

Aqui consideramos o uso do Postman como client de uso, portanto os templates disponíveis são para uso com ele informando o JWT na aba Authorization com tipo Bearer Token.

Em geral, o cabeçalho da requisição deve conter o token JWT no formato Bearer, ou seja: `Authorization: Bearer {token}`.

<h1 id="rotas">🧭 Rotas</h1>

À seguir, disponibilizamos a lista de rotas da aplicação. Aproveite!

<h2 id="usuarios">🔗Usuários</h1>

**URL:** `{{BASE_URL}}/api/v1/usuarios`
**Enum do recurso no banco:** `0`

Serve para gerenciar os usuários da plataforma.

<h3 id="usuarios-get">📗 Usuários (GET)</h1>

**Slug da permissão:** `usuarios_ler`
**Tipo da permissão:** `0`

Retorna uma lista com os registros não excluídos da aplicação.

<h3 id="usuarios-post">📗 Usuários (POST)</h1>

**Slug da permissão:** 
**Tipo da permissão:** 

Cria um usuário na aplicação.

<h3 id="usuarios-put">📗 Usuários (PUT)</h1>

**Slug da permissão:**
**Tipo da permissão:** 

Atualiza um usuário na aplicação.