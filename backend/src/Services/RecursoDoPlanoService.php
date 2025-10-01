<?php
namespace App\Services;

use App\Models\RecursoDoPlanoModel;
use App\Repositories\RecursoDoPlanoRepository;
use Respect\Validation\Validator as v;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Ramsey\Uuid\Uuid;

class RecursoDoPlanoService
{
    protected RecursoDoPlanoRepository $recursoDoPlanoRepository;
    protected PlanoService $planoService;
    protected CargoService $cargoService;

    public function __construct(RecursoDoPlanoRepository $recursoDoPlanoRepository,
    PlanoService $planoService,
    CargoService $cargoService){
        $this->recursoDoPlanoRepository = $recursoDoPlanoRepository;
        $this->planoService = $planoService;
        $this->cargoService = $cargoService;
    }

    public function findAllWhere(array $payloadUsuarioLogado): Collection {
        if (!$this->isCargoAdminPlataforma($payloadUsuarioLogado)) {
            throw new Exception("Permissão de cargo 0 necessária | findAllWhere");
        } else {
            return $this->recursoDoPlanoRepository->findAllWhere(['excluido' => 0]);
        }
    }

    public function findByUuid(string $uuid,array $payloadUsuarioLogado): ?RecursoDoPlanoModel {
        if (!$this->isCargoAdminPlataforma($payloadUsuarioLogado)) {
            throw new Exception("Permissão de cargo 0 necessária | findByUuid");
        } else {
            $recursoDoPlano = $this->recursoDoPlanoRepository->findByUuid($uuid);
            if(!$recursoDoPlano || $recursoDoPlano->excluido){
                throw new Exception('Recurso do Plano não encontrado');
            }
            return $recursoDoPlano;
        }
    }

    public function findByPlanoUuid(string $planoUuid, array $payloadUsuarioLogado): ?Collection {
        if (!$this->isCargoAdminPlataforma($payloadUsuarioLogado)) {
            throw new Exception("Permissão de cargo 0 necessária | findByPlanoUuid");
        } else {     
            $plano = $this->planoService->findByUuid($planoUuid, $payloadUsuarioLogado);
            if(!$plano || $plano->excluido){
                throw new Exception('Plano não encontrado');
            }
    
            $recursosDoPlano = $this->recursoDoPlanoRepository->findByPlanoUuid($planoUuid);
            if($recursosDoPlano->isEmpty()){
                throw new Exception('Recursos do Plano não encontrado');
            }
            return $recursosDoPlano;
        }
    }

    public function create(array $data, array $payloadUsuarioLogado): RecursoDoPlanoModel {
        if (!$this->isCargoAdminPlataforma($payloadUsuarioLogado)) {
            throw new Exception("Permissão de cargo 0 necessária | create");
        } else {
            v::key('nome_do_recurso', v::stringType()->notEmpty())
              ->key('quantidade', v::intType())
              ->key('descricao', v::stringType()->notEmpty())
              ->key('plano_uuid', v::uuid())
              ->check($data);
    
              if (!empty($data['plano_uuid'])){
                  $this->planoService->findByUuid($data['plano_uuid'], $payloadUsuarioLogado);
              }
    
            $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
            foreach ($guarded as $g) unset($data[$g]);
    
            $data['uuid'] = Uuid::uuid1()->toString();
            $data['usuario_criador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];
            $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];
    
            return $this->recursoDoPlanoRepository->create($data);
        }
    }

    public function update(string $uuid, array $data, array $payloadUsuarioLogado): RecursoDoPlanoModel {
        if (!$this->isCargoAdminPlataforma($payloadUsuarioLogado)) {
            throw new Exception("Permissão de cargo 0 necessária | update");
        } else {
            
            $recursoDoPlano = $this->recursoDoPlanoRepository->findByUuid($uuid);
            if(!$recursoDoPlano || $recursoDoPlano->excluido){
                throw new Exception('Recurso do Plano não encontrado');
            }
    
            v::key('nome_do_recurso', v::stringType()->notEmpty(), false)
              ->key('quantidade', v::intType(), false)
              ->key('descricao', v::stringType()->notEmpty(), false)
              ->key('plano_uuid', v::uuid(), false)
              ->check($data);
    
            if (!empty($data['plano_uuid'])){
                $this->planoService->findByUuid($data['plano_uuid'], $payloadUsuarioLogado);
            }
    
            $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
            foreach ($guarded as $g) unset($data[$g]);
    
            $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];
    
            return $this->recursoDoPlanoRepository->update($recursoDoPlano, $data);
        }
    }

    public function delete(string $uuid, array $payloadUsuarioLogado): bool {
        if (!$this->isCargoAdminPlataforma($payloadUsuarioLogado)) {
            throw new Exception("Permissão de cargo 0 necessária | delete");
        } else {
            $recursoDoPlano = $this->recursoDoPlanoRepository->findByUuid($uuid);
            if (!$recursoDoPlano || $recursoDoPlano->excluido) {
                throw new Exception('Recurso do Plano não encontrado');
            } 
            $data = [
                'excluido' => 1,
                'usuario_alterador_uuid' => $payloadUsuarioLogado['usuario_uuid'],
            ];
    
            return $this->recursoDoPlanoRepository->delete($recursoDoPlano, $data);
        }
    }

    private function isCargoAdminPlataforma(array $payloadUsuarioLogado): bool
    {
        return $this->cargoService->findByUuidInternal($payloadUsuarioLogado['cargo_uuid'])->slug === "admin_plataforma";
    }
}
