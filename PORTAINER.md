# 🐳 Portainer - Interface Web para Docker

## 🎯 O que é Portainer?
Portainer é uma interface web moderna e fácil de usar para gerenciar Docker containers, imagens, volumes, redes e muito mais!

## ✨ Funcionalidades
- ✅ **Interface gráfica** para gerenciar containers
- ✅ **Monitoramento** de recursos (CPU, RAM, Rede)
- ✅ **Logs** em tempo real
- ✅ **Terminal** web para acessar containers
- ✅ **Gestão de imagens** e volumes
- ✅ **Templates** de aplicações prontas
- ✅ **Estatísticas** detalhadas

## 🚀 Instalação

### Opção 1: Com o projeto (Recomendado)
```bash
# Portainer já está incluído no docker-compose.yml
make start

# Ou inicie apenas o Portainer
make portainer-start
```

### Opção 2: Standalone (separado do projeto)
```bash
# Criar volume para dados
docker volume create portainer_data

# Executar Portainer
docker run -d \
  --name portainer \
  --restart unless-stopped \
  -p 9000:9000 \
  -p 9443:9443 \
  -v /var/run/docker.sock:/var/run/docker.sock \
  -v portainer_data:/data \
  portainer/portainer-ce:latest
```

## 🌐 Acesso
**URL**: http://localhost:9000

### Primeira configuração:
1. Acesse http://localhost:9000
2. Crie usuário admin (primeira vez)
3. Escolha "Docker" como ambiente
4. Clique em "Connect"

## 📊 Recursos do Portainer

### 🔍 **Dashboard Principal**
- Visão geral de containers, imagens, volumes
- Estatísticas de uso de recursos
- Status de saúde do Docker

### 📦 **Gerenciar Containers**
```
Containers → Lista de todos containers
- ▶️ Start/Stop/Restart
- 📊 Estatísticas em tempo real  
- 📝 Logs em tempo real
- 💻 Console/Terminal web
- 🔧 Inspecionar configurações
```

### 🖼️ **Gerenciar Imagens**
```
Images → Lista de imagens Docker
- 📥 Pull novas imagens
- 🗑️ Remover imagens não utilizadas
- 🔍 Inspecionar detalhes
- 🏗️ Build de imagens customizadas
```

### 💾 **Volumes e Redes**
```
Volumes → Gerenciar armazenamento
Networks → Configurar redes Docker
```

### 📋 **Templates de Aplicações**
Portainer oferece templates prontos para:
- WordPress
- MySQL
- Redis
- Nginx
- E muito mais!

## 🛠️ Comandos Úteis

```bash
# Iniciar Portainer
make portainer-start

# Ver logs do Portainer
make portainer-logs

# Parar Portainer
docker-compose stop portainer

# Reiniciar Portainer
docker-compose restart portainer

# Remover Portainer (cuidado!)
docker-compose rm portainer
docker volume rm portainer_data
```

## 🔧 Configurações Avançadas

### Autenticação
- **Local**: Usuário/senha local
- **LDAP**: Integração com Active Directory
- **OAuth**: GitHub, Google, etc.

### Segurança
- HTTPS habilitado na porta 9443
- Controle de acesso por usuário
- Logs de auditoria

### Backup
```bash
# Backup dos dados do Portainer
docker run --rm \
  -v portainer_data:/data \
  -v $(pwd):/backup \
  alpine tar czf /backup/portainer_backup.tar.gz /data
```

## 🐛 Solução de Problemas

### Portainer não inicia
```bash
# Verificar se Docker está rodando
docker ps

# Verificar logs
docker logs portainer

# Recriar container
docker-compose rm portainer
docker-compose up -d portainer
```

### Não consegue acessar containers
```bash
# Verificar se socket do Docker está acessível
ls -la /var/run/docker.sock

# Reiniciar Portainer
docker restart portainer
```

### Porta 9000 em uso
```bash
# Verificar o que está usando a porta
lsof -i :9000

# Ou usar porta alternativa no docker-compose.yml
- "9001:9000"
```

## 📱 **Gerenciando o Projeto Hortas**

Após iniciar todos os serviços (`make start`), no Portainer você verá:

### Containers:
- `hortas_nginx` - Servidor web
- `hortas_php` - Backend API
- `hortas_mysql` - Banco de dados  
- `hortas_frontend` - Interface Vue.js
- `hortas_phpmyadmin` - Admin do banco
- `hortas_redis` - Cache
- `hortas_portainer` - Interface Docker

### Ações úteis:
- 📊 **Monitorar recursos** de cada container
- 📝 **Ver logs** em tempo real
- 💻 **Acessar terminal** dos containers
- 🔄 **Restart** serviços com problemas
- 📈 **Estatísticas** de performance

## 🎯 **Dicas de Uso**

1. **Favoritar containers** importantes
2. **Configurar alertas** para falhas
3. **Usar terminal web** para debug
4. **Monitorar recursos** regularmente
5. **Fazer backup** das configurações

---

**🌟 Com Portainer, gerenciar Docker fica muito mais fácil e visual!**

**Acesse agora**: http://localhost:9000
