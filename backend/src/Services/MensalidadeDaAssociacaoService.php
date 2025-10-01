<?php
namespace App\Services;

use App\Models\MensalidadeDaAssociacaoModel;
use App\Repositories\MensalidadeDaAssociacaoRepository;
use Respect\Validation\Validator as v;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Ramsey\Uuid\Uuid;

class MensalidadeDaAssociacaoService
{
    protected MensalidadeDaAssociacaoRepository $mensalidadeDaAssociacaoRepository;
    protected AssociacaoService $associacaoService;
    protected UsuarioService $usuarioService;
    protected CargoService $cargoService;
    protected HortaService $hortaService;

    public function __construct(MensalidadeDaAssociacaoRepository $mensalidadeDaAssociacaoRepository,
    AssociacaoService $associacaoService,
    CargoService $cargoService,
    UsuarioService $usuarioService,
    HortaService $hortaService){
        $this->mensalidadeDaAssociacaoRepository = $mensalidadeDaAssociacaoRepository;
        $this->associacaoService = $associacaoService;
        $this->usuarioService = $usuarioService;
        $this->cargoService = $cargoService;
        $this->hortaService = $hortaService;
    }

    public function findAllWhere(array $payloadUsuarioLogado): Collection {
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        
        switch ($cargo) {
            case 'admin_plataforma':
                return $this->mensalidadeDaAssociacaoRepository->findAllWhere(['excluido' => 0]);
                
            case 'admin_associacao_geral':
                return $this->mensalidadeDaAssociacaoRepository->findAllWhere([
                    'excluido' => 0,
                    'associacao_uuid' => $payloadUsuarioLogado['associacao_uuid']
                ]);
                
            case 'admin_horta_geral':
                $usuarios = $this->usuarioService->findAllWhere(["horta_uuid" => $payloadUsuarioLogado['horta_uuid']]);
                return $this->mensalidadeDaAssociacaoRepository->findAllWhere([
                    'excluido' => 0,
                    'usuario_uuid' => $usuarios
                ]);
                
            case 'canteirista':
            case 'dependente':
                return $this->mensalidadeDaAssociacaoRepository->findAllWhere([
                    'excluido' => 0,
                    'usuario_uuid' => $payloadUsuarioLogado['usuario_uuid']
                ]);
                
            default:
                throw new Exception("Permissão de cargo 0,1,2,3,4 necessária | findAllWhere");
        } 
    }

    public function findByUuid(string $uuid, array $payloadUsuarioLogado): ?MensalidadeDaAssociacaoModel {
        $mensalidadeDaAssociacao = $this->mensalidadeDaAssociacaoRepository->findByUuid($uuid);
        if(!$mensalidadeDaAssociacao || $mensalidadeDaAssociacao->excluido){
            throw new Exception('Mensalidade da Associação não encontrada');
        }
        
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        
        switch ($cargo) {
            case 'admin_plataforma':
                return $mensalidadeDaAssociacao;
                
            case 'admin_associacao_geral':
                if ($mensalidadeDaAssociacao->associacao_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você não tem permissão para acessar esta mensalidade");
                }
                return $mensalidadeDaAssociacao;
                
            case 'admin_horta_geral':
                $usuario = $this->usuarioService->findByUuid($mensalidadeDaAssociacao->usuario_uuid, $payloadUsuarioLogado);
                if ($usuario->horta_uuid !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Você não tem permissão para acessar esta mensalidade");
                }
                return $mensalidadeDaAssociacao;
                
            case 'canteirista':
            case 'dependente':
                if ($mensalidadeDaAssociacao->usuario_uuid !== $payloadUsuarioLogado['usuario_uuid']) {
                    throw new Exception("Você só pode acessar suas próprias mensalidades");
                }
                return $mensalidadeDaAssociacao;
                
            default:
                throw new Exception("Permissão insuficiente | findByUuid");
        }
    }


