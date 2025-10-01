<?php

namespace App\Services;

use App\Models\CanteiroModel;
use App\Repositories\CanteiroRepository;
use Respect\Validation\Validator as v;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Ramsey\Uuid\Uuid;

class CanteiroService
{
    protected CanteiroRepository $canteiroRepository;
    protected HortaService $hortaService; 
    protected UsuarioService $usuarioService; 
    protected CargoService $cargoService;

    public function __construct(
        CanteiroRepository $canteiroRepository, 
        HortaService $hortaService, 
        UsuarioService $usuarioService,
        CargoService $cargoService
    ) {
        $this->canteiroRepository = $canteiroRepository; 
        $this->hortaService = $hortaService;
        $this->usuarioService = $usuarioService;
        $this->cargoService = $cargoService;
    }

    public function findAllWhere(array $payloadUsuarioLogado): Collection
    {
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        echo "CARGO ===========> " . $cargo;
        switch ($cargo) {
            case 'admin_plataforma':
                return $this->canteiroRepository->findAllWhere(['excluido' => 0]);

            case 'admin_associacao_geral':
                // hortas da associação do usuário
                $hortas = $this->hortaService->findAllWhere([], $payloadUsuarioLogado);
                $hortasUuids = $hortas->pluck('uuid')->toArray();

                return $this->canteiroRepository->findAllWhere(['excluido' => 0])
                    ->filter(fn($canteiro) => in_array($canteiro->horta_uuid, $hortasUuids));

            case 'admin_horta_geral':
                return $this->canteiroRepository->findAllWhere([
                    'excluido' => 0,
                    'horta_uuid' => $payloadUsuarioLogado['horta_uuid']
                ]);

            default:
                // demais cargos só leitura, mas filtrando pela associação/horta
                return $this->canteiroRepository->findAllWhere(['excluido' => 0])
                    ->filter(function($canteiro) use ($payloadUsuarioLogado) {
                        $horta = $this->hortaService->findByUuid($canteiro->horta_uuid, $payloadUsuarioLogado);
                        return $horta->associacao_vinculada_uuid === $payloadUsuarioLogado['associacao_uuid'];
                    });
        }
    }
    
    public function findByUuid(string $uuid, array $payloadUsuarioLogado): ?CanteiroModel
    {
        $canteiro = $this->canteiroRepository->findByUuid($uuid);
        if (!$canteiro || $canteiro->excluido) {
            throw new Exception('Canteiro não encontrado');
        }

        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        $horta = $this->hortaService->findByUuid($canteiro->horta_uuid, $payloadUsuarioLogado);

        switch ($cargo) {
            case 'admin_plataforma':
                return $canteiro;

            case 'admin_associacao_geral':
                if ($horta->associacao_vinculada_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Sem permissão para acessar este canteiro");
                }
                return $canteiro;

            case 'admin_horta_geral':
                if ($canteiro->horta_uuid !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Sem permissão para acessar este canteiro");
                }
                return $canteiro;

            default:
                throw new Exception("Permissão insuficiente | findByUuid");
        }
    }

    public function create(array $data, array $payloadUsuarioLogado): CanteiroModel
    {
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        $this->assertCargoPodeAlterar($cargo);

        v::key('numero_identificador', v::stringType()->notEmpty())
          ->key('tamanho_m2', v::stringType()->notEmpty())
          ->key('horta_uuid', v::uuid())
          ->key('usuario_anterior_uuid', v::uuid(), false)
          ->assert($data);

        $horta = $this->hortaService->findByUuid($data['horta_uuid'], $payloadUsuarioLogado);

        // valida escopo
        $this->assertPertencimento($cargo, $horta, $payloadUsuarioLogado);

        if (!empty($data['usuario_anterior_uuid'])) {
            $this->usuarioService->findByUuid($data['usuario_anterior_uuid'], $payloadUsuarioLogado);
        }

        $guarded = ['uuid','usuario_criador_uuid','data_de_criacao','data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['uuid'] = Uuid::uuid1()->toString();
        $data['usuario_criador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];
        $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];

        return $this->canteiroRepository->create($data);
    }

    public function update(string $uuid, array $data, array $payloadUsuarioLogado): CanteiroModel
    {
        $canteiro = $this->canteiroRepository->findByUuid($uuid);
        if (!$canteiro || $canteiro->excluido) {
            throw new Exception('Canteiro não encontrado');
        }

        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        $this->assertCargoPodeAlterar($cargo);

        $horta = $this->hortaService->findByUuid($canteiro->horta_uuid, $payloadUsuarioLogado);
        $this->assertPertencimento($cargo, $horta, $payloadUsuarioLogado);

        v::key('numero_identificador', v::stringType()->notEmpty(), false)
          ->key('tamanho_m2', v::stringType()->notEmpty(), false)
          ->key('horta_uuid', v::uuid(), false)
          ->key('usuario_anterior_uuid', v::uuid(), false)
          ->assert($data);

        if (!empty($data['horta_uuid'])) {
            $novaHorta = $this->hortaService->findByUuid($data['horta_uuid'], $payloadUsuarioLogado);
            $this->assertPertencimento($cargo, $novaHorta, $payloadUsuarioLogado);
        }
        if (!empty($data['usuario_anterior_uuid'])) {
            $this->usuarioService->findByUuid($data['usuario_anterior_uuid'], $payloadUsuarioLogado);
        }

        $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];
        return $this->canteiroRepository->update($canteiro, $data);
    }
    
    public function delete(string $uuid, array $payloadUsuarioLogado): bool
    {
        $canteiro = $this->canteiroRepository->findByUuid($uuid);
        if (!$canteiro || $canteiro->excluido) {
            throw new Exception('Canteiro não encontrado');
        }

        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        $this->assertCargoPodeAlterar($cargo);

        $horta = $this->hortaService->findByUuid($canteiro->horta_uuid, $payloadUsuarioLogado);
        $this->assertPertencimento($cargo, $horta, $payloadUsuarioLogado);

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $payloadUsuarioLogado['usuario_uuid'],
        ];

        return $this->canteiroRepository->delete($canteiro, $data);
    }

    /** Helpers **/
    private function getCargoSlug(array $payloadUsuarioLogado): string
    {
        return $this->cargoService->findByUuidInternal($payloadUsuarioLogado['cargo_uuid'])->slug;
    }

    private function assertCargoPodeAlterar(string $cargo): void
    {
        if (!in_array($cargo, ['admin_plataforma','admin_associacao_geral','admin_horta_geral'])) {
            throw new Exception("Você não tem permissão para criar/alterar/deletar canteiros");
        }
    }

    private function assertPertencimento(string $cargo, $horta, array $payloadUsuarioLogado): void
    {
        switch ($cargo) {
            case 'admin_associacao_geral':
                if ($horta->associacao_vinculada_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Horta não pertence à sua associação");
                }
                break;

            case 'admin_horta_geral':
                if ($horta->uuid !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Horta não pertence a você");
                }
                break;
        }
    }
}
