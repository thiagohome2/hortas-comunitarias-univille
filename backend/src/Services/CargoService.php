<?php
namespace App\Services;

use App\Models\CargoModel;
use App\Repositories\CargoRepository;
use Respect\Validation\Validator as v;
use Psr\Http\Message\ServerRequestInterface as Request;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Ramsey\Uuid\Uuid;

class CargoService
{
    protected $cargoRepository;

    public function __construct(CargoRepository $cargoRepository){
        $this->cargoRepository = $cargoRepository;
    }

    public function findAllWhere(): Collection {
        return $this->cargoRepository->findAllWhere(['excluido' => 0]);
    }

    public function findByUuid(string $uuid): ?CargoModel {
        $cargo = $this->cargoRepository->findByUuid($uuid);
        if(!$cargo || $cargo->excluido){
            throw new Exception('Cargo não encontrado');
        }
        return $cargo;
    }

    public function create(array $data, string $uuidUsuarioLogado): CargoModel {
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

        return $this->cargoRepository->create($data);
    }

    public function update(string $uuid, array $data, string $uuidUsuarioLogado): CargoModel {
        $cargo = $this->cargoRepository->findByUuid($uuid);
        if(!$cargo || $cargo->excluido){
            throw new Exception('Cargo não encontrado');
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

        return $this->cargoRepository->update($cargo, $data);
    }

    public function delete(string $uuid, string $uuidUsuarioLogado): bool {
        $cargo = $this->cargoRepository->findByUuid($uuid);
        if (!$cargo || $cargo->excluido) {
            throw new Exception('Cargo não encontrado');
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $uuidUsuarioLogado,
        ];

        return $this->cargoRepository->delete($cargo, $data);
    }
}
