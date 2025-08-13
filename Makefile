.PHONY: help setup start stop restart logs clean install test

# Cores para output
GREEN=\033[0;32m
YELLOW=\033[1;33m
RED=\033[0;31m
NC=\033[0m # No Color

help: ## Mostra este help
	@echo "$(GREEN)Hortas Comunitárias - Comandos Disponíveis:$(NC)"
	@echo ""
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  $(YELLOW)%-15s$(NC) %s\n", $$1, $$2}' $(MAKEFILE_LIST)
	@echo ""

setup: ## Configuração inicial completa do ambiente
	@echo "$(GREEN)🌱 Configurando ambiente...$(NC)"
	@./setup.sh

start: ## Inicia todos os containers
	@echo "$(GREEN)🚀 Iniciando containers...$(NC)"
	@docker-compose up -d
	@echo "$(GREEN)✅ Containers iniciados!$(NC)"

stop: ## Para todos os containers
	@echo "$(YELLOW)🛑 Parando containers...$(NC)"
	@docker-compose down
	@echo "$(YELLOW)✅ Containers parados!$(NC)"

restart: stop start ## Reinicia todos os containers

logs: ## Mostra logs de todos os serviços
	@docker-compose logs -f

logs-backend: ## Mostra logs do backend
	@docker-compose logs -f php nginx

logs-frontend: ## Mostra logs do frontend
	@docker-compose logs -f frontend

logs-db: ## Mostra logs do banco de dados
	@docker-compose logs -f mysql

shell-php: ## Acessa o container PHP
	@docker-compose exec php bash

shell-mysql: ## Acessa o container MySQL
	@docker-compose exec mysql bash

install-backend: ## Instala dependências do backend
	@echo "$(GREEN)📦 Instalando dependências do backend...$(NC)"
	@docker-compose exec php composer install

install-frontend: ## Instala dependências do frontend
	@echo "$(GREEN)📦 Instalando dependências do frontend...$(NC)"
	@docker-compose exec frontend npm install

install-mobile: ## Instala dependências do mobile
	@echo "$(GREEN)📦 Instalando dependências do mobile...$(NC)"
	@cd mobile && npm install

install: install-backend install-frontend install-mobile ## Instala todas as dependências

test-backend: ## Executa testes do backend
	@docker-compose exec php vendor/bin/phpunit

test-frontend: ## Executa testes do frontend
	@docker-compose exec frontend npm test

build: ## Constrói todos os containers
	@echo "$(GREEN)🔨 Construindo containers...$(NC)"
	@docker-compose build

clean: ## Remove containers, volumes e imagens
	@echo "$(RED)🧹 Limpando ambiente...$(NC)"
	@docker-compose down -v --rmi all
	@docker system prune -f

status: ## Mostra status dos containers
	@docker-compose ps

fresh: clean setup ## Reinstalação completa (remove tudo e reconfigura)

prod-build: ## Build para produção
	@echo "$(GREEN)🏗️ Fazendo build para produção...$(NC)"
	@docker-compose -f docker-compose.yml -f docker-compose.prod.yml build
	@docker-compose exec frontend npm run build

backup-db: ## Backup do banco de dados
	@echo "$(GREEN)💾 Fazendo backup do banco...$(NC)"
	@docker-compose exec mysql mysqldump -u hortas_user -phortas_password hortas_db > backup_$(shell date +%Y%m%d_%H%M%S).sql

dev: start ## Alias para start (desenvolvimento)

# Informações úteis
info: ## Mostra informações do ambiente
	@echo "$(GREEN)📊 Informações do Ambiente:$(NC)"
	@echo ""
	@echo "$(YELLOW)🌐 URLs:$(NC)"
	@echo "  Frontend:    http://localhost:3000"
	@echo "  Backend API: http://localhost:8181/api"
	@echo "  phpMyAdmin:  http://localhost:8080"
	@echo ""
	@echo "$(YELLOW)🔧 Banco de Dados:$(NC)"
	@echo "  Host: localhost:3306"
	@echo "  Database: hortas_db"
	@echo "  User: hortas_user"
	@echo "  Password: hortas_password"
	@echo ""
	@echo "$(YELLOW)📱 Mobile:$(NC)"
	@echo "  cd mobile && npm start"
