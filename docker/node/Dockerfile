FROM node:18-alpine

# Instalar dependências do sistema
RUN apk add --no-cache git

# Criar diretório da aplicação
WORKDIR /app

# Instalar Vue CLI globalmente  
RUN npm install -g @vue/cli @vue/cli-service

# Usar o usuário node que já existe na imagem
# ou criar um novo se necessário
RUN if ! getent group node > /dev/null 2>&1; then \
        addgroup -S node; \
    fi && \
    if ! getent passwd node > /dev/null 2>&1; then \
        adduser -S node -G node; \
    fi

# Copiar script de entrypoint
COPY ../../docker/frontend-entrypoint.sh /usr/local/bin/frontend-entrypoint.sh
RUN chmod +x /usr/local/bin/frontend-entrypoint.sh

# Alterar proprietário do diretório
RUN chown -R node:node /app

# Mudar para usuário node
USER node

# Expor porta 3000 para desenvolvimento e 9229 para debug
EXPOSE 3000 9229

ENTRYPOINT ["/usr/local/bin/frontend-entrypoint.sh"]
