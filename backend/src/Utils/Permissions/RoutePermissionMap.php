<?php

namespace App\Utils\Permissions;

class RoutePermissionMap
{
    private array $map = [
        // ==== Sessões (Públicas) ====
        '/sessoes/login POST'                                       => [],
        '/sessoes/cadastro POST'                                    => [],

        // ==== Associações ====
        '/associacoes GET'                                          => ['associacoes_get'],
        '/associacoes/{uuid} GET'                                   => ['associacoes_get_uuid'],
        '/associacoes POST'                                         => ['associacoes_post'],
        '/associacoes/{uuid} PUT'                                   => ['associacoes_put'],
        '/associacoes/{uuid} DELETE'                                => ['associacoes_delete'],

        // ==== Canteiros e Usuários ====
        '/canteiros-e-usuarios GET'                                 => ['canteiros_e_usuarios_get'],
        '/canteiros-e-usuarios/{uuid} GET'                          => ['canteiros_e_usuarios_get_uuid'],
        '/canteiros-e-usuarios POST'                                => ['canteiros_e_usuarios_post'],
        '/canteiros-e-usuarios/{uuid} PUT'                          => ['canteiros_e_usuarios_put'],
        '/canteiros-e-usuarios/{uuid} DELETE'                       => ['canteiros_e_usuarios_delete'],

        // ==== Canteiros ====
        '/canteiros GET'                                            => ['canteiros_get'],
        '/canteiros/{uuid} GET'                                     => ['canteiros_get_uuid'],
        '/canteiros POST'                                           => ['canteiros_post'],
        '/canteiros/{uuid} PUT'                                     => ['canteiros_put'],
        '/canteiros/{uuid} DELETE'                                  => ['canteiros_delete'],

        // ==== Cargos ====
        '/cargos GET'                                               => ['cargos_get'],
        '/cargos/{uuid} GET'                                        => ['cargos_get_uuid'],
        '/cargos POST'                                              => ['cargos_post'],
        '/cargos/{uuid} PUT'                                        => ['cargos_put'],
        '/cargos/{uuid} DELETE'                                     => ['cargos_delete'],

        // ==== Categorias Financeiras ====
        '/categorias-financeiras GET'                               => ['categorias_financeiras_get'],
        '/categorias-financeiras/{uuid} GET'                        => ['categorias_financeiras_get_uuid'],
        '/categorias-financeiras/associacao/{uuid} GET'             => ['categorias_financeiras_get_associacao'],
        '/categorias-financeiras/horta/{uuid} GET'                  => ['categorias_financeiras_get_horta'],
        '/categorias-financeiras POST'                              => ['categorias_financeiras_post'],
        '/categorias-financeiras/{uuid} PUT'                        => ['categorias_financeiras_put'],
        '/categorias-financeiras/{uuid} DELETE'                     => ['categorias_financeiras_delete'],

        // ==== Chaves ====
        '/chaves GET'                                               => ['chaves_get'],
        '/chaves/{uuid} GET'                                        => ['chaves_get_uuid'],
        '/chaves POST'                                              => ['chaves_post'],
        '/chaves/{uuid} PUT'                                        => ['chaves_put'],
        '/chaves/{uuid} DELETE'                                     => ['chaves_delete'],

        // ==== Endereços ====
        '/enderecos GET'                                            => ['enderecos_get'],
        '/enderecos/{uuid} GET'                                     => ['enderecos_get_uuid'],
        '/enderecos POST'                                           => ['enderecos_post'],
        '/enderecos/{uuid} PUT'                                     => ['enderecos_put'],
        '/enderecos/{uuid} DELETE'                                  => ['enderecos_delete'],

        // ==== Fila de Usuários ====
        '/fila-de-usuarios GET'                                     => ['fila_de_usuarios_get'],
        '/fila-de-usuarios/{uuid} GET'                              => ['fila_de_usuarios_get_uuid'],
        '/fila-de-usuarios/horta/{uuid} GET'                        => ['fila_de_usuarios_get_horta'],
        '/fila-de-usuarios/usuario/{uuid} GET'                      => ['fila_de_usuarios_get_usuario'],
        '/fila-de-usuarios POST'                                    => ['fila_de_usuarios_post'],
        '/fila-de-usuarios/{uuid} PUT'                              => ['fila_de_usuarios_put'],
        '/fila-de-usuarios/{uuid} DELETE'                           => ['fila_de_usuarios_delete'],

        // ==== Financeiro da Associação ====
        '/financeiro-da-associacao GET'                             => ['financeiro_da_associacao_get'],
        '/financeiro-da-associacao/{uuid} GET'                      => ['financeiro_da_associacao_get_uuid'],
        '/financeiro-da-associacao/associacao/{uuid} GET'           => ['financeiro_da_associacao_get_associacao'],
        '/financeiro-da-associacao POST'                            => ['financeiro_da_associacao_post'],
        '/financeiro-da-associacao/{uuid} PUT'                      => ['financeiro_da_associacao_put'],
        '/financeiro-da-associacao/{uuid} DELETE'                   => ['financeiro_da_associacao_delete'],

        // ==== Financeiro da Horta ====
        '/financeiro-da-horta GET'                                  => ['financeiro_da_horta_get'],
        '/financeiro-da-horta/{uuid} GET'                           => ['financeiro_da_horta_get_uuid'],
        '/financeiro-da-horta/horta/{uuid} GET'                     => ['financeiro_da_horta_get_horta'],
        '/financeiro-da-horta POST'                                 => ['financeiro_da_horta_post'],
        '/financeiro-da-horta/{uuid} PUT'                           => ['financeiro_da_horta_put'],
        '/financeiro-da-horta/{uuid} DELETE'                        => ['financeiro_da_horta_delete'],

        // ==== Hortas ====
        '/hortas GET'                                               => ['hortas_get'],
        '/hortas/{uuid} GET'                                        => ['hortas_get_uuid'],
        '/hortas POST'                                              => ['hortas_post'],
        '/hortas/{uuid} PUT'                                        => ['hortas_put'],
        '/hortas/{uuid} DELETE'                                     => ['hortas_delete'],

        // ==== Mensalidades da Plataforma ====
        '/mensalidades-da-plataforma GET'                           => ['mensalidades_da_plataforma_get'],
        '/mensalidades-da-plataforma/{uuid} GET'                    => ['mensalidades_da_plataforma_get_uuid'],
        '/mensalidades-da-plataforma/associacao/{uuid} GET'         => ['mensalidades_da_plataforma_get_associacao'],
        '/mensalidades-da-plataforma/usuario/{uuid} GET'            => ['mensalidades_da_plataforma_get_usuario'],
        '/mensalidades-da-plataforma POST'                          => ['mensalidades_da_plataforma_post'],
        '/mensalidades-da-plataforma/{uuid} PUT'                    => ['mensalidades_da_plataforma_put'],
        '/mensalidades-da-plataforma/{uuid} DELETE'                 => ['mensalidades_da_plataforma_delete'],

        // ==== Mensalidades da Associação ====
        '/mensalidades-da-associacao GET'                           => ['mensalidades_da_associacao_get'],
        '/mensalidades-da-associacao/{uuid} GET'                    => ['mensalidades_da_associacao_get_uuid'],
        '/mensalidades-da-associacao/usuario/{uuid} GET'            => ['mensalidades_da_associacao_get_usuario'],
        '/mensalidades-da-associacao POST'                          => ['mensalidades_da_associacao_post'],
        '/mensalidades-da-associacao/{uuid} PUT'                    => ['mensalidades_da_associacao_put'],
        '/mensalidades-da-associacao/{uuid} DELETE'                 => ['mensalidades_da_associacao_delete'],

        // ==== Permissões de Cargo ====
        '/permissoes-de-cargo GET'                                  => ['permissoes_de_cargo_get'],
        '/permissoes-de-cargo/{uuid} GET'                           => ['permissoes_de_cargo_get_uuid'],
        '/permissoes-de-cargo/cargo/{uuid} GET'                     => ['permissoes_de_cargo_get_cargo'],
        '/permissoes-de-cargo POST'                                 => ['permissoes_de_cargo_post'],
        '/permissoes-de-cargo/{uuid} PUT'                           => ['permissoes_de_cargo_put'],
        '/permissoes-de-cargo/{uuid} DELETE'                        => ['permissoes_de_cargo_delete'],

        // ==== Permissões de Exceção ====
        '/permissoes-de-excecao GET'                                => ['permissoes_de_excecao_get'],
        '/permissoes-de-excecao/{uuid} GET'                         => ['permissoes_de_excecao_get_uuid'],
        '/permissoes-de-excecao POST'                               => ['permissoes_de_excecao_post'],
        '/permissoes-de-excecao/{uuid} PUT'                         => ['permissoes_de_excecao_put'],
        '/permissoes-de-excecao/{uuid} DELETE'                      => ['permissoes_de_excecao_delete'],

        // ==== Permissões do Usuário ====
        '/permissoes-do-usuario/{uuid} GET'                         => ['permissoes_do_usuario_get'],

        // ==== Permissões ====
        '/permissoes GET'                                           => ['permissoes_get'],
        '/permissoes/{uuid} GET'                                    => ['permissoes_get_uuid'],
        '/permissoes POST'                                          => ['permissoes_post'],
        '/permissoes/{uuid} PUT'                                    => ['permissoes_put'],
        '/permissoes/{uuid} DELETE'                                 => ['permissoes_delete'],

        // ==== Planos ====
        '/planos GET'                                               => ['planos_get'],
        '/planos/{uuid} GET'                                        => ['planos_get_uuid'],
        '/planos/usuario/{uuid} GET'                                => ['planos_get_usuario'],
        '/planos POST'                                              => ['planos_post'],
        '/planos/{uuid} PUT'                                        => ['planos_put'],
        '/planos/{uuid} DELETE'                                     => ['planos_delete'],

        // ==== Recursos do Plano ====
        '/recursos-do-plano GET'                                    => ['recursos_do_plano_get'],
        '/recursos-do-plano/{uuid} GET'                             => ['recursos_do_plano_get_uuid'],
        '/recursos-do-plano/plano/{uuid} GET'                       => ['recursos_do_plano_get_plano'],
        '/recursos-do-plano POST'                                   => ['recursos_do_plano_post'],
        '/recursos-do-plano/{uuid} PUT'                             => ['recursos_do_plano_put'],
        '/recursos-do-plano/{uuid} DELETE'                          => ['recursos_do_plano_delete'],

        // ==== Usuários ====
        '/usuarios GET'                                             => ['usuarios_get'],
        '/usuarios/{uuid} GET'                                      => ['usuarios_get_uuid'],
        '/usuarios POST'                                            => ['usuarios_post'],
        '/usuarios/{uuid} PUT'                                      => ['usuarios_put'],
        '/usuarios/{uuid} DELETE'                                   => ['usuarios_delete'],
    ];

    public function getRequiredPermissions(string $routeIdentifier): ?array
    {
        return $this->map[$routeIdentifier] ?? null;
    }
}
