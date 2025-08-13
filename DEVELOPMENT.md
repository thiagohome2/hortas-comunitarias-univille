# 🌱 Hortas Comunitárias - Guia de Desenvolvimento

## 📋 Estrutura do Projeto

```
hortas-comunitarias-univille/
├── backend/                 # API Slim Framework (PHP)
│   ├── app/                # Configurações da aplicação
│   ├── public/             # Ponto de entrada da API
│   ├── src/                # Código fonte
│   └── composer.json       # Dependências PHP
├── frontend/               # Aplicação Vue.js
│   ├── src/                # Código fonte Vue
│   ├── public/             # Arquivos públicos
│   └── package.json        # Dependências Node.js
├── mobile/                 # App Vue Native/React Native
│   ├── screens/            # Telas do app
│   └── package.json        # Dependências React Native
├── docker/                 # Configurações Docker
│   ├── nginx/              # Configurações Nginx
│   ├── php/                # Dockerfile e config PHP
│   ├── mysql/              # Configurações MySQL
│   └── node/               # Dockerfile Node.js
└── docker-compose.yml      # Orquestração dos containers
```

## 🚀 Instalação e Configuração

### Pré-requisitos
- Docker 20.10+
- Docker Compose 2.0+
- Git

### Instalação Rápida

```bash
# Clonar o repositório
git clone <repo-url>
cd hortas-comunitarias-univille

# Configurar ambiente completo
make setup

# Ou usar o script diretamente
./setup.sh
```

### Instalação Manual

```bash
# 1. Copiar arquivo de configuração
cp backend/.env.example backend/.env

# 2. Construir containers
docker-compose build

# 3. Iniciar serviços
docker-compose up -d

# 4. Instalar dependências
make install
```

## 🐳 Comandos Docker

```bash
# Gerenciamento básico
make start          # Iniciar containers
make stop           # Parar containers
make restart        # Reiniciar containers
make logs           # Ver logs de todos serviços

# Desenvolvimento
make install        # Instalar todas dependências
make shell-php      # Acessar container PHP
make shell-mysql    # Acessar container MySQL
make status         # Ver status dos containers

# Limpeza
make clean          # Remover tudo
make fresh          # Reinstalação completa
```

## 🌐 Serviços e URLs

| Serviço | URL | Descrição |
|---------|-----|-----------|
| **Frontend** | http://localhost:3000 | Interface Vue.js |
| **Backend API** | http://localhost:8181/api | API Slim Framework |
| **phpMyAdmin** | http://localhost:8080 | Interface banco de dados |
| **MySQL** | localhost:3306 | Banco de dados |

### Credenciais Padrão

**Banco de dados:**
- Host: `localhost:3306`
- Database: `hortas_db`
- User: `hortas_user`
- Password: `hortas_password`
- Root password: `root_password`

## 🔧 Desenvolvimento

### Backend (Slim Framework)

```bash
# Instalar dependências
make install-backend

# Executar testes
make test-backend

# Acessar container
make shell-php

# Ver logs
make logs-backend
```

**Estrutura da API:**
- `GET /api/hortas` - Listar hortas
- `POST /api/hortas` - Criar horta
- `GET /api/produtos` - Listar produtos
- `POST /api/auth/login` - Login

### Frontend (Vue.js)

```bash
# Instalar dependências
make install-frontend

# Executar testes
make test-frontend

# Ver logs de desenvolvimento
make logs-frontend
```

**Principais tecnologias:**
- Vue.js 3
- Vue Router 4
- Vuex 4
- Bootstrap 5
- Axios
- Leaflet (mapas)

### Mobile (Vue Native)

```bash
# Instalar dependências
make install-mobile

# Iniciar desenvolvimento
cd mobile
npm start

# Para Android
npm run android

# Para iOS
npm run ios
```

## 📊 Banco de Dados

O banco é inicializado automaticamente com:
- Tabelas: `usuarios`, `hortas`, `produtos`
- Dados de exemplo
- Usuários padrão (admin, produtor, consumidor)

### Backup e Restore

```bash
# Backup
make backup-db

# Restore (manual)
docker-compose exec mysql mysql -u hortas_user -phortas_password hortas_db < backup.sql
```

## 🧪 Testes

```bash
# Backend
make test-backend

# Frontend
make test-frontend

# Mobile
cd mobile && npm test
```

## 🐛 Debug e Logs

```bash
# Logs gerais
make logs

# Logs específicos
make logs-backend
make logs-frontend
make logs-db

# Debug PHP (container)
make shell-php
tail -f /var/log/nginx/error.log
```

## 📱 Desenvolvimento Mobile

### Configuração Expo

```bash
cd mobile

# Instalar CLI do Expo
npm install -g @expo/cli

# Iniciar projeto
npm start

# Escanear QR code com Expo Go app
```

### Build para Produção

```bash
# Android
npm run build:android

# iOS
npm run build:ios
```

## 🌍 Deploy e Produção

### Frontend Build

```bash
# Build do frontend
docker-compose exec frontend npm run build

# Os arquivos ficam em frontend/dist/
```

### Variáveis de Ambiente

**Backend (.env):**
```
APP_ENV=production
DB_HOST=mysql
JWT_SECRET=seu-jwt-secret-seguro
```

**Frontend (.env):**
```
VUE_APP_API_URL=https://api.hortas.com
```

## 🔒 Segurança

- JWT para autenticação
- Rate limiting no Nginx
- Headers de segurança configurados
- Validação de entrada nos endpoints

## 📋 Lista de Verificação

### ✅ Desenvolvimento
- [ ] Docker containers rodando
- [ ] Backend respondendo em `/api`
- [ ] Frontend carregando em `:3000`
- [ ] Banco de dados conectado
- [ ] Mobile compilando

### ✅ Antes do Commit
- [ ] Testes passando
- [ ] Código seguindo padrões
- [ ] Variáveis sensíveis não commitadas
- [ ] README atualizado se necessário

## 🆘 Solução de Problemas

### Container não inicia
```bash
# Ver logs detalhados
docker-compose logs [serviço]

# Reconstruir container
docker-compose build --no-cache [serviço]
```

### Porta em uso
```bash
# Verificar portas
lsof -i :3000
lsof -i :80

# Parar processos se necessário
```

### Dependências desatualizadas
```bash
# Limpar e reinstalar
make fresh
```

### Banco não conecta
```bash
# Verificar se MySQL está rodando
docker-compose ps

# Resetar banco
docker-compose down -v
docker-compose up -d
```

---

## 👥 Equipe e Contribuição

Para contribuir:
1. Fork o projeto
2. Crie branch para feature (`git checkout -b feature/nova-funcionalidade`)
3. Commit suas mudanças (`git commit -m 'Adiciona nova funcionalidade'`)
4. Push para branch (`git push origin feature/nova-funcionalidade`)
5. Abra um Pull Request

**Padrões de commit:**
- `feat:` nova funcionalidade
- `fix:` correção de bug
- `docs:` documentação
- `style:` formatação
- `refactor:` refatoração
- `test:` testes
