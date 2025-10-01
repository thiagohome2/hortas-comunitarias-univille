<?php

namespace App\Services;

use App\Models\CanteiroEUsuarioModel;
use App\Repositories\CanteiroEUsuarioRepository;
use Respect\Validation\Validator as v;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Ramsey\Uuid\Uuid;

class CanteiroEUsuarioService
{
    protected CanteiroEUsuarioRepository $canteiroEUsuarioRepository;
    protected UsuarioService $usuarioService;
    protected CanteiroService $canteiroService;
    protected CargoService $cargoService;

    public function __construct(
        CanteiroEUsuarioRepository $canteiroEUsuarioRepository, 
        CargoService $cargoService, 
        CanteiroService $canteiroService, 
        UsuarioService $usuarioService
    ) {
        $this->canteiroEUsuarioRepository = $canteiroEUsuarioRepository;
        $this->usuarioService = $usuarioService;
        $this->canteiroService = $canteiroService;
        $this->cargoService = $cargoService;
    }

    public function findAllWhere(array $payloadUsuarioLogado): Collection
    {
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);

        switch ($cargo) {
            case 'admin_plataforma':
                return $this->canteiroEUsuarioRepository->findAllWhere(['excluido' => 0]);

            case 'admin_associacao_geral':
                // usuários e canteiros vinculados à associação do usuário logado
                $usuarios = $this->usuarioService->findAllWhere(['associacao_uuid' => $payloadUsuarioLogado['associacao_uuid']]);
                $usuariosUuids = $usuarios->pluck('uuid')->toArray();
                return $this->canteiroEUsuarioRepository->findAllWhere(['excluido' => 0])
                    ->filter(fn($rel) => in_array($rel->usuario_uuid, $usuariosUuids));

            case 'admin_horta_geral':
                // apenas canteiros da sua horta
                $canteiros = $this->canteiroService->findAllWhere(['horta_uuid' => $payloadUsuarioLogado['horta_uuid']]);
                $canteirosUuids = $canteiros->pluck('uuid')->toArray();
                return $this->canteiroEUsuarioRepository->findAllWhere(['excluido' => 0])
                    ->filter(fn($rel) => in_array($rel->canteiro_uuid, $canteirosUuids));

            default:
                // leitura apenas limitada ao próprio usuário
                return $this->canteiroEUsuarioRepository->findAllWhere([
                    'excluido' => 0,
                    'usuario_uuid' => $payloadUsuarioLogado['usuario_uuid']
                ]);
        }
    }

    public function findByUuid(string $uuid, array $payloadUsuarioLogado): ?CanteiroEUsuarioModel
    {
        $rel = $this->canteiroEUsuarioRepository->findByUuid($uuid);
        if (!$rel || $rel->excluido) {
            throw new Exception('Canteiro + usuário não encontrado');
        }

        $cargo = $this->getCargoSlug($payloadUsuarioLogado);

        switch ($cargo) {
            case 'admin_plataforma':
                return $rel;

            case 'admin_associacao_geral':
                $usuario = $this->usuarioService->findByUuid($rel->usuario_uuid, $payloadUsuarioLogado);
                if ($usuario->associacao_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você não tem permissão para acessar este vínculo");
                }
                return $rel;

            case 'admin_horta_geral':
                $canteiro = $this->canteiroService->findByUuid($rel->canteiro_uuid, $payloadUsuarioLogado);
                if ($canteiro->horta_uuid !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Você não tem permissão para acessar este vínculo");
                }
                return $rel;

            default:
                if ($rel->usuario_uuid !== $payloadUsuarioLogado['usuario_uuid']) {
                    throw new Exception("Você não tem permissão para acessar este vínculo");
                }
                return $rel;
        }
    }

    public function create(array $data, array $payloadUsuarioLogado): CanteiroEUsuarioModel
    {
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        if (!in_array($cargo, ['admin_plataforma','admin_associacao_geral','admin_horta_geral'])) {
            throw new Exception("Permissão insuficiente | create");
        }

        v::key('usuario_uuid', v::uuid())
          ->key('canteiro_uuid', v::uuid())
          ->key('tipo_vinculo', v::intVal()->min(1)->max(3))
          ->key('data_inicio', v::date())
          ->key('data_fim', v::optional(v::date()))
          ->key('percentual_responsabilidade', v::floatVal()->between(0, 100, true))
          ->key('observacoes', v::optional(v::stringType()))
          ->assert($data);

        $guarded = ['uuid','usuario_criador_uuid','data_de_criacao','data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['uuid'] = Uuid::uuid1()->toString();
        $data['ativo'] = 1;
        $data['usuario_criador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];
        $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];

        $canteiro = $this->canteiroService->findByUuid($data['canteiro_uuid'], $payloadUsuarioLogado);
        $usuario = $this->usuarioService->findByUuid($data['usuario_uuid'], $payloadUsuarioLogado);

        switch ($cargo) {
            case 'admin_associacao_geral':
                if ($usuario->associacao_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você só pode vincular usuários da sua associação");
                }
                break;

            case 'admin_horta_geral':
                if ($canteiro->horta_uuid !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Você só pode vincular usuários em canteiros da sua horta");
                }
                break;
        }

        return $this->canteiroEUsuarioRepository->create($data);
    }

    public function update(string $uuid, array $data, array $payloadUsuarioLogado): CanteiroEUsuarioModel
    {
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        if (!in_array($cargo, ['admin_plataforma','admin_associacao_geral','admin_horta_geral'])) {
            throw new Exception("Permissão insuficiente | update");
        }

        $rel = $this->canteiroEUsuarioRepository->findByUuid($uuid);
        if (!$rel || $rel->excluido) {
            throw new Exception('Canteiro + usuário não encontrado');
        }

        $canteiro = $this->canteiroService->findByUuid($rel->canteiro_uuid, $payloadUsuarioLogado);
        $usuario = $this->usuarioService->findByUuid($rel->usuario_uuid, $payloadUsuarioLogado);

        switch ($cargo) {
            case 'admin_associacao_geral':
                if ($usuario->associacao_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você não pode editar vínculos de outra associação");
                }
                break;

            case 'admin_horta_geral':
                if ($canteiro->horta_uuid !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Você não pode editar vínculos de outra horta");
                }
                break;
        }

        v::key('usuario_uuid', v::uuid(), false)
          ->key('canteiro_uuid', v::uuid(), false)
          ->key('tipo_vinculo', v::intVal()->min(1)->max(3), false)
          ->key('data_inicio', v::date(), false)
          ->key('data_fim', v::optional(v::date()), false)
          ->key('percentual_responsabilidade', v::floatVal()->between(0, 100, true), false)
          ->key('observacoes', v::optional(v::stringType()), false)
          ->key('ativo', v::boolVal(), false)
          ->assert($data);

        $guarded = ['uuid','usuario_criador_uuid','data_de_criacao','data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];

        return $this->canteiroEUsuarioRepository->update($rel, $data);
    }

    public function delete(string $uuid, array $payloadUsuarioLogado): bool
    {
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        if (!in_array($cargo, ['admin_plataforma','admin_associacao_geral','admin_horta_geral'])) {
            throw new Exception("Permissão insuficiente | delete");
        }

        $rel = $this->canteiroEUsuarioRepository->findByUuid($uuid);
        if (!$rel || $rel->excluido) {
            throw new Exception('Canteiro + usuário não encontrado');
        }

        $canteiro = $this->canteiroService->findByUuid($rel->canteiro_uuid, $payloadUsuarioLogado);
        $usuario = $this->usuarioService->findByUuid($rel->usuario_uuid, $payloadUsuarioLogado);

        switch ($cargo) {
            case 'admin_associacao_geral':
                if ($usuario->associacao_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você não pode excluir vínculos de outra associação");
                }
                break;

            case 'admin_horta_geral':
                if ($canteiro->horta_uuid !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Você não pode excluir vínculos de outra horta");
                }
                break;
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $payloadUsuarioLogado['usuario_uuid']
        ];

        return $this->canteiroEUsuarioRepository->delete($rel, $data);
    }

    private function getCargoSlug(array $payloadUsuarioLogado): string
    {
        return $this->cargoService->findByUuidInternal($payloadUsuarioLogado['cargo_uuid'])->slug;
    } 
}
