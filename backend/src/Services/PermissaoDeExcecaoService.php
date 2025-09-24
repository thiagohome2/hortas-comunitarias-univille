<?php

namespace App\Services;

use App\Models\PermissaoDeExcecaoModel;
use App\Repositories\PermissaoDeExcecaoRepository;
use Respect\Validation\Validator as v;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Ramsey\Uuid\Uuid;

class PermissaoDeExcecaoService
{
    protected PermissaoDeExcecaoRepository $permissaoDeExcecaoRepository;
    protected PermissaoService $permissaoService;
    protected UsuarioService $usuarioService;

    public function __construct(PermissaoDeExcecaoRepository $permissaoDeExcecaoRepository, PermissaoService $permissaoService, UsuarioService $usuarioService)
    {
        $this->permissaoDeExcecaoRepository = $permissaoDeExcecaoRepository;
        $this->permissaoService = $permissaoService;
        $this->usuarioService = $usuarioService;
    }

    public function findAllWhere(): Collection
    {
        return $this->permissaoDeExcecaoRepository->findAllWhere(['excluido' => 0]);
    }
    
    public function findByUuid(string $uuid): ?PermissaoDeExcecaoModel
    {
        $permissaoDeExcecao = $this->permissaoDeExcecaoRepository->findByUuid($uuid);
        if (!$permissaoDeExcecao|| $permissaoDeExcecao->excluido) {
            throw new Exception('Permissão de Exceção não encontrada');
        }
        return $permissaoDeExcecao;
    }

    public function findByUserUuid(string $uuid): Collection
    {
        $permicoesDeExcecaoDoUsuario = $this->permissaoDeExcecaoRepository->findByUserUuid($uuid);
        if ($permicoesDeExcecaoDoUsuario->isEmpty()) {
            throw new Exception('Não foram encontradas permissões de exceção para o usuário UUID: ' . $uuid);
        }
        return $permicoesDeExcecaoDoUsuario;
    }

 public function create(array $data, string $uuidUsuarioLogado): PermissaoDeExcecaoModel
    {
        v::key('usuario_uuid', v::uuid())
        ->key('permissao_uuid', v::uuid())
        ->key('liberado', v::intVal()->min(0)->max(1))
        ->assert($data);
        
        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);
        
        $data['uuid'] = Uuid::uuid1()->toString();
        $data['usuario_criador_uuid'] = $uuidUsuarioLogado;
        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        if (!empty($data['usuario_uuid'])){
            $this->usuarioService->findByUuid($data['usuario_uuid']);
        }

        if (!empty($data['permissao_uuid'])) {
            $this->permissaoService->findByUuid($data['permissao_uuid']);
        }

        return $this->permissaoDeExcecaoRepository->create($data);
    }


    public function update(string $uuid, array $data, string $uuidUsuarioLogado): PermissaoDeExcecaoModel
    {
        $permissaoDeExcecao= $this->permissaoDeExcecaoRepository->findByUuid($uuid);
        if (!$permissaoDeExcecao|| $permissaoDeExcecao->excluido) {
            throw new Exception('Permissão de Exceção não encontrada');
        }

        v::key('usuario_uuid', v::uuid(), false)
        ->key('permissao_uuid', v::uuid(), false)
        ->key('liberado', v::intVal()->min(0)->max(1), false)
        ->assert($data);

        if (!empty($data['usuario_uuid'])){
            $this->usuarioService->findByUuid($data['usuario_uuid']);
        }

        if (!empty($data['permissao_uuid'])) {
            $this->permissaoService->findByUuid($data['permissao_uuid']);
        }

        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        return $this->permissaoDeExcecaoRepository->update($permissaoDeExcecao, $data);
    }

    
    public function delete(string $uuid, string $uuidUsuarioLogado): bool {
        $permissaoDeExcecao = $this->permissaoDeExcecaoRepository->findByUuid($uuid);
        if (!$permissaoDeExcecao|| $permissaoDeExcecao->excluido) {
            throw new Exception('Permissão de Exceção não encontrado');
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $uuidUsuarioLogado,
        ];

        return $this->permissaoDeExcecaoRepository->delete($permissaoDeExcecao, $data) ? true : false;
    }
}
