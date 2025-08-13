#!/bin/bash

echo "🌱 Configurando ambiente de desenvolvimento Hortas Comunitárias..."

# Verificar se Docker está instalado
if ! command -v docker &> /dev/null; then
    echo "❌ Docker não encontrado. Por favor, instale o Docker primeiro."
    exit 1
fi

if ! command -v docker-compose &> /dev/null; then
    echo "❌ Docker Compose não encontrado. Por favor, instale o Docker Compose primeiro."
    exit 1
fi

# Criar arquivos .env se não existirem
echo "📝 Criando arquivos de configuração..."

if [ ! -f backend/.env ]; then
    cp backend/.env.example backend/.env
    echo "✅ Arquivo backend/.env criado"
fi

# Parar containers existentes
echo "🛑 Parando containers existentes..."
docker-compose down

# Construir e iniciar containers
echo "🔨 Construindo containers..."
docker-compose build --no-cache

echo "🚀 Iniciando containers..."
docker-compose up -d

# Aguardar MySQL estar pronto
echo "⏳ Aguardando MySQL estar pronto..."
sleep 10

# Instalar dependências do backend
echo "📦 Instalando dependências do backend..."
docker-compose exec php composer install

# Instalar dependências do frontend
echo "📦 Instalando dependências do frontend..."
docker-compose exec frontend npm install

echo ""
echo "✅ Ambiente de desenvolvimento configurado com sucesso!"
echo ""
echo "🌐 Serviços disponíveis:"
echo "   Frontend (Vue.js): http://localhost:3000"
echo "   Backend API: http://localhost/api"
echo "   phpMyAdmin: http://localhost:8080"
echo "   MySQL: localhost:3306"
echo ""
echo "📱 Para o mobile (Vue Native):"
echo "   cd mobile && npm install && npm start"
echo ""
echo "🔧 Comandos úteis:"
echo "   docker-compose logs -f [serviço]    # Ver logs"
echo "   docker-compose exec php bash        # Acessar container PHP"
echo "   docker-compose exec mysql bash      # Acessar container MySQL"
echo "   docker-compose down                 # Parar todos os containers"
echo ""
