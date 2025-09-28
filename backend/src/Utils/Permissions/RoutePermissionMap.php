<?php

namespace App\Utils\Permissions;

class RoutePermissionMap
{
    private array $map = [
        // ==== Associacoes ====
        '/associacoes GET'            => ['associacoes_ler'],
        '/associacoes/{uuid} GET'     => ['associacoes_ler'],
        '/associacoes POST'           => ['associacoes_criar'],
        '/associacoes/{uuid} PUT'     => ['associacoes_editar'],
        '/associacoes/{uuid} DELETE'  => ['associacoes_deletar'],

        // ==== Canteiros ====
        '/canteiros GET'              => ['canteiros_ler'],
        '/canteiros/{uuid} GET'       => ['canteiros_ler'],
        '/canteiros POST'             => ['canteiros_criar'],
        '/canteiros/{uuid} PUT'       => ['canteiros_editar'],
        '/canteiros/{uuid} DELETE'    => ['canteiros_deletar'],

        // ==== Canteiros e Usuários ====
        '/canteiros-e-usuarios GET'              => ['canteiros_usuarios_ler'],
        '/canteiros-e-usuarios/{uuid} GET'       => ['canteiros_usuarios_ler'],
        '/canteiros-e-usuarios POST'             => ['canteiros_usuarios_criar'],
        '/canteiros-e-usuarios/{uuid} PUT'       => ['canteiros_usuarios_editar'],
        '/canteiros-e-usuarios/{uuid} DELETE'    => ['canteiros_usuarios_deletar'],

        // ==== Cargos ====
        '/cargos GET'                => ['cargos_ler'],
        '/cargos/{uuid} GET'         => ['cargos_ler'],
        '/cargos POST'               => ['cargos_criar'],
        '/cargos/{uuid} PUT'         => ['cargos_editar'],
        '/cargos/{uuid} DELETE'      => ['cargos_deletar'],

        // ==== Categorias Financeiras ====
        '/categorias-financeiras GET'                  => ['categorias_financeiras_ler'],
        '/categorias-financeiras/{uuid} GET'           => ['categorias_financeiras_ler'],
        '/categorias-financeiras/associacao/{uuid} GET'=> ['categorias_financeiras_ler'],
        '/categorias-financeiras/horta/{uuid} GET'     => ['categorias_financeiras_ler'],
        '/categorias-financeiras POST'                 => ['categorias_financeiras_criar'],
        '/categorias-financeiras/{uuid} PUT'           => ['categorias_financeiras_editar'],
        '/categorias-financeiras/{uuid} DELETE'        => ['categorias_financeiras_deletar'],

        // ==== Chaves ====
        '/chaves GET'                => ['chaves_ler'],
        '/chaves/{uuid} GET'         => ['chaves_ler'],
        '/chaves POST'               => ['chaves_criar'],
        '/chaves/{uuid} PUT'         => ['chaves_editar'],
        '/chaves/{uuid} DELETE'      => ['chaves_deletar'],

        // ==== Enderecos ====
        '/enderecos GET'             => ['enderecos_ler'],
        '/enderecos/{uuid} GET'      => ['enderecos_ler'],
        '/enderecos POST'            => ['enderecos_criar'],
        '/enderecos/{uuid} PUT'      => ['enderecos_editar'],
        '/enderecos/{uuid} DELETE'   => ['enderecos_deletar'],

        // ==== Fila de Usuarios ====
        '/fila-de-usuarios GET'                => ['fila_usuarios_ler'],
        '/fila-de-usuarios/{uuid} GET'         => ['fila_usuarios_ler'],
        '/fila-de-usuarios/horta/{uuid} GET'   => ['fila_usuarios_ler'],
        '/fila-de-usuarios/usuario/{uuid} GET' => ['fila_usuarios_ler'],
        '/fila-de-usuarios POST'               => ['fila_usuarios_criar'],
        '/fila-de-usuarios/{uuid} PUT'         => ['fila_usuarios_editar'],
        '/fila-de-usuarios/{uuid} DELETE'      => ['fila_usuarios_deletar'],

        // ==== Financeiro da Associacao ====
        '/financeiro-da-associacao GET'               => ['financeiro_associacao_ler'],
        '/financeiro-da-associacao/{uuid} GET'        => ['financeiro_associacao_ler'],
        '/financeiro-da-associacao/associacao/{uuid} GET' => ['financeiro_associacao_ler'],
        '/financeiro-da-associacao POST'              => ['financeiro_associacao_criar'],
        '/financeiro-da-associacao/{uuid} PUT'        => ['financeiro_associacao_editar'],
        '/financeiro-da-associacao/{uuid} DELETE'     => ['financeiro_associacao_deletar'],

        // ==== Financeiro da Horta ====
        '/financeiro-da-horta GET'               => ['financeiro_horta_ler'],
        '/financeiro-da-horta/{uuid} GET'        => ['financeiro_horta_ler'],
        '/financeiro-da-horta/horta/{uuid} GET'  => ['financeiro_horta_ler'],
        '/financeiro-da-horta POST'              => ['financeiro_horta_criar'],
        '/financeiro-da-horta/{uuid} PUT'        => ['financeiro_horta_editar'],
        '/financeiro-da-horta/{uuid} DELETE'     => ['financeiro_horta_deletar'],

        // ==== Hortas ====
        '/hortas GET'               => ['hortas_ler'],
        '/hortas/{uuid} GET'        => ['hortas_ler'],
        '/hortas POST'              => ['hortas_criar'],
        '/hortas/{uuid} PUT'        => ['hortas_editar'],
        '/hortas/{uuid} DELETE'     => ['hortas_deletar'],

        // ==== Mensalidades da Associacao ====
        '/mensalidades-da-associacao GET'                => ['mensalidades_associacao_ler'],
        '/mensalidades-da-associacao/{uuid} GET'         => ['mensalidades_associacao_ler'],
        '/mensalidades-da-associacao/associacao/{uuid} GET' => ['mensalidades_associacao_ler'],
        '/mensalidades-da-associacao/usuario/{uuid} GET' => ['mensalidades_associacao_ler'],
        '/mensalidades-da-associacao POST'               => ['mensalidades_associacao_criar'],
        '/mensalidades-da-associacao/{uuid} PUT'         => ['mensalidades_associacao_editar'],
        '/mensalidades-da-associacao/{uuid} DELETE'      => ['mensalidades_associacao_deletar'],

        // ==== Mensalidades da Plataforma ====
        '/mensalidades-da-plataforma GET'                => ['mensalidades_plataforma_ler'],
        '/mensalidades-da-plataforma/{uuid} GET'         => ['mensalidades_plataforma_ler'],
        '/mensalidades-da-plataforma/usuario/{uuid} GET' => ['mensalidades_plataforma_ler'],
        '/mensalidades-da-plataforma POST'               => ['mensalidades_plataforma_criar'],
        '/mensalidades-da-plataforma/{uuid} PUT'         => ['mensalidades_plataforma_editar'],
        '/mensalidades-da-plataforma/{uuid} DELETE'      => ['mensalidades_plataforma_deletar'],

        // ==== Permissoes ====
        '/permissoes GET'              => ['permissoes_ler'],
        '/permissoes/{uuid} GET'       => ['permissoes_ler'],
        '/permissoes POST'             => ['permissoes_criar'],
        '/permissoes/{uuid} PUT'       => ['permissoes_editar'],
        '/permissoes/{uuid} DELETE'    => ['permissoes_deletar'],

        // ==== Permissoes de Cargo ====
        '/permissoes-de-cargo GET'              => ['permissoes_cargo_ler'],
        '/permissoes-de-cargo/{uuid} GET'       => ['permissoes_cargo_ler'],
        '/permissoes-de-cargo/cargo/{uuid} GET' => ['permissoes_cargo_ler'],
        '/permissoes-de-cargo POST'             => ['permissoes_cargo_criar'],
        '/permissoes-de-cargo/{uuid} PUT'       => ['permissoes_cargo_editar'],
        '/permissoes-de-cargo/{uuid} DELETE'    => ['permissoes_cargo_deletar'],

        // ==== Permissoes de Excecao ====
        '/permissoes-de-excecao GET'              => ['permissoes_excecao_ler'],
        '/permissoes-de-excecao/{uuid} GET'       => ['permissoes_excecao_ler'],
        '/permissoes-de-excecao POST'             => ['permissoes_excecao_criar'],
        '/permissoes-de-excecao/{uuid} PUT'       => ['permissoes_excecao_editar'],
        '/permissoes-de-excecao/{uuid} DELETE'    => ['permissoes_excecao_deletar'],

        // ==== Permissoes do Usuario ====
        '/permissoes-do-usuario/{uuid} GET'      => ['permissoes_usuario_ler'],

        // ==== Planos ====
        '/planos GET'                => ['planos_ler'],
        '/planos/{uuid} GET'         => ['planos_ler'],
        '/planos/usuario/{uuid} GET' => ['planos_ler'],
        '/planos POST'               => ['planos_criar'],
        '/planos/{uuid} PUT'         => ['planos_editar'],
        '/planos/{uuid} DELETE'      => ['planos_deletar'],

        // ==== Recursos do Plano ====
        '/recursos-do-plano GET'              => ['recursos_plano_ler'],
        '/recursos-do-plano/{uuid} GET'       => ['recursos_plano_ler'],
        '/recursos-do-plano/plano/{uuid} GET' => ['recursos_plano_ler'],
        '/recursos-do-plano POST'             => ['recursos_plano_criar'],
        '/recursos-do-plano/{uuid} PUT'       => ['recursos_plano_editar'],
        '/recursos-do-plano/{uuid} DELETE'    => ['recursos_plano_deletar'],

        // ==== Usuarios ====
        '/usuarios GET'              => ['usuarios_ler'],
        '/usuarios/{uuid} GET'       => ['usuarios_ler'],
        '/usuarios POST'             => ['usuarios_criar'],
        '/usuarios/{uuid} PUT'       => ['usuarios_editar'],
        '/usuarios/{uuid} DELETE'    => ['usuarios_deletar'],
    ];

    public function getRequiredPermissions(string $routeIdentifier): ?array
    {
        return $this->map[$routeIdentifier] ?? null;
    }
}
