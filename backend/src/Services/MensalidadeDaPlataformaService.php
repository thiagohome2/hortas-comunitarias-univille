<?php
namespace App\Services;

use App\Models\MensalidadeDaPlataformaModel;
use App\Repositories\MensalidadeDaPlataformaRepository;
use Respect\Validation\Validator as v;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Ramsey\Uuid\Uuid;

class MensalidadeDaPlataformaService
{
    protected $mensalidadeDaPlataformaRepository;

    public function __construct(MensalidadeDaPlataformaRepository $mensalidadeDaPlataformaRepository){
        $this->mensalidadeDaPlataformaRepository = $mensalidadeDaPlataformaRepository;
    }

    public function findAllWhere(): Collection {
        return $this->mensalidadeDaPlataformaRepository->findAllWhere(['excluido' => 0]);
    }

    public function findByUuid(string $uuid): ?MensalidadeDaPlataformaModel {
        $mensalidadeDaPlataforma = $this->mensalidadeDaPlataformaRepository->findByUuid($uuid);
        if(!$mensalidadeDaPlataforma || $mensalidadeDaPlataforma->excluido){
            throw new Exception('Mensalidade da Plataforma não encontrado');
        }
        return $mensalidadeDaPlataforma;
    }

    public function create(array $data, string $uuidUsuarioLogado): MensalidadeDaPlataformaModel {
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

        return $this->mensalidadeDaPlataformaRepository->create($data);
    }

    public function update(string $uuid, array $data, string $uuidUsuarioLogado): MensalidadeDaPlataformaModel {
        $mensalidadeDaPlataforma = $this->mensalidadeDaPlataformaRepository->findByUuid($uuid);
        if(!$mensalidadeDaPlataforma || $mensalidadeDaPlataforma->excluido){
            throw new Exception('Mensalidade da Plataforma não encontrado');
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

        return $this->mensalidadeDaPlataformaRepository->update($mensalidadeDaPlataforma, $data);
    }

    public function delete(string $uuid, string $uuidUsuarioLogado): bool {
        $mensalidadeDaPlataforma = $this->mensalidadeDaPlataformaRepository->findByUuid($uuid);
        if (!$mensalidadeDaPlataforma || $mensalidadeDaPlataforma->excluido) {
            throw new Exception('Mensalidade da Plataforma não encontrado');
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $uuidUsuarioLogado,
        ];

        return $this->mensalidadeDaPlataformaRepository->delete($mensalidadeDaPlataforma, $data);
    }
}
