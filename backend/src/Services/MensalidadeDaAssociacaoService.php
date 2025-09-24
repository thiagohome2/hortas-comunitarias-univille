<?php
namespace App\Services;

use App\Models\MensalidadeDaAssociacaoModel;
use App\Repositories\MensalidadeDaAssociacaoRepository;
use Respect\Validation\Validator as v;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Ramsey\Uuid\Uuid;

class MensalidadeDaAssociacaoService
{
    protected $mensalidadeDaAssociacaoRepository;

    public function __construct(MensalidadeDaAssociacaoRepository $mensalidadeDaAssociacaoRepository){
        $this->mensalidadeDaAssociacaoRepository = $mensalidadeDaAssociacaoRepository;
    }

    public function findAllWhere(): Collection {
        return $this->mensalidadeDaAssociacaoRepository->findAllWhere(['excluido' => 0]);
    }

    public function findByUuid(string $uuid): ?MensalidadeDaAssociacaoModel {
        $mensalidadeDaAssociacao = $this->mensalidadeDaAssociacaoRepository->findByUuid($uuid);
        if(!$mensalidadeDaAssociacao || $mensalidadeDaAssociacao->excluido){
            throw new Exception('Mensalidade da Associação não encontrado');
        }
        return $mensalidadeDaAssociacao;
    }

    public function create(array $data, string $uuidUsuarioLogado): MensalidadeDaAssociacaoModel {
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

        return $this->mensalidadeDaAssociacaoRepository->create($data);
    }

    public function update(string $uuid, array $data, string $uuidUsuarioLogado): MensalidadeDaAssociacaoModel {
        $mensalidadeDaAssociacao = $this->mensalidadeDaAssociacaoRepository->findByUuid($uuid);
        if(!$mensalidadeDaAssociacao || $mensalidadeDaAssociacao->excluido){
            throw new Exception('Mensalidade da Associação não encontrado');
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

        return $this->mensalidadeDaAssociacaoRepository->update($mensalidadeDaAssociacao, $data);
    }

    public function delete(string $uuid, string $uuidUsuarioLogado): bool {
        $mensalidadeDaAssociacao = $this->mensalidadeDaAssociacaoRepository->findByUuid($uuid);
        if (!$mensalidadeDaAssociacao || $mensalidadeDaAssociacao->excluido) {
            throw new Exception('Mensalidade da Associação não encontrado');
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $uuidUsuarioLogado,
        ];

        return $this->mensalidadeDaAssociacaoRepository->delete($mensalidadeDaAssociacao, $data);
    }
}
