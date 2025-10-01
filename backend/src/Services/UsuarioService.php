<?php

namespace App\Services;

use App\Repositories\UsuarioRepository;
use Respect\Validation\Validator as v;
use Ramsey\Uuid\Uuid;
use App\Models\UsuarioModel;
use App\Services\AssociacaoService;
use App\Services\CargoService;
use App\Services\ChaveService;
use App\Services\EnderecoService;
use App\Services\HortaService;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class UsuarioService {
    protected $usuarioRepository;
    protected $cargoService;
    protected $associacaoService;
    protected $hortaService;
    protected $enderecoService;
    protected $chaveService;

    public function __construct(
        UsuarioRepository $usuarioRepository, 
        CargoService $cargoService,
        AssociacaoService $associacaoService,
        HortaService $hortaService,
        EnderecoService $enderecoService,
        ChaveService $chaveService) {
            $this->usuarioRepository = $usuarioRepository;
            $this->cargoService = $cargoService;
            $this->associacaoService = $associacaoService;
            $this->hortaService = $hortaService;
            $this->enderecoService = $enderecoService;
            $this->chaveService = $chaveService;
    }
    
    public function findAllWhere(array $payloadUsuarioLogado): Collection
    {
        $cargo = $this->cargoService->findByUuidInternal($payloadUsuarioLogado['cargo_uuid']);
        
        switch ($cargo->slug) {
            case "admin_plataforma":
                return $this->usuarioRepository->findAllWhere(['excluido' => 0]);
                break;
            case 'admin_associacao_geral':
                return $this->usuarioRepository->findAllWhere(['excluido' => 0, 'associacao_uuid' => $payloadUsuarioLogado['associacao_uuid']]);
                break;
            case 'admin_horta_geral':
                return $this->usuarioRepository->findAllWhere(['excluido' => 0, 'horta_uuid' => $payloadUsuarioLogado['horta_uuid']]);
                break;
            default:
                throw new Exception('Nenhuma informaçã de usuários encontrada');
        }

        
    }
    
    public function findByUuid(string $uuid, array $payloadUsuarioLogado): ?UsuarioModel
    {
        
        $usuario = $this->usuarioRepository->findByUuid($uuid);
        if (!$usuario || $usuario->excluido) {
            throw new Exception('Usuário não encontrado');
        }
        
        $cargo = $this->cargoService->findByUuidInternal($payloadUsuarioLogado['cargo_uuid']);
        
        switch ($cargo->slug) {
            case "admin_plataforma":
                return $usuario = $this->usuarioRepository->findByUuid($uuid);
                break;
            case 'admin_associacao_geral':
                $usuario = $this->usuarioRepository->findByUuid($uuid);
                if (!$usuario || $usuario->excluido || $usuario->associacao_uuid != $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception('Usuário não encontrado');
                }
                return $usuario;
                break;
            case 'admin_horta_geral':
                $usuario = $this->usuarioRepository->findByUuid($uuid);
                if (!$usuario || $usuario->excluido || $usuario->horta_uuid != $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception('Usuário não encontrado');
                }
                return $usuario;
                break;
            default:
                throw new Exception('Nenhuma informação de usuário encontrada');
        }
    }
    public function findByEmail(string $email): ?UsuarioModel
    {
        $usuario = $this->usuarioRepository->findByEmail($email);
        if (!$usuario || $usuario->excluido) {
            throw new Exception('Usuário não encontrado');
        }
        return $usuario;
    }

    public function create(array $data, string $uuidUsuarioLogado, array $payloadUsuarioLogado): UsuarioModel
    { 
        if($uuidUsuarioLogado == "NEW_ACCOUNT"){
            v::key('nome_completo', v::stringType()->notEmpty())
            ->key('cpf', v::cpf())
            ->key('email', v::email())
            ->key('senha', v::stringType()->length(6, null))
            ->key('data_de_nascimento', v::date())
            ->key('apelido', v::stringType()->notEmpty())
            ->assert($data);
            
            $email = $data['email'];
            $usuarioComEsseEmail = $this->usuarioRepository->findByEmail($email);
            if ($usuarioComEsseEmail) {
                throw new Exception('Usuário com o email:' . $email . ' já existe');
            }

            $cpf = $data['cpf'];
            $usuarioComEsseCPF = $this->usuarioRepository->findByCpf($cpf);
            if ($usuarioComEsseCPF) {
                throw new Exception('Usuário com o cpf:' . $cpf . ' já existe');
            }

            $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
            foreach ($guarded as $g) unset($data[$g]);
            
            $data['uuid'] = Uuid::uuid1()->toString();
            $data['senha'] = password_hash($data['senha'], PASSWORD_DEFAULT);
            $data['status_de_acesso'] = 1;
            $data['responsavel_da_conta'] = 0;
            $data['data_bloqueio_acesso'] = null;
            $data['usuario_associado_uuid'] = null;
            $data['motivo_bloqueio_acesso'] = null;
            $data['usuario_criador_uuid'] = $uuidUsuarioLogado;
            $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

            if (!empty($data['cargo_uuid'])) {
                $this->cargoService->findByUuidInternal($data['cargo_uuid']);
            }

            if (!empty($data['associacao_uuid'])){
                $this->associacaoService->findByUuid($data['associacao_uuid'], $payloadUsuarioLogado);
            }

            if (!empty($data['horta_uuid'])) {
                $this->hortaService->findByUuid($data['horta_uuid']);
            }

            if (!empty($data['endereco_uuid'])) {
                $this->enderecoService->findByUuid($data['endereco_uuid']);
            }

            if (!empty($data['chave_uuid'])) {
                $this->chaveService->findByUuid($data['chave_uuid']);
            }

            return $this->usuarioRepository->create($data);}
        else {
            $cargo = $this->cargoService->findByUuidInternal($payloadUsuarioLogado['cargo_uuid']);
        
        switch ($cargo->slug) {
            case "admin_plataforma":
                v::key('nome_completo', v::stringType()->notEmpty())
                ->key('cpf', v::cpf())
                ->key('email', v::email())
                ->key('senha', v::stringType()->length(6, null))
                ->key('dias_ausente', v::intVal()->positive())
                ->key('data_de_nascimento', v::date())
                ->key('apelido', v::stringType()->notEmpty())
                ->key('taxa_associado_em_centavos', v::intVal()->positive(), false)
                ->key('associacao_uuid', v::uuid(), false)
                ->key('horta_uuid', v::uuid(), false)
                ->key('cargo_uuid', v::uuid(), false)
                ->key('chave_uuid', v::uuid(), false)
                ->key('endereco_uuid', v::uuid(), false)
                ->assert($data);
                
                $email = $data['email'];
                $usuarioComEsseEmail = $this->usuarioRepository->findByEmail($email);
                if ($usuarioComEsseEmail) {
                    throw new Exception('Usuário com o email:' . $email . ' já existe');
                }

                $cpf = $data['cpf'];
                $usuarioComEsseCPF = $this->usuarioRepository->findByCpf($cpf);
                if ($usuarioComEsseCPF) {
                    throw new Exception('Usuário com o cpf:' . $cpf . ' já existe');
                }

                $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
                foreach ($guarded as $g) unset($data[$g]);
                
                $data['uuid'] = Uuid::uuid1()->toString();
                $data['senha'] = password_hash($data['senha'], PASSWORD_DEFAULT);
                $data['status_de_acesso'] = 1;
                $data['responsavel_da_conta'] = 0;
                $data['data_bloqueio_acesso'] = null;
                $data['usuario_associado_uuid'] = null;
                $data['motivo_bloqueio_acesso'] = null;
                $data['usuario_criador_uuid'] = $uuidUsuarioLogado;
                $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

                if (!empty($data['cargo_uuid'])) {
                    $this->cargoService->findByUuidInternal($data['cargo_uuid']);
                }

                if (!empty($data['associacao_uuid'])){
                    $this->associacaoService->findByUuid($data['associacao_uuid'], $payloadUsuarioLogado);
                }

                if (!empty($data['horta_uuid'])) {
                    $this->hortaService->findByUuid($data['horta_uuid']);
                }

                if (!empty($data['endereco_uuid'])) {
                    $this->enderecoService->findByUuid($data['endereco_uuid']);
                }

                if (!empty($data['chave_uuid'])) {
                    $this->chaveService->findByUuid($data['chave_uuid']);
                }

                return $this->usuarioRepository->create($data);
                break;
            case 'admin_associacao_geral':
                v::key('nome_completo', v::stringType()->notEmpty())
                ->key('cpf', v::cpf())
                ->key('email', v::email())
                ->key('senha', v::stringType()->length(6, null))
                ->key('dias_ausente', v::intVal()->positive())
                ->key('data_de_nascimento', v::date())
                ->key('apelido', v::stringType()->notEmpty())
                ->key('taxa_associado_em_centavos', v::intVal()->positive(), false)
                ->key('associacao_uuid', v::uuid(), false)
                ->key('horta_uuid', v::uuid(), false)
                ->key('cargo_uuid', v::uuid(), false)
                ->key('chave_uuid', v::uuid(), false)
                ->key('endereco_uuid', v::uuid(), false)
                ->assert($data);
                
                $email = $data['email'];
                $usuarioComEsseEmail = $this->usuarioRepository->findByEmail($email);
                if ($usuarioComEsseEmail) {
                    throw new Exception('Usuário com o email:' . $email . ' já existe');
                }

                $cpf = $data['cpf'];
                $usuarioComEsseCPF = $this->usuarioRepository->findByCpf($cpf);
                if ($usuarioComEsseCPF) {
                    throw new Exception('Usuário com o cpf:' . $cpf . ' já existe');
                }

                $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
                foreach ($guarded as $g) unset($data[$g]);
            
                $data['uuid'] = Uuid::uuid1()->toString();
                $data['senha'] = password_hash($data['senha'], PASSWORD_DEFAULT);
                $data['status_de_acesso'] = 1;
                $data['responsavel_da_conta'] = 0;
                $data['data_bloqueio_acesso'] = null;
                $data['usuario_associado_uuid'] = null;
                $data['motivo_bloqueio_acesso'] = null;
                $data['usuario_criador_uuid'] = $uuidUsuarioLogado;
                $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

                if (!empty($data['cargo_uuid'])) {
                    $this->cargoService->findByUuidInternal($data['cargo_uuid']);
                }

                $data['associacao_uuid'] = $payloadUsuarioLogado['associacao_uuid'];

                // Horta deve pertencer a associacao_uuid de quem está tentando atribuir
                if (!empty($data['horta_uuid'])) {
                    $horta = $this->hortaService->findByUuid($data['horta_uuid']);
                    if($horta->associacao_uuid != $payloadUsuarioLogado['associacao_uuid']){
                        throw new Exception('Horta inválida para sua associação UUID');
                    }
                }

                if (!empty($data['endereco_uuid'])) {
                    $this->enderecoService->findByUuid($data['endereco_uuid']);
                }
                // Chave deve pertencer a um horta_uuid cuja horta tem o mesmo associacao_uuid de quem está tentando atribuir
                if (!empty($data['chave_uuid'])) {
                    $chave = $this->chaveService->findByUuid($data['chave_uuid']);
                    $horta = $this->hortaService->findByUuid($chave->horta_uuid);
                    if($horta->associacao_uuid != $payloadUsuarioLogado['associacao_uuid']){
                        throw new Exception('Chave inválida para horta que não é de sua associação UUID');
                    }
                } 
                return $this->usuarioRepository->create($data);
                break;
            case 'admin_horta_geral':
                v::key('nome_completo', v::stringType()->notEmpty())
                ->key('cpf', v::cpf())
                ->key('email', v::email())
                ->key('senha', v::stringType()->length(6, null))
                ->key('dias_ausente', v::intVal()->positive())
                ->key('data_de_nascimento', v::date())
                ->key('apelido', v::stringType()->notEmpty())
                ->key('taxa_associado_em_centavos', v::intVal()->positive(), false)
                ->key('associacao_uuid', v::uuid(), false)
                ->key('horta_uuid', v::uuid(), false)
                ->key('cargo_uuid', v::uuid(), false)
                ->key('chave_uuid', v::uuid(), false)
                ->key('endereco_uuid', v::uuid(), false)
                ->assert($data);
                
                $email = $data['email'];
                $usuarioComEsseEmail = $this->usuarioRepository->findByEmail($email);
                if ($usuarioComEsseEmail) {
                    throw new Exception('Usuário com o email:' . $email . ' já existe');
                }

                $cpf = $data['cpf'];
                $usuarioComEsseCPF = $this->usuarioRepository->findByCpf($cpf);
                if ($usuarioComEsseCPF) {
                    throw new Exception('Usuário com o cpf:' . $cpf . ' já existe');
                }

                $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
                foreach ($guarded as $g) unset($data[$g]);
            
                $data['uuid'] = Uuid::uuid1()->toString();
                $data['senha'] = password_hash($data['senha'], PASSWORD_DEFAULT);
                $data['status_de_acesso'] = 1;
                $data['responsavel_da_conta'] = 0;
                $data['data_bloqueio_acesso'] = null;
                $data['usuario_associado_uuid'] = null;
                $data['motivo_bloqueio_acesso'] = null;
                $data['usuario_criador_uuid'] = $uuidUsuarioLogado;
                $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

                if (!empty($data['cargo_uuid'])) {
                    $this->cargoService->findByUuidInternal($data['cargo_uuid']);
                }

                $data['associacao_uuid'] = $payloadUsuarioLogado['associacao_uuid'];

                // Horta deve pertencer a associacao_uuid de quem está tentando atribuir
                if (!empty($data['horta_uuid'])) {
                    if($data['horta_uuid'] != $payloadUsuarioLogado['horta_uuid']){
                        throw new Exception('Horta inválida para sua horta UUID');
                    }
                }

                if (!empty($data['endereco_uuid'])) {
                    $this->enderecoService->findByUuid($data['endereco_uuid']);
                }
                // Chave deve pertencer a um horta_uuid cuja horta tem o mesmo associacao_uuid de quem está tentando atribuir
                if (!empty($data['chave_uuid'])) {
                    $chave = $this->chaveService->findByUuid($data['chave_uuid']); 
                    if($chave->horta_uuid != $payloadUsuarioLogado['horta_uuid']){
                        throw new Exception('Chave inválida para sua horta UUID');
                    }
                } 
                return $this->usuarioRepository->create($data);
                break;
            default:
                throw new Exception('Não será possível criar o usuário');
            }
            v::key('nome_completo', v::stringType()->notEmpty())
            ->key('cpf', v::cpf())
            ->key('email', v::email())
            ->key('senha', v::stringType()->length(6, null))
            ->key('dias_ausente', v::intVal()->positive())
            ->key('data_de_nascimento', v::date())
            ->key('apelido', v::stringType()->notEmpty())
            ->key('taxa_associado_em_centavos', v::intVal()->positive(), false)
            ->key('associacao_uuid', v::uuid(), false)
            ->key('horta_uuid', v::uuid(), false)
            ->key('cargo_uuid', v::uuid(), false)
            ->key('chave_uuid', v::uuid(), false)
            ->key('endereco_uuid', v::uuid(), false)
            ->assert($data);
            
            $email = $data['email'];
            $usuarioComEsseEmail = $this->usuarioRepository->findByEmail($email);
            if ($usuarioComEsseEmail) {
                throw new Exception('Usuário com o email:' . $email . ' já existe');
            }

            $cpf = $data['cpf'];
            $usuarioComEsseCPF = $this->usuarioRepository->findByCpf($cpf);
            if ($usuarioComEsseCPF) {
                throw new Exception('Usuário com o cpf:' . $cpf . ' já existe');
            }

            $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
            foreach ($guarded as $g) unset($data[$g]);
            
            $data['uuid'] = Uuid::uuid1()->toString();
            $data['senha'] = password_hash($data['senha'], PASSWORD_DEFAULT);
            $data['status_de_acesso'] = 1;
            $data['responsavel_da_conta'] = 0;
            $data['data_bloqueio_acesso'] = null;
            $data['usuario_associado_uuid'] = null;
            $data['motivo_bloqueio_acesso'] = null;
            $data['usuario_criador_uuid'] = $uuidUsuarioLogado;
            $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

            if (!empty($data['cargo_uuid'])) {
                $this->cargoService->findByUuidInternal($data['cargo_uuid']);
            }

            if (!empty($data['associacao_uuid'])){
                $this->associacaoService->findByUuid($data['associacao_uuid'], $payloadUsuarioLogado);
            }

            if (!empty($data['horta_uuid'])) {
                $this->hortaService->findByUuid($data['horta_uuid']);
            }

            if (!empty($data['endereco_uuid'])) {
                $this->enderecoService->findByUuid($data['endereco_uuid']);
            }

            if (!empty($data['chave_uuid'])) {
                $this->chaveService->findByUuid($data['chave_uuid']);
            }

            return $this->usuarioRepository->create($data);
        }
    }


    public function update(string $uuid, array $data, string $uuidUsuarioLogado, array $payloadUsuarioLogado): UsuarioModel
    {
    $usuario = $this->usuarioRepository->findByUuid($uuid);
    if (!$usuario || $usuario->excluido) {
        throw new Exception('Usuário não encontrado');
    }

    $cargo = $this->cargoService->findByUuidInternal($payloadUsuarioLogado['cargo_uuid']);

        switch ($cargo->slug) {
            case "admin_plataforma":
                // Admin plataforma pode alterar qualquer usuário
                break;

            case "admin_associacao_geral":
                // Só pode alterar usuários da própria associação
                if ($usuario->associacao_uuid != $payloadUsuarioLogado['associacao_uuid']) {
                    throw new Exception('Usuário não pertence à sua associação');
                }
                // Garante que associação atribuída seja da mesma do usuário logado
                if (!empty($data['associacao_uuid'])) {
                    $data['associacao_uuid'] = $payloadUsuarioLogado['associacao_uuid'];
                }
                // Valida horta/chave
                if (!empty($data['horta_uuid'])) {
                    $horta = $this->hortaService->findByUuid($data['horta_uuid']);
                    if ($horta->associacao_uuid != $payloadUsuarioLogado['associacao_uuid']) {
                        throw new Exception('Horta inválida para sua associação');
                    }
                }
                if (!empty($data['chave_uuid'])) {
                    $chave = $this->chaveService->findByUuid($data['chave_uuid']);
                    $horta = $this->hortaService->findByUuid($chave->horta_uuid);
                    if ($horta->associacao_uuid != $payloadUsuarioLogado['associacao_uuid']) {
                        throw new Exception('Chave inválida para horta da sua associação');
                    }
                }
                break;

            case "admin_horta_geral":
                // Só pode alterar usuários da própria horta
                if ($usuario->horta_uuid != $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception('Usuário não pertence à sua horta');
                }
                if (!empty($data['horta_uuid']) && $data['horta_uuid'] != $payloadUsuarioLogado['horta_uuid']) {
                    throw new Exception('Não pode alterar para outra horta');
                }
                if (!empty($data['chave_uuid'])) {
                    $chave = $this->chaveService->findByUuid($data['chave_uuid']);
                    if ($chave->horta_uuid != $payloadUsuarioLogado['horta_uuid']) {
                        throw new Exception('Chave inválida para sua horta');
                    }
                }
                break;

            default:
                throw new Exception('Não é possível alterar o usuário');
        }

        // Continua validação comum
        v::key('nome_completo', v::stringType()->notEmpty(), false)
        ->key('cpf', v::cpf(), false)
        ->key('email', v::email(), false)
        ->key('senha', v::stringType()->length(6, null), false)
        ->key('dias_ausente', v::intVal()->positive(), false)
        ->key('data_de_nascimento', v::date(), false)
        ->key('taxa_associado_em_centavos', v::intVal()->positive(), false)
        ->key('associacao_uuid', v::uuid(), false)
        ->key('horta_uuid', v::uuid(), false)
        ->key('cargo_uuid', v::uuid(), false)
        ->key('endereco_uuid', v::uuid(), false)
        ->key('chave_uuid', v::uuid(), false)
        ->key('apelido', v::stringType()->notEmpty(), false)
        ->assert($data);

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        if (!empty($data['senha'])) {
            $data['senha'] = password_hash($data['senha'], PASSWORD_DEFAULT);
        }

        if (!empty($data['cargo_uuid'])) {
            $this->cargoService->findByUuidInternal($data['cargo_uuid']);
        }
        if (!empty($data['associacao_uuid'])) {
            $this->associacaoService->findByUuid($data['associacao_uuid'], $payloadUsuarioLogado);
        }
        if (!empty($data['horta_uuid'])) {
            $this->hortaService->findByUuid($data['horta_uuid']);
        }
        if (!empty($data['endereco_uuid'])) {
            $this->enderecoService->findByUuid($data['endereco_uuid']);
        }
        if (!empty($data['chave_uuid'])) {
            $this->chaveService->findByUuid($data['chave_uuid']);
        }

        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        return $this->usuarioRepository->update($usuario, $data);
    }

    
    public function delete(string $uuid, string $uuidUsuarioLogado, array $payloadUsuarioLogado): bool
    {
    $usuario = $this->usuarioRepository->findByUuid($uuid);
    if (!$usuario || $usuario->excluido) {
        throw new Exception('Usuário não encontrado');
    }

    $cargo = $this->cargoService->findByUuidInternal($payloadUsuarioLogado['cargo_uuid']);

    switch ($cargo->slug) {
        case "admin_plataforma":
            // Pode deletar qualquer usuário
            break;

        case "admin_associacao_geral":
            if ($usuario->associacao_uuid != $payloadUsuarioLogado['associacao_uuid']) {
                throw new Exception('Usuário não pertence à sua associação');
            }
            break;

        case "admin_horta_geral":
            if ($usuario->horta_uuid != $payloadUsuarioLogado['horta_uuid']) {
                throw new Exception('Usuário não pertence à sua horta');
            }
            break;

        default:
            throw new Exception('Não é possível deletar o usuário');
    }

    $data = [
        'excluido' => 1,
        'usuario_alterador_uuid' => $uuidUsuarioLogado,
    ];

    return $this->usuarioRepository->delete($usuario, $data);
    }


}
