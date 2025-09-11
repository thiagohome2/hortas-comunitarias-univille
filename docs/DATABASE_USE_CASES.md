# Use Cases da Documentação do Banco de Dados v1 | 11-09-2025

⚠️ **Atenção:** Essa documentação não está finalizada. Estamos levando ela em paralelo ao desenvolvimento dos wireframes da interface e finalização das tabelas de planos da plataforma.

# 🍅 Use cases | Explicando consumo do banco de dados

<aside>
🥑 Explicando como definimos/definiremos as permissões e regras de negócio baseado no banco de dados
</aside>

## 🍓Fluxo de Cadastro + Responsa | 0 - Administração da Plataforma

1. CADASTRO: Podemos injetar no banco, na tabela **`bd.usuarios`** como uma *seed* de dados, alguns acessos com cargo com o UUID do cargo “0 - Administrador da Plataforma”  na tabela **`bd.cargos`**
    1. Eles são a staff da plataforma, provavelmente o Thiago
2. PERMISSÕES: Usuários com esse cargo “0” terão acesso a todas as telas do sistema; são capazes de utilizar o CRUD de todas as entidades do banco
3. PAGAMENTO: Usuários com esse cargo “0” não terão validação de mensalidade da tabela `bd.mensalidades`
4. Usuários com esse cargo “0” terão papel de via Dashboard de Associações que lista `bd.associacoes` liberar o acesso delas, o que torna a coluna Status de Aprovação de `bd.associacoes` = true
    1. Liberar uma Associação libera o Usuário com cargo “1 - Administração da Associação” de acessar o sistema. Mais sobre o fluxo de uso deles e cadastro de Associação abaixo.

## 🍓Fluxo de Cadastro + Responsa | 1 - Administração da Associação

1. CADASTRO: A pessoa se cadastra preenchendo seus dados de usuário numa página de sign-up normal
    1. Cria-se um registro em `bd.usuarios` para essa pessoa
    2. A pessoa preenche os dados da Associação numa das etapas do sign-up
    3. Cria-se um registro em  `bd.associacoes`
    4. A Associação precisa ser aprovado por um staff (cargo = “0”), sendo aprovada, o Usuário pode acessar o sistema e seu UUID é setado no `bd.associacoes.usuario_responsavel_uuid`
        1. Não tem como existir um usuário sem ser atrelado à Associação, por isso ela é criada por alguém na plataforma pra iniciar o ciclo de uso, demais serão adicionados via página de gestão no sistema
2. PERMISSÕES: Usuários com esse cargo “1” terão acesso a todas as telas do sistema; são capazes de utilizar o CRUD de todas as entidades do banco, exceto operações relacionadas a usuários com cargo “0” por razões obvias e eventuais tabelas do tópico de pagamento à seguir
3. ⚠️ PAGAMENTO: Precisa definir se as associações pagarão pra usar a plataforma, se sim, basta criar uma regra que usuários com cargo “1” , que esteja como responsável da associação, vão ter uma tabela como a bd.mensalidades (que regula pagamento de associados com associação) só que ai regulando a relação de usuário com a plataforma mesmo, tipo uma bd.mensalidades_plataforma, Citamos apenas o usuário admin que ficou como responsável pois faz sentido só um usuário pagar a mensalidade referente a essa associação como em qualquer SaaS
    1. *Caso seja pago pra usar, ai pode usar a mesma mecânica da tabela `bd.mensalidades` e pode-se criar uma `bd.planos` ou algo assim*
    2. Por padrão, como não temos regra de pagamento à plataforma, usuários de cargo “1” que estão como responsáveis da associação sempre terão bd.usuarios.status_de_acesso = 1 pois não haverá rotina que sete como algo diferente
    3. Demais usuários terão cobrança normal, pois mesmo sendo administradores da associação também são associados à ela mesma e pagam a taxa

<aside>
🥑 O restante das permissões segue a mesma lógica, vai diminuindo escopo de permissões e não acessa quem é hierarquicamente maior. Com as exceções dá pra refinar isso. Na sexta-feira 29-08-25 vamos refinar.

| Nome do Cargo | Slug | Código (número para lógica) |
| --- | --- | --- |
| Administração da Plataforma | admin_plataforma | 0 |
| Administração da Associação | admin_associacao_geral | 1 |
| Administração da Horta | admin_horta_geral | 2 |
| Canteirista | canteirista | 3 |
| Dependente | dependente | 4 |
</aside>
