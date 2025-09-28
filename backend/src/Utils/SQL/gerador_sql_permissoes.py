import uuid
from datetime import datetime

# Lista de módulos e permissões
modulos = [
    ("USUARIOS", 0),
    ("ASSOCIACOES", 1),
    ("HORTAS", 2),
    ("ENDERECOS", 3),
    ("CANTEIROS", 4),
    ("CANTEIROS_USUARIOS", 5),
    ("CARGOS", 6),
    ("PERMISSOES", 7),
    ("PERMISSOES_CARGO", 8),
    ("PERMISSOES_EXCECAO", 9),
    ("PERMISSOES_USUARIO", 10),
    ("CATEGORIAS_FINANCEIRAS", 11),
    ("FINANCEIRO_HORTA", 12),
    ("FINANCEIRO_ASSOCIACAO", 13),
    ("MENSALIDADES_ASSOCIACAO", 14),
    ("MENSALIDADES_PLATAFORMA", 15),
    ("PLANOS", 16),
    ("RECURSOS_PLANO", 17),
    ("CHAVES", 18),
    ("FILA_USUARIOS", 19)
]

tipos = [("ler", 0), ("criar", 1), ("editar", 2), ("deletar", 3)]

# Corrigir acentuação (exemplo simples, você pode ajustar conforme necessário)
acentos_corrigidos = {
    "Permiss�o": "Permissão",
    "m�dulo": "módulo"
}

# Função para corrigir strings
def corrigir(texto):
    for errado, certo in acentos_corrigidos.items():
        texto = texto.replace(errado, certo)
    return texto

# Data atual no formato SQL
data_atual = datetime.now().strftime('%Y-%m-%d %H:%M:%S')

# Nome do arquivo SQL
arquivo_sql = "inserts_permissoes.sql"

# Gera inserts
with open(arquivo_sql, "w", encoding="utf-8") as f:
    f.write("-- Limpa tabela\nTRUNCATE TABLE permissoes;\n\n")
    f.write("-- ================= INSERÇÕES =================\n")
    
    for modulo_nome, modulo_id in modulos:
        for tipo_nome, tipo_id in tipos:
            # Permissoes_USUARIO tem só "ler"
            if modulo_nome == "PERMISSOES_USUARIO" and tipo_nome != "ler":
                continue
            
            uid = str(uuid.uuid4())
            descricao = f"Permiss�o de {tipo_nome.upper()} no m�dulo {modulo_nome}"
            descricao = corrigir(descricao)
            
            insert = (
                f"INSERT INTO permissoes (uuid, slug, tipo, descricao, modulo, excluido, "
                f"usuario_criador_uuid, data_de_criacao, usuario_alterador_uuid, data_de_ultima_alteracao) "
                f"VALUES ('{uid}', '{modulo_nome.lower()}_{tipo_nome}', {tipo_id}, '{descricao}', {modulo_id}, 0, "
                f"NULL, '{data_atual}', NULL, '{data_atual}');\n"
            )
            f.write(insert)

print(f"Arquivo SQL gerado com sucesso: {arquivo_sql}")
