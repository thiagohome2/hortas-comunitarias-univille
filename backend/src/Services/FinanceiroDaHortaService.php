<?php
namespace App\Services;

use App\Models\FinanceiroDaHortaModel;
use App\Repositories\FinanceiroDaHortaRepository;
use Respect\Validation\Validator as v;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Ramsey\Uuid\Uuid;

class FinanceiroDaHortaService
{
    protected FinanceiroDaHortaRepository $financeiroDaHortaRepository;
    protected CategoriaFinanceiraService $categoriaFinanceiraService;
    protected HortaService $hortaService;
    protected CargoService $cargoService;

    public function __construct(
        FinanceiroDaHortaRepository $financeiroDaHortaRepository,
        CategoriaFinanceiraService $categoriaFinanceiraService,
        HortaService $hortaService,
        CargoService $cargoService
    ){
        $this->financeiroDaHortaRepository = $financeiroDaHortaRepository;
        $this->categoriaFinanceiraService = $categoriaFinanceiraService;
        $this->hortaService = $hortaService;
        $this->cargoService = $cargoService;
    }

    public function findAllWhere(array $payloadUsuarioLogado): Collection {
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);

        switch ($cargo) {
            case 'admin_plataforma':
                return $this->financeiroDaHortaRepository->findAllWhere(['excluido' => 0]);

            case 'admin_associacao_geral':
                $hortas = $this->hortaService->findAllWhere([], $payloadUsuarioLogado);
                $hortasUuids = $hortas->pluck('uuid')->toArray();
                return $this->financeiroDaHortaRepository->findAllWhere(['excluido' => 0])
                    ->filter(fn($f) => in_array($f->horta_uuid, $hortasUuids));

            case 'admin_horta_geral':
                return $this->financeiroDaHortaRepository->findAllWhere([
                    'excluido' => 0,
                    'horta_uuid' => $payloadUsuarioLogado['horta_uuid']
                ]);

            default:
                // outros cargos só leem da horta do usuário
                return $this->financeiroDaHortaRepository->findAllWhere([
                    'excluido' => 0,
                    'horta_uuid' => $payloadUsuarioLogado['horta_uuid']
                ]);
        }
    }

    public function findByUuid(string $uuid, array $payloadUsuarioLogado): ?FinanceiroDaHortaModel {
        $financeiro = $this->financeiroDaHortaRepository->findByUuid($uuid);
        if(!$financeiro || $financeiro->excluido){
            throw new Exception('Financeiro da Horta não encontrado');
        }

        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        $horta = $this->hortaService->findByUuid($financeiro->horta_uuid, $payloadUsuarioLogado);

        switch ($cargo) {
            case 'admin_plataforma':
                return $financeiro;

            case 'admin_associacao_geral':
                if ($horta->associacao_vinculada_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você não tem permissão para acessar este lançamento");
                }
                return $financeiro;

            case 'admin_horta_geral':
                if ($financeiro->horta_uuid !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Você não tem permissão para acessar este lançamento");
                }
                return $financeiro;

            default:
                if ($financeiro->horta_uuid !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Você não tem permissão para acessar este lançamento");
                }
                return $financeiro;
        }
    }

    public function findByHortaUuid(string $hortaUuid, array $payloadUsuarioLogado): Collection {
        $horta = $this->hortaService->findByUuid($hortaUuid, $payloadUsuarioLogado);

        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        switch ($cargo) {
            case 'admin_plataforma':
                return $this->financeiroDaHortaRepository->findByHortaUuid($hortaUuid);

            case 'admin_associacao_geral':
                if ($horta->associacao_vinculada_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você não tem permissão para acessar lançamentos desta horta");
                }
                return $this->financeiroDaHortaRepository->findByHortaUuid($hortaUuid);

            case 'admin_horta_geral':
                if ($hortaUuid !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Você não tem permissão para acessar lançamentos desta horta");
                }
                return $this->financeiroDaHortaRepository->findByHortaUuid($hortaUuid);

            default:
                if ($hortaUuid !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Você não tem permissão para acessar lançamentos desta horta");
                }
                return $this->financeiroDaHortaRepository->findByHortaUuid($hortaUuid);
        }
    }

    public function create(array $data, array $payloadUsuarioLogado): FinanceiroDaHortaModel {
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);

        if (!in_array($cargo, ['admin_plataforma','admin_associacao_geral','admin_horta_geral'])) {
            throw new Exception("Permissão insuficiente | create");
        }

        v::key('valor_em_centavos', v::intType()->min(0))
          ->key('descricao_do_lancamento', v::stringType()->notEmpty())
          ->key('categoria_uuid', v::optional(v::uuid()))
          ->key('url_anexo', v::optional(v::url()))
          ->key('data_do_lancamento', v::date('Y-m-d'))
          ->key('horta_uuid', v::uuid())
          ->check($data);

        $horta = $this->hortaService->findByUuid($data['horta_uuid'], $payloadUsuarioLogado);

        if ($cargo === 'admin_associacao_geral' &&
            $horta->associacao_vinculada_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
            throw new Exception("Você só pode criar lançamentos para hortas da sua associação");
        }

        if ($cargo === 'admin_horta_geral' &&
            $data['horta_uuid'] !== $payloadUsuarioLogado['horta_uuid']) {
            throw new Exception("Você só pode criar lançamentos para sua própria horta");
        }

        if (!empty($data['categoria_uuid'])) {
            $this->categoriaFinanceiraService->findByUuid($data['categoria_uuid'], $payloadUsuarioLogado);
        }

        $guarded = ['uuid','usuario_criador_uuid','data_de_criacao','data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['uuid'] = Uuid::uuid1()->toString();
        $data['usuario_criador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];
        $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];

        return $this->financeiroDaHortaRepository->create($data);
    }

    public function update(string $uuid, array $data, array $payloadUsuarioLogado): FinanceiroDaHortaModel {
        $financeiro = $this->financeiroDaHortaRepository->findByUuid($uuid);
        if(!$financeiro || $financeiro->excluido){
            throw new Exception('Financeiro da Horta não encontrado');
        }

        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        if (!in_array($cargo, ['admin_plataforma','admin_associacao_geral','admin_horta_geral'])) {
            throw new Exception("Permissão insuficiente | update");
        }

        $horta = $this->hortaService->findByUuid($financeiro->horta_uuid, $payloadUsuarioLogado);

        if ($cargo === 'admin_associacao_geral' &&
            $horta->associacao_vinculada_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
            throw new Exception("Você não tem permissão para editar este lançamento");
        }

        if ($cargo === 'admin_horta_geral' &&
            $financeiro->horta_uuid !== $payloadUsuarioLogado['horta_uuid']) {
            throw new Exception("Você não tem permissão para editar este lançamento");
        }

        v::key('valor_em_centavos', v::intType()->min(0), false)
          ->key('descricao_do_lancamento', v::stringType()->notEmpty(), false)
          ->key('categoria_uuid', v::optional(v::uuid()), false)
          ->key('url_anexo', v::optional(v::url()), false)
          ->key('data_do_lancamento', v::date('Y-m-d'), false)
          ->key('horta_uuid', v::uuid(), false)
          ->check($data);

        if (!empty($data['categoria_uuid'])) {
            $this->categoriaFinanceiraService->findByUuid($data['categoria_uuid'], $payloadUsuarioLogado);
        }

        $guarded = ['uuid','usuario_criador_uuid','data_de_criacao','data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];

        return $this->financeiroDaHortaRepository->update($financeiro, $data);
    }

    public function delete(string $uuid, array $payloadUsuarioLogado): bool {
        $financeiro = $this->financeiroDaHortaRepository->findByUuid($uuid);
        if(!$financeiro || $financeiro->excluido){
            throw new Exception('Financeiro da Horta não encontrado');
        }

        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        if (!in_array($cargo, ['admin_plataforma','admin_associacao_geral','admin_horta_geral'])) {
            throw new Exception("Permissão insuficiente | delete");
        }

        $horta = $this->hortaService->findByUuid($financeiro->horta_uuid, $payloadUsuarioLogado);

        if ($cargo === 'admin_associacao_geral' &&
            $horta->associacao_vinculada_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
            throw new Exception("Você não tem permissão para deletar este lançamento");
        }

        if ($cargo === 'admin_horta_geral' &&
            $financeiro->horta_uuid !== $payloadUsuarioLogado['horta_uuid']) {
            throw new Exception("Você não tem permissão para deletar este lançamento");
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $payloadUsuarioLogado['usuario_uuid']
        ];

        return $this->financeiroDaHortaRepository->delete($financeiro, $data);
    }

    private function getCargoSlug(array $payloadUsuarioLogado): string {
        return $this->cargoService->findByUuidInternal($payloadUsuarioLogado['cargo_uuid'])->slug;
    }
}
