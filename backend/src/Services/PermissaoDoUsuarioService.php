<?php

namespace App\Services;

use App\Models\PermissaoDeCargoModel;
use App\Repositories\PermissaoDoUsuarioRepository;
use Respect\Validation\Validator as v;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Ramsey\Uuid\Uuid;

class PermissaoDoUsuarioService
{
    protected PermissaoDeCargoService $permissaoDeCargoService;
    protected PermissaoDeExcecaoService $permissaoDeExcecaoService;
    protected PermissaoService $permissaoService;
    protected UsuarioService $usuarioService;

    public function __construct(PermissaoDeCargoService $permissaoDeCargoService, PermissaoService $permissaoService, PermissaoDeExcecaoService $permissaoDeExcecaoService, UsuarioService $usuarioService)
    {
        $this->permissaoDeCargoService = $permissaoDeCargoService;
        $this->permissaoDeExcecaoService = $permissaoDeExcecaoService;
        $this->permissaoService = $permissaoService;
        $this->usuarioService = $usuarioService;
    }
    
    // caso 1: o $uuid (do path da url) != uuid do usuário logado do payload: negativo
    // caso 2: o $uuid (do path da url) == uuid do usuário logado do payload: autorizado
    // caso 3: veio de dentro do app informando o uuid, não vai cair no que vira true mas também não vai tornar false pela controller
    public function findByUuid(string $uuid, array $payloadUsuarioLogado): Collection
    {
        if($uuid == $payloadUsuarioLogado['usuario_uuid']){
            $payloadUsuarioLogado['interno'] = true;
        }
        // Obter o cargo_uuid do usuário
        $cargo_uuid = $payloadUsuarioLogado['cargo_uuid'];
        // Obter as permissões do cargo
        $permissoes_de_cargo = $this->permissaoDeCargoService->findByCargoUuid($cargo_uuid, $payloadUsuarioLogado);
        // Obter as permissões de exceção do usuário
        $permissoes_de_excecao = $this->permissaoDeExcecaoService->findByUserUuid($uuid, $payloadUsuarioLogado);
        // Gerar um array "cru" com todas as permissões
        
        
        $permissoes = array_merge($permissoes_de_cargo->all(), $permissoes_de_excecao->all());
        if (!$permissoes) {
            throw new Exception('Nenhuma permissão para este usuário');
        }

        $arrayPermissoes = $this->gerarArrayUuidDePermissoesComStatus($permissoes);

        $uuidsPermissoes = array_keys(array_filter($arrayPermissoes, function($valor) {
            return $valor === 1;
        }));

        $permissoesCompletas = $this->permissaoService->findAllInUuidList($uuidsPermissoes, $payloadUsuarioLogado);
        // no futuro, dá pra retornar um formato mais otimizado para cachear no Redis ou navegador
        // por hora, só pra termos acesso ao pacote de permissões sanitizado
        return $permissoesCompletas;
    }

    public function gerarArrayUuidDePermissoesComStatus(array $permissoes): array
    {
        $resultado = [];
        $temSobrescrita = [];

        foreach ($permissoes as $p) {
            $uuid = $p->permissao_uuid;
            $resultado[$uuid] = 1;
            
            if(isset($p->liberado)){
                $temSobrescrita[$uuid] = (int) $p->liberado;
            }
        }
        foreach ($temSobrescrita as $uuid => $valor) {
            $resultado[$uuid] = $valor;
        }

        return $resultado;
    }
}
