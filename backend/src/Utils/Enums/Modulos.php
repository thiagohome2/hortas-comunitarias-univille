<?php

enum Modulos: int
{
    case USUARIOS = 0;
    case ASSOCIACOES = 1;
    case HORTAS = 2;
    case ENDERECOS = 3;
    case CANTEIROS = 4;
    case CANTEIROS_E_USUARIOS = 5;
    case CARGOS = 6;
    case PERMISSOES = 7;
    case PERMISSOES_DE_CARGO = 8;
    case PERMISSOES_DE_EXCECAO = 9;
    case CATEGORIAS_FINANCEIRAS = 10;
    case FINANCEIRO_HORTA = 11;
    case FINANCEIRO_ASSOCIACAO = 12;
    case MENSALIDADES_DA_ASSOCIACAO = 13;
    case MENSALIDADES_DA_PLATAFORMA = 14;
    case PLANOS = 15;
    case RECURSOS_DO_PLANO = 16;
    case CHAVES = 17;
    case FILA_DE_USUARIO = 18;
}

?>