    public function findByAssociacaoUuid(string $associacaoUuid, array $payloadUsuarioLogado): Collection
    {
        $associacao = $this->associacaoService->findByUuid($associacaoUuid, $payloadUsuarioLogado);
        if (!$associacao || $associacao->excluido) {
            throw new Exception('Associação não encontrada');
        }

        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        
        switch ($cargo) {
            case 'admin_plataforma':
                $mensalidades = $this->mensalidadeDaAssociacaoRepository->findByAssociacaoUuid($associacaoUuid);
                break;
                
            case 'admin_associacao_geral':
                if ($associacaoUuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você não tem permissão para acessar mensalidades desta associação");
                }
                $mensalidades = $this->mensalidadeDaAssociacaoRepository->findByAssociacaoUuid($associacaoUuid);
                break;
                
            case 'admin_horta_geral':
                if ($associacaoUuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você não tem permissão para acessar mensalidades desta associação");
                }
                $usuarios = $this->usuarioService->findAllWhere(["horta_uuid" => $payloadUsuarioLogado['horta_uuid']]);
                $mensalidades = $this->mensalidadeDaAssociacaoRepository->findByAssociacaoUuid($associacaoUuid)
                    ->filter(function($m) use ($usuarios) {
                        return $usuarios->contains('uuid', $m->usuario_uuid);
                    });
                break;
                
            case 'canteirista':
            case 'dependente':
                $mensalidades = $this->mensalidadeDaAssociacaoRepository->findByAssociacaoUuid($associacaoUuid)
                    ->filter(function($m) use ($payloadUsuarioLogado) {
                        return $m->usuario_uuid === $payloadUsuarioLogado['usuario_uuid'];
                    });
                break;
                
            default:
                throw new Exception("Permissão insuficiente | findByAssociacaoUuid");
        }
        
        if ($mensalidades->isEmpty()) {
            throw new Exception('Mensalidades de associação não encontradas');
        }
        return $mensalidades;
    }

    public function findByUsuarioUuid(string $usuarioUuid, array $payloadUsuarioLogado): Collection
    {
        $usuario = $this->usuarioService->findByUuid($usuarioUuid, $payloadUsuarioLogado);
        if (!$usuario || $usuario->excluido) {
            throw new Exception('Usuário não encontrado');
        }

        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        
        switch ($cargo) {
            case 'admin_plataforma':
                $mensalidades = $this->mensalidadeDaAssociacaoRepository->findByUsuarioUuid($usuarioUuid);
                break;
                
            case 'admin_associacao_geral':
                if ($usuario->associacao_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você não tem permissão para acessar mensalidades deste usuário");
                }
                $mensalidades = $this->mensalidadeDaAssociacaoRepository->findByUsuarioUuid($usuarioUuid);
                break;
                
            case 'admin_horta_geral':
                if ($usuario->horta_uuid !== $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception("Você não tem permissão para acessar mensalidades deste usuário");
                }
                $mensalidades = $this->mensalidadeDaAssociacaoRepository->findByUsuarioUuid($usuarioUuid);
                break;
                
            case 'canteirista':
            case 'dependente':
                if ($usuarioUuid !== $payloadUsuarioLogado['usuario_uuid']) {
                    throw new Exception("Você só pode acessar suas próprias mensalidades");
                }
                $mensalidades = $this->mensalidadeDaAssociacaoRepository->findByUsuarioUuid($usuarioUuid);
                break;
                
            default:
                throw new Exception("Permissão insuficiente | findByUsuarioUuid");
        }
        
        if ($mensalidades->isEmpty()) {
            throw new Exception('Mensalidades de associação do usuário não encontradas');
        }
        return $mensalidades;
    }

   public function create(array $data, array $payloadUsuarioLogado): MensalidadeDaAssociacaoModel {
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);

        switch ($cargo) { 
            case 'admin_plataforma':
                // Pode criar para qualquer associação
                break;
                
            case 'admin_associacao_geral':
                // Só pode criar para sua própria associação
                if (!empty($data['associacao_uuid']) && $data['associacao_uuid'] !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você só pode criar mensalidades para sua própria associação");
                }
                break;
                
            default:
                throw new Exception("Permissão insuficiente 0,1 | create");
        }
        
