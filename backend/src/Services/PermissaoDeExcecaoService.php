<?php

namespace App\Services;

use App\Models\PermissaoDeExcecaoModel;
use App\Repositories\PermissaoDeExcecaoRepository;
use Respect\Validation\Validator as v;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Ramsey\Uuid\Uuid;

class PermissaoDeExcecaoService
{
    protected PermissaoDeExcecaoRepository $permissaoDeExcecaoRepository;
    protected PermissaoService $permissaoService;
    protected UsuarioService $usuarioService;
    protected CargoService $cargoService;

    public function __construct(PermissaoDeExcecaoRepository $permissaoDeExcecaoRepository, PermissaoService $permissaoService, UsuarioService $usuarioService, CargoService $cargoService)
    {
        $this->permissaoDeExcecaoRepository = $permissaoDeExcecaoRepository;
        $this->permissaoService = $permissaoService;
        $this->usuarioService = $usuarioService;
        $this->cargoService = $cargoService;
    }

    public function findAllWhere(array $payloadUsuarioLogado): Collection
    {       if (isset($payloadUsuarioLogado['interno']) && $payloadUsuarioLogado['interno'] === false
            && !$this->isCargoAdminPlataforma($payloadUsuarioLogado)) {
            throw new Exception("Permissão de cargo 0 necessária | findAllWhere");
        } 

        return $this->permissaoDeExcecaoRepository->findAllWhere(['excluido' => 0]);
    }
    
    public function findByUuid(string $uuid, array $payloadUsuarioLogado): ?PermissaoDeExcecaoModel
    {       if (isset($payloadUsuarioLogado['interno']) && $payloadUsuarioLogado['interno'] === false
            && !$this->isCargoAdminPlataforma($payloadUsuarioLogado)) {
            throw new Exception("Permissão de cargo 0 necessária | findByUuid");
        } 

        $permissaoDeExcecao = $this->permissaoDeExcecaoRepository->findByUuid($uuid);
        if (!$permissaoDeExcecao|| $permissaoDeExcecao->excluido) {
            throw new Exception('Permissão de Exceção não encontrada');
        }
        return $permissaoDeExcecao;
    }

    public function findByUserUuid(string $uuid, array $payloadUsuarioLogado): Collection
{       if (isset($payloadUsuarioLogado['interno']) && $payloadUsuarioLogado['interno'] === false
            && !$this->isCargoAdminPlataforma($payloadUsuarioLogado)) {
            throw new Exception("Permissão de cargo 0 necessária | findByUserUuid");
        } 

        $permissoesDeExcecaoDoUsuario = $this->permissaoDeExcecaoRepository->findByUserUuid($uuid);
        return $permissoesDeExcecaoDoUsuario; // retorna vazia se não houver
    }

    public function create(array $data, array $payloadUsuarioLogado): PermissaoDeExcecaoModel
    {       if (isset($payloadUsuarioLogado['interno']) && $payloadUsuarioLogado['interno'] === false
            && !$this->isCargoAdminPlataforma($payloadUsuarioLogado)) {
            throw new Exception("Permissão de cargo 0 necessária | create");
        } 

        v::key('usuario_uuid', v::uuid())
        ->key('permissao_uuid', v::uuid())
        ->key('liberado', v::intVal()->min(0)->max(1))
        ->assert($data);
        
        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);
        
        $data['uuid'] = Uuid::uuid1()->toString();
        $data['usuario_criador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];
        $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];

        if (!empty($data['usuario_uuid'])){
            $this->usuarioService->findByUuid($data['usuario_uuid'],$payloadUsuarioLogado);
        }

        if (!empty($data['permissao_uuid'])) {
            $this->permissaoService->findByUuid($data['permissao_uuid'],$payloadUsuarioLogado);
        }

        return $this->permissaoDeExcecaoRepository->create($data);
    }


    public function update(string $uuid, array $data, array $payloadUsuarioLogado): PermissaoDeExcecaoModel
    {       if (isset($payloadUsuarioLogado['interno']) && $payloadUsuarioLogado['interno'] === false
            && !$this->isCargoAdminPlataforma($payloadUsuarioLogado)) {
            throw new Exception("Permissão de cargo 0 necessária | update");
        } 

        $permissaoDeExcecao= $this->permissaoDeExcecaoRepository->findByUuid($uuid);
        if (!$permissaoDeExcecao|| $permissaoDeExcecao->excluido) {
            throw new Exception('Permissão de Exceção não encontrada');
        }

        v::key('usuario_uuid', v::uuid(), false)
        ->key('permissao_uuid', v::uuid(), false)
        ->key('liberado', v::intVal()->min(0)->max(1), false)
        ->assert($data);

        if (!empty($data['usuario_uuid'])){
            $this->usuarioService->findByUuid($data['usuario_uuid'], $payloadUsuarioLogado);
        }

        if (!empty($data['permissao_uuid'])) {
            $this->permissaoService->findByUuid($data['permissao_uuid'], $payloadUsuarioLogado);
        }

        $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];

        return $this->permissaoDeExcecaoRepository->update($permissaoDeExcecao, $data);
    }

    
    public function delete(string $uuid, array $payloadUsuarioLogado): bool {
        if (isset($payloadUsuarioLogado['interno']) && $payloadUsuarioLogado['interno'] === false
            && !$this->isCargoAdminPlataforma($payloadUsuarioLogado)) {
            throw new Exception("Permissão de cargo 0 necessária | delete");
        } 

        $permissaoDeExcecao = $this->permissaoDeExcecaoRepository->findByUuid($uuid);
        if (!$permissaoDeExcecao|| $permissaoDeExcecao->excluido) {
            throw new Exception('Permissão de Exceção não encontrado');
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $payloadUsuarioLogado['usuario_uuid'],
        ];

        return $this->permissaoDeExcecaoRepository->delete($permissaoDeExcecao, $data) ? true : false;
    }

    private function isCargoAdminPlataforma(array $payloadUsuarioLogado): bool
    {
        return $this->cargoService->findByUuidInternal($payloadUsuarioLogado['cargo_uuid'])->slug === "admin_plataforma";
    }
}
