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

    public function __construct(RecursoDoPlanoRepository $recursoDoPlanoRepository,
    PlanoService $planoService){
        $this->recursoDoPlanoRepository = $recursoDoPlanoRepository;
        $this->planoService = $planoService;
    }

    public function findAllWhere(): Collection {
        return $this->recursoDoPlanoRepository->findAllWhere(['excluido' => 0]);
    }

    public function findByUuid(string $uuid): ?RecursoDoPlanoModel {
        $recursoDoPlano = $this->recursoDoPlanoRepository->findByUuid($uuid);
        if(!$recursoDoPlano || $recursoDoPlano->excluido){
            throw new Exception('Recurso do Plano não encontrado');
        }
        return $recursoDoPlano;
    }

    public function findByPlanoUuid(string $planoUuid): ?Collection {
        $plano = $this->planoService->findByUuid($planoUuid);
        if(!$plano || $plano->excluido){
            throw new Exception('Plano não encontrado');
        }

        $recursosDoPlano = $this->recursoDoPlanoRepository->findByPlanoUuid($planoUuid);
        if($recursosDoPlano->isEmpty()){
            throw new Exception('Recursos do Plano não encontrado');
        }
        return $recursosDoPlano;
    }

    public function create(array $data, string $uuidUsuarioLogado): RecursoDoPlanoModel {
        v::key('nome_do_recurso', v::stringType()->notEmpty())
          ->key('quantidade', v::intType())
          ->key('descricao', v::stringType()->notEmpty())
          ->key('plano_uuid', v::uuid())
          ->check($data);

          if (!empty($data['plano_uuid'])){
              $this->planoService->findByUuid($data['plano_uuid']);
          }

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['uuid'] = Uuid::uuid1()->toString();
        $data['usuario_criador_uuid'] = $uuidUsuarioLogado;
        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        return $this->recursoDoPlanoRepository->create($data);
    }

    public function update(string $uuid, array $data, string $uuidUsuarioLogado): RecursoDoPlanoModel {
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
            $this->planoService->findByUuid($data['plano_uuid']);
        }

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        return $this->recursoDoPlanoRepository->update($recursoDoPlano, $data);
    }

    public function delete(string $uuid, string $uuidUsuarioLogado): bool {
        $recursoDoPlano = $this->recursoDoPlanoRepository->findByUuid($uuid);
        if (!$recursoDoPlano || $recursoDoPlano->excluido) {
            throw new Exception('Recurso do Plano não encontrado');
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $uuidUsuarioLogado,
        ];

        return $this->recursoDoPlanoRepository->delete($recursoDoPlano, $data);
    }
}
