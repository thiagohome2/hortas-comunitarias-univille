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

    public function __construct(CanteiroEUsuarioRepository $canteiroEUsuarioRepository, CanteiroService $canteiroService, UsuarioService $usuarioService)
    {
        $this->canteiroEUsuarioRepository = $canteiroEUsuarioRepository;
        $this->usuarioService= $usuarioService;
        $this->canteiroService = $canteiroService;
    }

    public function findAllWhere(): Collection
    {
        return $this->canteiroEUsuarioRepository->findAllWhere();
    }
    
    public function findByUuid(string $uuid): ?CanteiroEUsuarioModel
    {
        $canteiroEUsuario= $this->canteiroEUsuarioRepository->findByUuid($uuid);
        if (!$canteiroEUsuario|| $canteiroEUsuario->excluido) {
            throw new Exception('Canteiro + usuário não encontrado');
        }
        return $canteiroEUsuario;
    }

 public function create(array $data, string $uuidUsuarioLogado): CanteiroEUsuarioModel
    {
        v::key('usuario_uuid', v::uuid())
        ->key('canteiro_uuid', v::uuid())
        ->key('tipo_vinculo', V::intVal()->min(1)->max(3))
        ->key('data_inicio', v::date())
        ->key('data_fim', v::date())
        ->key('percentual_responsabilidade', v::floatVal()->between(0, 100, true))
        ->key('observacoes', V::optional(V::stringType()))
        ->assert($data);
        
        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);
        
        $data['uuid'] = Uuid::uuid1()->toString();
        $data['ativo'] = 1;
        $data['usuario_criador_uuid'] = $uuidUsuarioLogado;
        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        if (!empty($data['canteiro_uuid'])){
            $this->canteiroService->findByUuid($data['canteiro_uuid']);
        }

        if (!empty($data['usuario_uuid'])) {
            $this->usuarioService->findByUuid($data['usuario_uuid']);
        }
        
        return $this->canteiroEUsuarioRepository->create($data);
    }


    public function update(string $uuid, array $data, string $uuidUsuarioLogado): CanteiroEUsuarioModel
    {
        $canteiroEUsuario= $this->canteiroEUsuarioRepository->findByUuid($uuid);
        if (!$canteiroEUsuario|| $canteiroEUsuario->excluido) {
            throw new Exception('Canteiro + usuário não encontrado');
        }

        v::key('usuario_uuid', v::uuid(), false)
        ->key('canteiro_uuid', v::uuid(), false)
        ->key('tipo_vinculo', v::intVal()->min(1)->max(3), false)
        ->key('data_inicio', v::date(), false)
        ->key('data_fim', v::date(), false)
        ->key('percentual_responsabilidade', v::floatVal()->between(0, 100, true), false)
        ->key('observacoes', v::optional(v::stringType()), false)
        ->key('ativo', v::boolVal(), false)
        ->assert($data);

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        if (!empty($data['canteiro_uuid'])){
            $this->canteiroService->findByUuid($data['canteiro_uuid']);
        }

        if (!empty($data['usuario_uuid'])) {
            $this->usuarioService->findByUuid($data['usuario_uuid']);
        }

        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        return $this->canteiroEUsuarioRepository->update($canteiroEUsuario, $data);
    }

    
    public function delete(string $uuid, string $uuidUsuarioLogado): bool {
        $canteiroEUsuario = $this->canteiroEUsuarioRepository->findByUuid($uuid);
        if (!$canteiroEUsuario|| $canteiroEUsuario->excluido) {
            throw new Exception('Canteiro + usuário não encontrado');
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $uuidUsuarioLogado,
        ];

        return $this->canteiroEUsuarioRepository->delete($canteiroEUsuario, $data) ? true : false;
    }
}