        v::key('valor_em_centavos', v::intType()->positive())
        ->key('usuario_uuid', v::uuid())
        ->key('associacao_uuid', v::uuid())
        ->key('data_vencimento',  v::date('Y-m-d'))
        ->key('data_pagamento', v::optional(v::date('Y-m-d')))
        ->key('status', v::intType()->positive())
        ->key('dias_atraso', v::intType()->positive())
        ->key('url_anexo', v::optional(v::url()))
        ->key('url_recibo', v::optional(v::url()), false)
        ->check($data);

        if (!empty($data['usuario_uuid'])){
            $this->usuarioService->findByUuid($data['usuario_uuid'], $payloadUsuarioLogado);
        }

        if (!empty($data['associacao_uuid'])){
            $this->associacaoService->findByUuid($data['associacao_uuid'], $payloadUsuarioLogado);
        }

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['uuid'] = Uuid::uuid1()->toString();
        $data['usuario_criador_uuid'] =  $payloadUsuarioLogado['usuario_uuid'];
        $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];

        return $this->mensalidadeDaAssociacaoRepository->create($data);
    }

    public function update(string $uuid, array $data, array $payloadUsuarioLogado): MensalidadeDaAssociacaoModel {
        $mensalidadeDaAssociacao = $this->mensalidadeDaAssociacaoRepository->findByUuid($uuid);
        if(!$mensalidadeDaAssociacao || $mensalidadeDaAssociacao->excluido){
            throw new Exception('Mensalidade da Associação não encontrada');
        }
        
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        
        switch ($cargo) { 
            case 'admin_plataforma':
                // Pode editar qualquer mensalidade
                break;
                
            case 'admin_associacao_geral':
                // Só pode editar mensalidades da sua associação
                if ($mensalidadeDaAssociacao->associacao_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você não tem permissão para editar esta mensalidade");
                }
                break;
                
            default:
                throw new Exception("Permissão insuficiente 0,1 | update");
        }

        v::key('valor_em_centavos', v::intType()->positive(), false)
        ->key('usuario_uuid', v::uuid(), false)
        ->key('associacao_uuid', v::uuid(), false)
        ->key('data_vencimento',  v::date('Y-m-d'), false)
        ->key('data_pagamento', v::date('Y-m-d'), false)
        ->key('status', v::intType()->positive(), false)
        ->key('dias_atraso', v::intType()->positive(), false)
        ->key('url_anexo', v::optional(v::url()), false)
        ->key('url_recibo', v::optional(v::url()), false)
        ->check($data);

        if (!empty($data['usuario_uuid'])){
            $this->usuarioService->findByUuid($data['usuario_uuid'], $payloadUsuarioLogado);
        }

        if (!empty($data['associacao_uuid'])){
            $this->associacaoService->findByUuid($data['associacao_uuid'], $payloadUsuarioLogado);
        }

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];

        return $this->mensalidadeDaAssociacaoRepository->update($mensalidadeDaAssociacao, $data);
    }

    public function delete(string $uuid, array $payloadUsuarioLogado): bool {
        $mensalidadeDaAssociacao = $this->mensalidadeDaAssociacaoRepository->findByUuid($uuid);
        if (!$mensalidadeDaAssociacao || $mensalidadeDaAssociacao->excluido) {
            throw new Exception('Mensalidade da Associação não encontrada');
        }
        
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);
        
        switch ($cargo) { 
            case 'admin_plataforma':
                // Pode deletar qualquer mensalidade
                break;
                
            case 'admin_associacao_geral':
                // Só pode deletar mensalidades da sua associação
                if ($mensalidadeDaAssociacao->associacao_uuid !== $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception("Você não tem permissão para deletar esta mensalidade");
                }
                break;
                
            default:
                throw new Exception("Permissão insuficiente 0,1 | delete");
        }
        
        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $payloadUsuarioLogado['usuario_uuid'],
        ];
        
        return $this->mensalidadeDaAssociacaoRepository->delete($mensalidadeDaAssociacao, $data);
    }
 

    private function getCargoSlug(array $payloadUsuarioLogado): string
    {
        return $this->cargoService->findByUuidInternal($payloadUsuarioLogado['cargo_uuid'])->slug;
    } 
}
