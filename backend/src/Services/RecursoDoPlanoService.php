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
    protected $recursoDoPlanoRepository;

    public function __construct(RecursoDoPlanoRepository $recursoDoPlanoRepository){
        $this->recursoDoPlanoRepository = $recursoDoPlanoRepository;
    }

    public function findAllWhere(): Collection {
        return $this->recursoDoPlanoRepository->findAllWhere(['excluido' => 0]);
    }

    public function findByUuid(string $uuid): ?RecursoDoPlanoModel {
        $recursoDoPlano = $this->recursoDoPlanoRepository->findByUuid($uuid);
        if(!$recursoDoPlano || $recursoDoPlano->excluido){
            throw new Exception('RecursoDoPlano não encontrado');
        }
        return $recursoDoPlano;
    }

    public function create(array $data, string $uuidUsuarioLogado): RecursoDoPlanoModel {
        v::key('codigo', v::intType()->between(0,5))
          ->key('slug', v::stringType()->notEmpty())
          ->key('nome', v::stringType()->notEmpty())
          ->key('descricao', v::stringType()->notEmpty())
          ->key('cor', v::stringType()->notEmpty())
          ->check($data);

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
            throw new Exception('RecursoDoPlano não encontrado');
        }

        v::key('codigo', v::intType()->between(0,5), false)
          ->key('slug', v::stringType()->notEmpty(), false)
          ->key('nome', v::stringType()->notEmpty(), false)
          ->key('descricao', v::stringType()->notEmpty(), false)
          ->key('cor', v::stringType()->notEmpty(), false)
          ->check($data);

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        return $this->recursoDoPlanoRepository->update($recursoDoPlano, $data);
    }

    public function delete(string $uuid, string $uuidUsuarioLogado): bool {
        $recursoDoPlano = $this->recursoDoPlanoRepository->findByUuid($uuid);
        if (!$recursoDoPlano || $recursoDoPlano->excluido) {
            throw new Exception('RecursoDoPlano não encontrado');
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $uuidUsuarioLogado,
        ];

        return $this->recursoDoPlanoRepository->delete($recursoDoPlano, $data);
    }
}
