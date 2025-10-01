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

    public function __construct(
        AssociacaoRepository $associacaoRepository,
        CargoService $cargoService
    ) {
        $this->associacaoRepository = $associacaoRepository;
        $this->cargoService = $cargoService;
    }

    public function findAllWhere(array $payloadUsuarioLogado): Collection
    {
        if (!$this->isCargoAdminPlataforma($payloadUsuarioLogado)) {
            throw new Exception("Permissão de cargo 0 necessária | findAllWhere");
        } else {
            return $this->associacaoRepository->findAllWhere(['excluido' => 0]);
        }
    }

    public function findByUuid(string $uuid, array $payloadUsuarioLogado): ?AssociacaoModel
    {
        if (
            !$this->isCargoAdminPlataforma($payloadUsuarioLogado)
            && $payloadUsuarioLogado['usuario_uuid'] !== "NEW_ACCOUNT"
        ) {
            throw new Exception("Permissão de cargo 0 necessária | findByUuid");
        } else {
            $associacao = $this->associacaoRepository->findByUuid($uuid);
            if (!$associacao || $associacao->excluido) {
                throw new Exception('Associação não encontrada');
            }
            return $associacao;
        }
    }

    public function create(array $data, array $payloadUsuarioLogado): AssociacaoModel
    {
        if ($payloadUsuarioLogado['usuario_uuid'] == "NEW_ACCOUNT") {
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
            $data['usuario_criador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];
            $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];
            $data['status_aprovacao'] = 1;

            return $this->associacaoRepository->create($data);
        } else {
            if ($this->isCargoAdminPlataforma($payloadUsuarioLogado)) {
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
                $data['usuario_criador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];
                $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];
                $data['status_aprovacao'] = 1;

                return $this->associacaoRepository->create($data);
            } else {
                throw new Exception("Permissão de cargo 0 necessária | create");
            }
        }
    }

    public function update(string $uuid, array $data, array $payloadUsuarioLogado): AssociacaoModel
    {
        if ($this->isCargoAdminPlataforma($payloadUsuarioLogado)) {

            $associacao = $this->associacaoRepository->findByUuid($uuid);
            if (!$associacao || $associacao->excluido) {
                throw new Exception('Associação não encontrada');
            }

            v::key('cnpj', v::stringType()->notEmpty(), false)
                ->key('razao_social', v::stringType()->notEmpty(), false)
                ->key('nome_fantasia', v::stringType()->notEmpty(), false)
                ->key('endereco_uuid', v::uuid())
                ->key('url_estatuto_social_pdf', v::url(), false)
                ->key('url_ata_associacao_pdf', v::url(), false)
                ->key('status_aprovacao', v::stringType()->notEmpty(), false)
                ->assert($data);
            $cnpj = $data['cnpj'];

            $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
            foreach ($guarded as $g) unset($data[$g]);

            $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];

            return $this->associacaoRepository->update($associacao, $data);
        } else {
            throw new Exception("Permissão de cargo 0 necessária | update");
        }
    }

    public function delete(string $uuid, array $payloadUsuarioLogado)
    {
        if (!$this->isCargoAdminPlataforma($payloadUsuarioLogado)) {
            throw new Exception("Permissão de cargo 0 necessária | delete");
        } else {
            $associacao = $this->associacaoRepository->findByUuid($uuid);
            if (!$associacao || $associacao->excluido) {
                throw new Exception('Associação não encontrada');
            }

            $data = [
                'excluido' => 1,
                'usuario_alterador_uuid' => $payloadUsuarioLogado['usuario_uuid'],
            ];

            return $this->associacaoRepository->delete($associacao, $data) ? true : false;
        }
    }

    private function isCargoAdminPlataforma(array $payloadUsuarioLogado): bool
    {
        return $this->cargoService->findByUuidInternal($payloadUsuarioLogado['cargo_uuid'])->slug === "admin_plataforma";
    }
}
