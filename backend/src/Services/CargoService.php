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

    public function findAllWhere(array $payloadUsuarioLogado): Collection {
        if(
            !$this->isCargoAdminPlataforma($payloadUsuarioLogado) &&
            !$this->isCargoAdminASsociacao($payloadUsuarioLogado) &&
            !$this->isCargoAdminHorta($payloadUsuarioLogado)
        ){
            throw new Exception("Permissão de cargo 0,1,2 necessária | findAllWhere");
        } 
        return $this->cargoRepository->findAllWhere(['excluido' => 0]);
    }

    public function findByUuid(string $uuid, array $payloadUsuarioLogado): ?CargoModel {
        if(
            !$this->isCargoAdminPlataforma($payloadUsuarioLogado) &&
            !$this->isCargoAdminASsociacao($payloadUsuarioLogado) &&
            !$this->isCargoAdminHorta($payloadUsuarioLogado)
        ){
            throw new Exception("Permissão de cargo 0,1,2 necessária | findByUuid");
        } 
        $cargo = $this->cargoRepository->findByUuid($uuid);
        if(!$cargo || $cargo->excluido){
            throw new Exception('Cargo não encontrado');
        }
        return $cargo;
    }

    public function findByUuidInternal(string $uuid): ?CargoModel {
        $cargo = $this->cargoRepository->findByUuid($uuid);
        if(!$cargo || $cargo->excluido){
            throw new Exception('Cargo não encontrado');
        }
        return $cargo;
    }

    public function create(array $data, array $payloadUsuarioLogado): CargoModel {
        if(!$this->isCargoAdminPlataforma($payloadUsuarioLogado)){
            throw new Exception("Permissão de cargo 0 necessária | create");
        }
        v::key('codigo', v::intType()->between(0,5))
          ->key('slug', v::stringType()->notEmpty())
          ->key('nome', v::stringType()->notEmpty())
          ->key('descricao', v::stringType()->notEmpty())
          ->key('cor', v::stringType()->notEmpty())
          ->check($data);

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['uuid'] = Uuid::uuid1()->toString();
        $data['usuario_criador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];
        $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];

        return $this->cargoRepository->create($data);
    }

    public function update(string $uuid, array $data, array $payloadUsuarioLogado): CargoModel {
        if(!$this->isCargoAdminPlataforma($payloadUsuarioLogado)){
            throw new Exception("Permissão de cargo 0 necessária | update");
        }
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

        $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];

        return $this->cargoRepository->update($cargo, $data);
    }

    public function delete(string $uuid, array $payloadUsuarioLogado): bool {
        $cargo = $this->cargoRepository->findByUuid($uuid);
        if (!$cargo || $cargo->excluido) {
            throw new Exception('Cargo não encontrado');
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $payloadUsuarioLogado['usuario_uuid'],
        ];

        return $this->cargoRepository->delete($cargo, $data);
    }

    private function isCargoAdminPlataforma(array $payloadUsuarioLogado): bool
    {
        return $this->findByUuidInternal($payloadUsuarioLogado['cargo_uuid'])->slug === "admin_plataforma";
    }

    private function isCargoAdminASsociacao(array $payloadUsuarioLogado): bool
    {
        return $this->findByUuidInternal($payloadUsuarioLogado['cargo_uuid'])->slug === "admin_associacao_geral";
    }
    private function isCargoAdminHorta(array $payloadUsuarioLogado): bool
    {
        return $this->findByUuidInternal($payloadUsuarioLogado['cargo_uuid'])->slug === "admin_horta";
    }
}
