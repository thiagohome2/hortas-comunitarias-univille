#!/bin/sh

# Script de inicialização do frontend
echo "🌱 Iniciando frontend..."

# Verificar se node_modules existe
if [ ! -d "node_modules" ]; then
    echo "📦 Instalando dependências do Node.js..."
    npm install
else
    echo "✅ Dependências já instaladas"
fi

# Verificar se vue-cli-service está disponível
if ! command -v vue-cli-service > /dev/null 2>&1; then
    echo "🔧 Instalando Vue CLI Service..."
    npm install @vue/cli-service
fi

echo "🚀 Iniciando servidor de desenvolvimento..."
exec npm run serve
