<?php

namespace App\Services;

use App\Models\CanteiroModel;
use App\Repositories\CanteiroRepository;
use Respect\Validation\Validator as v;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Ramsey\Uuid\Uuid;

class CanteiroService
{
    protected CanteiroRepository $canteiroRepository;
    protected HortaService $hortaService; 
    protected UsuarioService $usuarioService; 

    public function __construct(CanteiroRepository $canteiroRepository, HortaService $hortaService, UsuarioService $usuarioService)
    {
        $this->canteiroRepository = $canteiroRepository; 
        $this->hortaService = $hortaService;
        $this->usuarioService = $usuarioService;
    }

    public function findAllWhere(): Collection
    {
        return $this->canteiroRepository->findAllWhere(['excluido' => 0]);
    }
    
    public function findByUuid(string $uuid): ?CanteiroModel
    {
        $canteiro= $this->canteiroRepository->findByUuid($uuid);
        if (!$canteiro|| $canteiro->excluido) {
            throw new Exception('Canteiro não encontrado');
        }
        return $canteiro;
    }

 public function create(array $data, string $uuidUsuarioLogado): CanteiroModel
    {
        v::key('numero_identificador', v::stringType()->notEmpty())
        ->key('tamanho_m2', v::stringType()->notEmpty())
        ->key('horta_uuid', v::uuid())
        ->key('usuario_anterior_uuid', v::uuid(), false)
        ->assert($data);
        
        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);
        
        $data['uuid'] = Uuid::uuid1()->toString();
        $data['usuario_criador_uuid'] = $uuidUsuarioLogado;
        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        if (!empty($data['horta_uuid'])) {
            $this->hortaService->findByUuid($data['horta_uuid']);
        }

        if (!empty($data['usuario_anterior_uuid'])) {
            $this->usuarioService->findByUuid($data['usuario_anterior_uuid']);
        }


        return $this->canteiroRepository->create($data);
    }


    public function update(string $uuid, array $data, string $uuidUsuarioLogado): CanteiroModel
    {
        $canteiro= $this->canteiroRepository->findByUuid($uuid);
        if (!$canteiro|| $canteiro->excluido) {
            throw new Exception('Canteiro não encontrado');
        }
        v::key('numero_identificador', v::stringType()->notEmpty(), false)
        ->key('tamanho_m2', v::stringType()->notEmpty(), false)
        ->key('horta_uuid', v::uuid(), false)
        ->key('usuario_anterior_uuid', v::uuid(), false)
        ->assert($data);

        if (!empty($data['horta_uuid'])) {
            $this->hortaService->findByUuid($data['horta_uuid']);
        }
        if (!empty($data['usuario_anterior_uuid'])) {
            $this->usuarioService->findByUuid($data['usuario_anterior_uuid']);
        }

        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        return $this->canteiroRepository->update($canteiro, $data);
    }

    
    public function delete(string $uuid, string $uuidUsuarioLogado): bool {
        $canteiro = $this->canteiroRepository->findByUuid($uuid);
        if (!$canteiro|| $canteiro->excluido) {
            throw new Exception('Canteiro não encontrado');
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $uuidUsuarioLogado,
        ];

        return $this->canteiroRepository->delete($canteiro, $data) ? true : false;
    }
}
