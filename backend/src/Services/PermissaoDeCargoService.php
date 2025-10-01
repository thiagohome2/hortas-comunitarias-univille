<?php

namespace App\Services;

use App\Models\PermissaoDeCargoModel;
use App\Repositories\PermissaoDeCargoRepository;
use Respect\Validation\Validator as v;
use Illuminate\Database\Eloquent\Collection;
use Exception;
use Ramsey\Uuid\Uuid;

class PermissaoDeCargoService
{
    protected PermissaoDeCargoRepository $permissaoDeCargoRepository;
    protected PermissaoService $permissaoService;
    protected CargoService $cargoService;

    public function __construct(PermissaoDeCargoRepository $permissaoDeCargoRepository, 
    PermissaoService $permissaoService, CargoService $cargoService)
    {
        $this->permissaoDeCargoRepository = $permissaoDeCargoRepository;
        $this->permissaoService = $permissaoService;
        $this->cargoService = $cargoService;
    }

    public function findAllWhere(array $payloadUsuarioLogado): Collection
    {   
        if (isset($payloadUsuarioLogado['interno']) && $payloadUsuarioLogado['interno'] === false
            && !$this->isCargoAdminPlataforma($payloadUsuarioLogado)) {
            throw new Exception("Permissão de cargo 0 necessária | findAllWhere");
        } 
        return $this->permissaoDeCargoRepository->findAllWhere(['excluido' => 0]);
    }
    
    public function findByUuid(string $uuid, array $payloadUsuarioLogado): ?PermissaoDeCargoModel
    {
        if (isset($payloadUsuarioLogado['interno']) && $payloadUsuarioLogado['interno'] === false
            && !$this->isCargoAdminPlataforma($payloadUsuarioLogado)) {
            throw new Exception("Permissão de cargo 0 necessária | findByUuid");
        }  
        $permissaoDeCargo= $this->permissaoDeCargoRepository->findByUuid($uuid);
        if (!$permissaoDeCargo|| $permissaoDeCargo->excluido) {
            throw new Exception('Permissão de cargo não encontrada');
        }
        return $permissaoDeCargo;
    }
    public function findByCargoUuid(string $cargoUuid, array $payloadUsuarioLogado): Collection
    {
        if (isset($payloadUsuarioLogado['interno']) && $payloadUsuarioLogado['interno'] === false
            && !$this->isCargoAdminPlataforma($payloadUsuarioLogado)) {
            throw new Exception("Permissão de cargo 0 necessária | findByCargoUuid");
        } 

        $permissoesDeCargo = $this->permissaoDeCargoRepository->findByCargoUuid($cargoUuid);
        if ($permissoesDeCargo->isEmpty()) {
            throw new Exception('Permissões de cargo não encontrada');
        }
        return $permissoesDeCargo;
    }

 public function create(array $data,array $payloadUsuarioLogado): PermissaoDeCargoModel
    {

        if (isset($payloadUsuarioLogado['interno']) && $payloadUsuarioLogado['interno'] === false
            && !$this->isCargoAdminPlataforma($payloadUsuarioLogado)) {
            throw new Exception("Permissão de cargo 0 necessária | create");
        } 

        v::key('permissao_uuid', v::uuid())
        ->key('cargo_uuid', v::uuid())
        ->assert($data);
        
        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);
        
        $data['uuid'] = Uuid::uuid1()->toString();
        $data['usuario_criador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];
        $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];

        if (!empty($data['cargo_uuid'])){
            $this->cargoService->findByUuidInternal($data['cargo_uuid']);
        }

        if (!empty($data['permissao_uuid'])) {
            $this->permissaoService->findByUuid($data['permissao_uuid'], $payloadUsuarioLogado);
        }

        return $this->permissaoDeCargoRepository->create($data);
    }


    public function update(string $uuid, array $data, array $payloadUsuarioLogado): PermissaoDeCargoModel
    {
        if (isset($payloadUsuarioLogado['interno']) && $payloadUsuarioLogado['interno'] === false
            && !$this->isCargoAdminPlataforma($payloadUsuarioLogado)) {
            throw new Exception("Permissão de cargo 0 necessária | update");
        }  
        $permissaoDeCargo= $this->permissaoDeCargoRepository->findByUuid($uuid);
        if (!$permissaoDeCargo|| $permissaoDeCargo->excluido) {
            throw new Exception('Permissão de cargo não encontrada');
        }

        v::key('permissao_uuid', v::uuid(), false)
        ->key('cargo_uuid', v::uuid(), false)
        ->assert($data);

        if (!empty($data['cargo_uuid'])){
            $this->cargoService->findByUuidInternal($data['cargo_uuid']);
        }

        if (!empty($data['permissao_uuid'])) {
            $this->permissaoService->findByUuid($data['permissao_uuid'], $payloadUsuarioLogado);
        }

        $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];

        return $this->permissaoDeCargoRepository->update($permissaoDeCargo, $data);
    }

    
    public function delete(string $uuid, array $payloadUsuarioLogado): bool {
        if (isset($payloadUsuarioLogado['interno']) && $payloadUsuarioLogado['interno'] === false
            && !$this->isCargoAdminPlataforma($payloadUsuarioLogado)) {
            throw new Exception("Permissão de cargo 0 necessária | delete");
        } 

        $permissaoDeCargo = $this->permissaoDeCargoRepository->findByUuid($uuid);
        if (!$permissaoDeCargo|| $permissaoDeCargo->excluido) {
            throw new Exception('Permissão de cargo não encontrada');
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $payloadUsuarioLogado['usuario_uuid'],
        ];

        return $this->permissaoDeCargoRepository->delete($permissaoDeCargo, $data) ? true : false;
    }

    private function isCargoAdminPlataforma(array $payloadUsuarioLogado): bool
    {
        return $this->cargoService->findByUuidInternal($payloadUsuarioLogado['cargo_uuid'])->slug === "admin_plataforma";
    }
}
