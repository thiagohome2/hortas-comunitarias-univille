<?php

namespace App\Services;

use App\Models\FilaDeUsuarioModel;
use App\Repositories\FilaDeUsuarioRepository;
use Respect\Validation\Validator as v;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Ramsey\Uuid\Uuid;

class FilaDeUsuarioService
{
    protected FilaDeUsuarioRepository $filaDeUsuarioRepository;
    protected UsuarioService $usuarioService;
    protected HortaService $hortaService;
    protected CargoService $cargoService;

    public function __construct(
        FilaDeUsuarioRepository $filaDeUsuarioRepository,
        UsuarioService $usuarioService,
        HortaService $hortaService,
        CargoService $cargoService
    ) {
        $this->filaDeUsuarioRepository = $filaDeUsuarioRepository;
        $this->usuarioService = $usuarioService;
        $this->hortaService = $hortaService;
        $this->cargoService = $cargoService;
    }

    public function findAllWhere(array $payloadUsuarioLogado): Collection
    {
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);

        switch ($cargo) {
            case 'admin_plataforma':
                return $this->filaDeUsuarioRepository->findAllWhere(['excluido' => 0]);

            case 'admin_associacao_geral':
                // buscar hortas da associação do usuário
                $hortas = $this->hortaService->findAllWhere([], $payloadUsuarioLogado);
                $hortasUuids = $hortas->pluck('uuid')->toArray();
                return $this->filaDeUsuarioRepository->findAllWhere(['excluido' => 0])
                    ->filter(fn($fila) => in_array($fila->horta_uuid, $hortasUuids));

            case 'admin_horta_geral':
                return $this->filaDeUsuarioRepository->findAllWhere([
                    'excluido' => 0,
                    'horta_uuid' => $payloadUsuarioLogado['horta_uuid']
                ]);

            default:
                // demais cargos → apenas filas ligadas a hortas permitidas
                return $this->filaDeUsuarioRepository->findAllWhere(['excluido' => 0])
                    ->filter(fn($fila) => $fila->horta_uuid === $payloadUsuarioLogado['horta_uuid']);
        }
    }

    public function findByUuid(string $uuid, array $payloadUsuarioLogado): ?FilaDeUsuarioModel
    {
        $fila = $this->filaDeUsuarioRepository->findByUuid($uuid);
        if (!$fila || $fila->excluido) {
            throw new Exception('Fila de usuário não encontrada');
        }

        $cargo = $this->getCargoSlug($payloadUsuarioLogado);

        switch ($cargo) {
            case 'admin_plataforma':
                return $fila;

            case 'admin_associacao_geral':
                $horta = $this->hortaService->findByUuid($fila->horta_uuid, $payloadUsuarioLogado);
                if ($horta->associacao_vinculada_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você não tem permissão para acessar esta fila");
                }
                return $fila;

            case 'admin_horta_geral':
                if ($fila->horta_uuid !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Você não tem permissão para acessar esta fila");
                }
                return $fila;

            default:
                if ($fila->horta_uuid !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Você não tem permissão para acessar esta fila");
                }
                return $fila;
        }
    }

    public function findByHortaUuid(string $hortaUuid, array $payloadUsuarioLogado): Collection
    {
        $horta = $this->hortaService->findByUuid($hortaUuid, $payloadUsuarioLogado);

        $cargo = $this->getCargoSlug($payloadUsuarioLogado);

        switch ($cargo) {
            case 'admin_plataforma':
                $fila = $this->filaDeUsuarioRepository->findByHortaUuid($hortaUuid);
                break;

            case 'admin_associacao_geral':
                if ($horta->associacao_vinculada_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você não tem permissão para acessar filas desta horta");
                }
                $fila = $this->filaDeUsuarioRepository->findByHortaUuid($hortaUuid);
                break;

            case 'admin_horta_geral':
                if ($hortaUuid !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Você não tem permissão para acessar filas desta horta");
                }
                $fila = $this->filaDeUsuarioRepository->findByHortaUuid($hortaUuid);
                break;

            default:
                if ($hortaUuid !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Você não tem permissão para acessar filas desta horta");
                }
                $fila = $this->filaDeUsuarioRepository->findByHortaUuid($hortaUuid);
        }

        if ($fila->isEmpty()) {
            throw new Exception('Nenhum usuário na fila para esta horta');
        }
        return $fila;
    }

    public function findByUsuarioUuid(string $usuarioUuid, array $payloadUsuarioLogado): Collection
    {
        $this->usuarioService->findByUuid($usuarioUuid, $payloadUsuarioLogado);

        $fila = $this->filaDeUsuarioRepository->findByUsuarioUuid($usuarioUuid);

        // todos os cargos só podem ver se a fila pertencer à horta correta
        $fila = $fila->filter(function($f) use ($payloadUsuarioLogado) {
            return $f->horta_uuid === $payloadUsuarioLogado['horta_uuid'];
        });

        if ($fila->isEmpty()) {
            throw new Exception('Usuário não encontrado na fila ou sem permissão de acesso');
        }
        return $fila;
    }

    public function create(array $data, array $payloadUsuarioLogado): FilaDeUsuarioModel
    {
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);

        if (!in_array($cargo, ['admin_plataforma', 'admin_associacao_geral', 'admin_horta_geral'])) {
            throw new Exception("Permissão insuficiente | create");
        }

        v::key('usuario_uuid', v::uuid())
          ->key('horta_uuid', v::uuid())
          ->check($data);

        $this->usuarioService->findByUuid($data['usuario_uuid'], $payloadUsuarioLogado);
        $horta = $this->hortaService->findByUuid($data['horta_uuid'], $payloadUsuarioLogado);

        switch ($cargo) {
            case 'admin_associacao_geral':
                if ($horta->associacao_vinculada_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você só pode criar filas em hortas da sua associação");
                }
                break;

            case 'admin_horta_geral':
                if ($data['horta_uuid'] !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Você só pode criar filas na sua horta");
                }
                break;
        }

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao', 'ordem'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['uuid'] = Uuid::uuid1()->toString();
        $data['usuario_criador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];
        $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];

        return $this->filaDeUsuarioRepository->create($data);
    }

    public function update(string $uuid, array $data, array $payloadUsuarioLogado): FilaDeUsuarioModel
    {
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        if (!in_array($cargo, ['admin_plataforma', 'admin_associacao_geral', 'admin_horta_geral'])) {
            throw new Exception("Permissão insuficiente | update");
        }

        $fila = $this->filaDeUsuarioRepository->findByUuid($uuid);
        if (!$fila || $fila->excluido) {
            throw new Exception('Fila de usuário não encontrada');
        }

        $horta = $this->hortaService->findByUuid($fila->horta_uuid, $payloadUsuarioLogado);

        switch ($cargo) {
            case 'admin_associacao_geral':
                if ($horta->associacao_vinculada_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você não pode atualizar filas de outra associação");
                }
                break;

            case 'admin_horta_geral':
                if ($fila->horta_uuid !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Você não pode atualizar filas de outra horta");
                }
                break;
        }

        v::key('usuario_uuid', v::uuid(), false)
          ->key('horta_uuid', v::uuid(), false)
          ->key('ordem', v::optional(v::intType()), false)
          ->check($data);

        if (!empty($data['usuario_uuid'])) {
            $this->usuarioService->findByUuid($data['usuario_uuid'], $payloadUsuarioLogado);
        }
        if (!empty($data['horta_uuid'])) {
            $this->hortaService->findByUuid($data['horta_uuid'], $payloadUsuarioLogado);
        }

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);
        $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];

        return $this->filaDeUsuarioRepository->update($fila, $data);
    }

    public function delete(string $uuid, array $payloadUsuarioLogado): bool
    {
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        if (!in_array($cargo, ['admin_plataforma', 'admin_associacao_geral', 'admin_horta_geral'])) {
            throw new Exception("Permissão insuficiente | delete");
        }

        $fila = $this->filaDeUsuarioRepository->findByUuid($uuid);
        if (!$fila || $fila->excluido) {
            throw new Exception('Fila de usuário não encontrada');
        }

        $horta = $this->hortaService->findByUuid($fila->horta_uuid, $payloadUsuarioLogado);

        switch ($cargo) {
            case 'admin_associacao_geral':
                if ($horta->associacao_vinculada_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você não pode deletar filas de outra associação");
                }
                break;

            case 'admin_horta_geral':
                if ($fila->horta_uuid !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Você não pode deletar filas de outra horta");
                }
                break;
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $payloadUsuarioLogado['usuario_uuid']
        ];

        return $this->filaDeUsuarioRepository->delete($fila, $data);
    }

    private function getCargoSlug(array $payloadUsuarioLogado): string
    {
        return $this->cargoService->findByUuidInternal($payloadUsuarioLogado['cargo_uuid'])->slug;
    }
}
