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

    public function __construct(
        FilaDeUsuarioRepository $filaDeUsuarioRepository,
        UsuarioService $usuarioService,
        HortaService $hortaService
    ) {
        $this->filaDeUsuarioRepository = $filaDeUsuarioRepository;
        $this->usuarioService = $usuarioService;
        $this->hortaService = $hortaService;
    }

    public function findAllWhere(): Collection
    {
        return $this->filaDeUsuarioRepository->findAllWhere(['excluido' => 0]);
    }

    public function findByUuid(string $uuid): ?FilaDeUsuarioModel
    {
        $fila = $this->filaDeUsuarioRepository->findByUuid($uuid);
        if (!$fila || $fila->excluido) {
            throw new Exception('Fila de usuário não encontrada');
        }
        return $fila;
    }

    public function findByHortaUuid(string $hortaUuid): Collection
    {
        $this->hortaService->findByUuid($hortaUuid);
        $fila = $this->filaDeUsuarioRepository->findByHortaUuid($hortaUuid);
        if ($fila->isEmpty()) {
            throw new Exception('Nenhum usuário na fila para esta horta');
        }
        return $fila;
    }

    public function findByUsuarioUuid(string $usuarioUuid): Collection
    {
        $this->usuarioService->findByUuid($usuarioUuid);
        $fila = $this->filaDeUsuarioRepository->findByUsuarioUuid($usuarioUuid);
        if ($fila->isEmpty()) {
            throw new Exception('Usuário não encontrado na fila');
        }
        return $fila;
    }

    public function create(array $data, string $uuidUsuarioLogado): FilaDeUsuarioModel
    {
        v::key('usuario_uuid', v::uuid())
          ->key('horta_uuid', v::uuid())
          ->check($data);

        $this->usuarioService->findByUuid($data['usuario_uuid']);
        $this->hortaService->findByUuid($data['horta_uuid']);

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao', 'ordem'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['uuid'] = Uuid::uuid1()->toString();
        $data['usuario_criador_uuid'] = $uuidUsuarioLogado;
        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        return $this->filaDeUsuarioRepository->create($data);
    }

    public function update(string $uuid, array $data, string $uuidUsuarioLogado): FilaDeUsuarioModel
    {
        $fila = $this->filaDeUsuarioRepository->findByUuid($uuid);
        if (!$fila || $fila->excluido) {
            throw new Exception('Fila de usuário não encontrada');
        }

        v::key('usuario_uuid', v::uuid(), false)
          ->key('horta_uuid', v::uuid(), false)
          ->key('ordem', v::optional(v::intType()), false)
          ->check($data);

        if (!empty($data['usuario_uuid'])) {
            $this->usuarioService->findByUuid($data['usuario_uuid']);
        }
        if (!empty($data['horta_uuid'])) {
            $this->hortaService->findByUuid($data['horta_uuid']);
        }

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);
        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        return $this->filaDeUsuarioRepository->update($fila, $data);
    }

    public function delete(string $uuid, string $uuidUsuarioLogado): bool
    {
        $fila = $this->filaDeUsuarioRepository->findByUuid($uuid);
        if (!$fila || $fila->excluido) {
            throw new Exception('Fila de usuário não encontrada');
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $uuidUsuarioLogado
        ];

        return $this->filaDeUsuarioRepository->delete($fila, $data);
    }
}
