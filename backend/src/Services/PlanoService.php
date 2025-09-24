<?php
namespace App\Services;

use App\Models\PlanoModel;
use App\Repositories\PlanoRepository;
use Respect\Validation\Validator as v;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Ramsey\Uuid\Uuid;

class PlanoService
{
    protected $planoRepository;

    public function __construct(PlanoRepository $planoRepository){
        $this->planoRepository = $planoRepository;
    }

    public function findAllWhere(): Collection {
        return $this->planoRepository->findAllWhere(['excluido' => 0]);
    }

    public function findByUuid(string $uuid): ?PlanoModel {
        $plano = $this->planoRepository->findByUuid($uuid);
        if(!$plano || $plano->excluido){
            throw new Exception('Plano não encontrado');
        }
        return $plano;
    }

    public function create(array $data, string $uuidUsuarioLogado): PlanoModel {
        v::key('codigo', v::stringType()->notEmpty())
          ->key('slug', v::stringType()->notEmpty())
          ->key('nome', v::stringType()->notEmpty())
          ->key('descricao', v::stringType()->notEmpty())
          ->check($data);

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['uuid'] = Uuid::uuid1()->toString();
        $data['usuario_criador_uuid'] = $uuidUsuarioLogado;
        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        return $this->planoRepository->create($data);
    }

    public function update(string $uuid, array $data, string $uuidUsuarioLogado): PlanoModel {
        $plano = $this->planoRepository->findByUuid($uuid);
        if(!$plano || $plano->excluido){
            throw new Exception('Plano não encontrado');
        }

        v::key('codigo', v::stringType()->notEmpty(), false)
          ->key('slug', v::stringType()->notEmpty(), false)
          ->key('nome', v::stringType()->notEmpty(), false)
          ->key('descricao', v::stringType()->notEmpty(), false)
          ->check($data);

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        return $this->planoRepository->update($plano, $data);
    }

    public function delete(string $uuid, string $uuidUsuarioLogado): bool {
        $plano = $this->planoRepository->findByUuid($uuid);
        if (!$plano || $plano->excluido) {
            throw new Exception('Plano não encontrado');
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $uuidUsuarioLogado,
        ];

        return $this->planoRepository->delete($plano, $data);
    }
}
