<?php

namespace App\Services;

use App\Models\AssociacaoModel;
use App\Repositories\AssociacaoRepository;
use Respect\Validation\Validator as v;
use Illuminate\Database\Eloquent\Collection;
use Exception;
use Ramsey\Uuid\Uuid;

class AssociacaoService
{
    protected AssociacaoRepository $associacaoRepository;
    protected CargoService $cargoService;

    public function __construct(AssociacaoRepository $associacaoRepository,
    CargoService $cargoService)
    {
        $this->associacaoRepository = $associacaoRepository;
        $this->cargoService = $cargoService;
    }

    public function findAllWhere(): Collection
    {
        return $this->associacaoRepository->findAllWhere(['excluido' => 0]);
    }

    public function findByUuid(string $uuid): ?AssociacaoModel
    {
        $associacao = $this->associacaoRepository->findByUuid($uuid);
        if(!$associacao || $associacao->excluido){
            throw new Exception('Associação não encontrada');
        }
        return $associacao;
    }

    public function create(array $data, string $uuidUsuarioLogado): AssociacaoModel
    {
            if($uuidUsuarioLogado == "NEW_ACCOUNT"){
                v::key('cnpj', v::stringType()->notEmpty())
                ->key('razao_social', v::stringType()->notEmpty())
                ->key('nome_fantasia', v::stringType()->notEmpty())
                ->key('endereco_uuid', v::uuid(), false)
                ->key('url_estatuto_social_pdf', v::url(), false)
                ->key('url_ata_associacao_pdf', v::url())
                ->assert($data);

                $cnpj = $data['cnpj'];
                $associacao = $this->associacaoRepository->findByCnpj($cnpj);
                if ($associacao) {
                    throw new Exception('Associação com o CNPJ:' . $cnpj . ' já existe');
                }

                $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
                foreach ($guarded as $g) unset($data[$g]);

                $data['uuid'] = Uuid::uuid1()->toString();
                $data['usuario_criador_uuid'] = $uuidUsuarioLogado;
                $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;
                $data['status_aprovacao'] = 1;

                return $this->associacaoRepository->create($data);
            } else {
                v::key('cnpj', v::stringType()->notEmpty())
                ->key('razao_social', v::stringType()->notEmpty())
                ->key('nome_fantasia', v::stringType()->notEmpty())
                ->key('endereco_uuid', v::uuid())
                ->key('url_estatuto_social_pdf', v::url())
                ->key('url_ata_associacao_pdf', v::url())
                ->assert($data);

                $cnpj = $data['cnpj'];
                $associacao = $this->associacaoRepository->findByCnpj($cnpj);
                if ($associacao) {
                    throw new Exception('Associação com o CNPJ:' . $cnpj . ' já existe');
                }

                $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
                foreach ($guarded as $g) unset($data[$g]);

                $data['uuid'] = Uuid::uuid1()->toString();
                $data['usuario_criador_uuid'] = $uuidUsuarioLogado;
                $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;
                $data['status_aprovacao'] = 1;

                return $this->associacaoRepository->create($data);
            }
            
    }

    public function update(string $uuid, array $data, string $uuidUsuarioLogado): AssociacaoModel
    {
        $associacao = $this->associacaoRepository->findByUuid($uuid);
        if (!$associacao || $associacao->excluido) {
            throw new Exception('Associação não encontrada');
        }

        v::key('cnpj', v::stringType()->notEmpty(), false)
        ->key('razao_social', v::stringType()->notEmpty(), false)
        ->key('nome_fantasia', v::stringType()->notEmpty(), false)
        ->key('endereco_uuid', v::uuid())
        ->key('url_estatuto_social_pdf', v::url(), false)
        ->key('url_ata_associacao_pdf',v::url(), false)
        ->key('status_aprovacao', v::stringType()->notEmpty(), false)
        ->assert($data);
        $cnpj = $data['cnpj'];
        
        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        return $this->associacaoRepository->update($associacao, $data);
    }

    public function delete(string $uuid, string $uuidUsuarioLogado)
    {
        $associacao = $this->associacaoRepository->findByUuid($uuid);
        if (!$associacao || $associacao->excluido) {
            throw new Exception('Associação não encontrada');
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $uuidUsuarioLogado,
        ];

        return $this->associacaoRepository->delete($associacao, $data) ? true : false;
    }
}
