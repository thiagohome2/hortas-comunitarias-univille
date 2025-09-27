<?php

namespace App\Services;

use App\Models\HortaModel;
use App\Repositories\HortaRepository;
use Respect\Validation\Validator as v;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Ramsey\Uuid\Uuid;

class HortaService
{
    protected HortaRepository $hortaRepository;
    protected AssociacaoService $associacaoService;
    protected EnderecoService $enderecoService;

    public function __construct(HortaRepository $hortaRepository, AssociacaoService $associacaoService, EnderecoService $enderecoService)
    {
        $this->hortaRepository = $hortaRepository;
        $this->associacaoService = $associacaoService;
        $this->enderecoService = $enderecoService;
    }

    public function findAllWhere(): Collection
    {
        return $this->hortaRepository->findAllWhere(['excluido' => 0]);
    }
    
    public function findByUuid(string $uuid): ?HortaModel
    {
        $horta = $this->hortaRepository->findByUuid($uuid);
        if (!$horta || $horta->excluido) {
            throw new Exception('Horta não encontrada');
        }
        return $horta;
    }

 public function create(array $data, string $uuidUsuarioLogado): HortaModel
    {
        v::key('nome_da_horta', v::stringType()->notEmpty())
        ->key('percentual_taxa_associado', v::floatVal()->between(0, 100, true))
        ->key('associacao_vinculada_uuid', v::uuid())
        ->key('tipo_de_liberacao', V::intVal()->min(1)->max(3))
        ->key('endereco_uuid', v::uuid())
        ->assert($data);
        
        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);
        
        $data['uuid'] = Uuid::uuid1()->toString();
        $data['usuario_criador_uuid'] = $uuidUsuarioLogado;
        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        if (!empty($data['associacao_uuid'])){
            $this->associacaoService->findByUuid($data['associacao_uuid']);
        }

        if (!empty($data['endereco_uuid'])) {
            $this->enderecoService->findByUuid($data['endereco_uuid']);
        }

        return $this->hortaRepository->create($data);
    }


    public function update(string $uuid, array $data, string $uuidUsuarioLogado): HortaModel
    {
        $horta = $this->hortaRepository->findByUuid($uuid);
        if (!$horta || $horta->excluido) {
            throw new Exception('Horta não encontrada');
        }
        v::key('nome_da_horta', v::stringType()->notEmpty(), false)
        ->key('percentual_taxa_associado', v::floatVal()->between(0, 100, true), false)
        ->key('associacao_vinculada_uuid', v::uuid(), false)
        ->key('tipo_de_liberacao', V::intVal()->min(1)->max(3), false)
        ->key('endereco_uuid', v::uuid(), false)
        ->assert($data);

        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        return $this->hortaRepository->update($horta, $data);
    }

    
    public function delete(string $uuid, string $uuidUsuarioLogado): bool {
        $horta = $this->hortaRepository->findByUuid($uuid);
        if (!$horta || $horta->excluido) {
            throw new Exception('Horta não encontrado');
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $uuidUsuarioLogado,
        ];

        return $this->hortaRepository->delete($horta, $data) ? true : false;
    }
}
