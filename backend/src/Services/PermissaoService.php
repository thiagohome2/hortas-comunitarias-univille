<?php

namespace App\Services;

use App\Models\PermissaoModel;
use App\Repositories\PermissaoRepository;
use Respect\Validation\Validator as v;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Ramsey\Uuid\Uuid;

class PermissaoService
{
    protected PermissaoRepository $permissaoRepository;

    public function __construct(PermissaoRepository $permissaoRepository)
    {
        $this->permissaoRepository = $permissaoRepository;
    }

    public function findAllWhere(): Collection
    {
        return $this->permissaoRepository->findAllWhere(['excluido' => 0]);
    }

    public function findAllInUuidList(array $uuids): Collection
    {
    if (empty($uuids)) {
        throw new Exception('Lista de UUIDs não pode estar vazia');
    }
    
    return $this->permissaoRepository->findAllInUuidList($uuids);
    }
    
    public function findByUuid(string $uuid): ?permissaoModel
    {
        $permissao= $this->permissaoRepository->findByUuid($uuid);
        if (!$permissao|| $permissao->excluido) {
            throw new Exception('Permissão não encontrada');
        }
        return $permissao;
    }

 public function create(array $data, string $uuidUsuarioLogado): PermissaoModel
    {
        v::key('slug', v::stringType()->notEmpty()->length(1, 100))
        ->key('tipo', v::intVal()->min(0)->max(255))
        ->key('descricao', v::optional(v::stringType()))
        ->key('modulo', v::intVal()->min(0)->max(255))
        ->assert($data);
        
        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);
        
        $data['uuid'] = Uuid::uuid1()->toString();
        $data['usuario_criador_uuid'] = $uuidUsuarioLogado;
        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        return $this->permissaoRepository->create($data);
    }


    public function update(string $uuid, array $data, string $uuidUsuarioLogado): PermissaoModel
    {
        $permissao= $this->permissaoRepository->findByUuid($uuid);
        if (!$permissao|| $permissao->excluido) {
            throw new Exception('Permissão não encontrada');
        }
        v::key('slug', v::stringType()->notEmpty()->length(1, 100), false)
        ->key('tipo', v::intVal()->min(0)->max(255), false)
        ->key('descricao', v::optional(v::stringType()), false)
        ->key('modulo', v::intVal()->min(0)->max(255), false)
        ->assert($data);

        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        return $this->permissaoRepository->update($permissao, $data);
    }

    
    public function delete(string $uuid, string $uuidUsuarioLogado): bool {
        $permissao = $this->permissaoRepository->findByUuid($uuid);
        if (!$permissao|| $permissao->excluido) {
            throw new Exception('Permissão não encontrada');
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $uuidUsuarioLogado,
        ];

        return $this->permissaoRepository->delete($permissao, $data) ? true : false;
    }
}
