# 🌱 Hortas Comunitárias + Univille

Sistema de gestão de associações e hortas comunitárias desenvolvido na disciplina de Vivências de Extensão V pelos graduandos dos cursos de Engenharia de Software e Sistemas de Informação da Univille.

## 🌐 DEVS UNIVILLE | Grupo no Discord
https://discord.gg/fjJJtgED

## 🛣️ Roadmap do Projeto

Atualmente, estamos registrando progresso na [Issue #9 - Roadmap até MVP 🔗](https://github.com/thiagohome2/hortas-comunitarias-univille/issues/9).

Contribuições são bem-vindas!

## 🚀 Stack Tecnológica

### Backend
- **PHP 8.2** com **Slim Framework 4**
- **MySQL 8.0** para banco de dados
- **JWT** para autenticação
- **Nginx** como servidor web
- **Redis** para cache e sessões

### Frontend
- **Vue.js 3** com Composition API
- **Vue Router 4** para roteamento
- **Vuex 4** para gerenciamento de estado
- **Bootstrap 5** para UI
- **Leaflet** para mapas

### Mobile
- **Vue Native** / **React Native**
- **Expo** para desenvolvimento
- **React Navigation** para navegação

### DevOps
- **Docker** e **Docker Compose**
- **Nginx** como proxy reverso
- **phpMyAdmin** para administração do banco

## 📁 Estrutura do Projeto

```
hortas-comunitarias-univille/
├── backend/                 # API PHP com Slim Framework
├── frontend/               # Aplicação Vue.js
├── mobile/                 # App React Native
├── docker/                 # Configurações Docker
├── docker-compose.yml      # Orquestração dos serviços
├── Makefile               # Comandos úteis
└── DEVELOPMENT.md         # Guia detalhado de desenvolvimento
```

## 🔧 Configuração Rápida: Setup local

```bash
# Clone o repositório
git clone <repo-url>
cd hortas-comunitarias-univille

# Configuração automática do ambiente
make setup

# Ou use o script diretamente
./setup.sh
```

## 🔧 Configuração Rápida: Banco de Dados do Backend

Na pasta SQL tem dois arquivos:

- `00_SQL_criar_banco.sql`: Esse arquivo tem o SQL para criar a estrutura do banco.
- `00_SQL_popular_banco.sql`: Esse arquivo tem o SQL para popular o banco com Cargos, Permissões, Permissões do Cargo e um Usuário super-admin.
    - **Email:** admin_hortas_comunitarias@univille.br
    - **Senha:** senha12345

Rode estes arquivos no MySQL, aqui utlizamos o PhpMyAdmin mas deve funcionar no seu client de preferência.

## 🔧 Configuração Rápida: Utilizando a API REST do Backend

A documentação da API REST, das regras de negócio do projeto, bem como templates e outros recursos úteis estão [disponíveis aqui 🔗](www.todo.com).

## 🌐 URLs dos Serviços

- **Frontend**: http://localhost:3000
- **Backend API**: http://localhost:8181/api
- **phpMyAdmin**: http://localhost:8080
- **Portainer**: http://localhost:9000
- **MySQL**: localhost:3306

## 📋 Comandos Úteis

```bash
make help           # Ver todos os comandos disponíveis
make start          # Iniciar todos os containers
make stop           # Parar todos os containers
make logs           # Ver logs dos serviços
make install        # Instalar dependências
make clean          # Limpar ambiente
```

Para mais detalhes, consulte o [DEVELOPMENT.md](DEVELOPMENT.md).

---

## **📊 Método de Avaliação – Projeto Hortas Comunitárias Univille**

### **1. Estrutura de Times**

* **Planejamento**

  * Modelagem de dados
  * Cronograma do projeto
  * Criação e gestão de *issues* no GitHub
  * Especificação de requisitos funcionais
* **Backend**

  * Modelagem e implementação do banco de dados
  * Desenvolvimento da API (Slim Framework)
  * Documentação da API
* **Frontend**

  * UX/UI design
  * Desenvolvimento interface web (Vue.js)
  * Desenvolvimento interface mobile (Vue Native / Quasar / Ionic)

---

## **2. Ferramenta de Trabalho**

* **GitHub** como repositório único do projeto.
* Organização:

  * *Branches* por funcionalidade (`feature/`, `fix/`, `doc/`)
  * *Pull Requests* revisados e aprovados antes de *merge*
  * Issues com responsáveis e prazo definido
  * Kanban GitHub Projects para acompanhamento

---

## **3. Critérios de Avaliação**

### **A. Avaliação da Equipe** (50% da nota)

**Medição pelo progresso coletivo do time no GitHub**

* **Entrega das tarefas** (30%)

  * % de *issues* concluídas dentro do prazo
  * Qualidade e completude das entregas (ex.: API funcionando, telas navegáveis, documentação clara)
* **Organização e uso do GitHub** (20%)

  * Uso consistente de *issues* com descrição, responsáveis e labels
  * Uso do *Kanban* para acompanhamento
  * Commits claros e bem descritos

📌 **Métrica prática no GitHub**:

* Número de *issues* fechadas
* Tempo médio de entrega (*lead time*)
* Revisões de *pull requests* feitas

---

### **B. Avaliação Individual** (50% da nota)

**Medida pela contribuição real no repositório**

* **Contribuições Técnicas** (25%)

  * Quantidade e qualidade dos commits (*não apenas número, mas relevância e clareza*)
  * Participação em *pull requests* (autor ou revisor)
  * Código limpo, funcional e com documentação mínima
* **Colaboração e Comunicação** (15%)

  * Participação em revisões de código de colegas
  * Resposta a comentários em *issues* e PRs
  * Clareza na descrição de *issues* abertas
* **Pontualidade e Proatividade** (10%)

  * Cumprimento de prazos
  * Participação nas reuniões online/presenciais
  * Apoio a outros membros quando necessário

📌 **Métrica prática no GitHub**:

* Histórico de commits por aluno
* Comentários e revisões em PRs
* Issues criadas e resolvidas pelo aluno

---

## **4. Ferramenta de Apoio à Avaliação**

**planilha de controle** (Google Sheets) integrada com os dados do GitHub (via GitHub API) para que o professor possa:

* Puxar automaticamente número de commits, PRs e issues por aluno
* Visualizar contribuições por equipe e individuais
* Gerar relatório final de desempenho

---

## **5. Fórmula da Nota Final**

```
Nota Final = (Equipe * 0,5) + (Individual * 0,5)
```

Onde:

* **Equipe** = nota coletiva da equipe com base no avanço e qualidade
* **Individual** = nota pessoal com base nas contribuições registradas no GitHub
