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
            $this->cargoService = $cargoService;
            $this->associacaoService = $associacaoService;
            $this->hortaService = $hortaService;
            $this->enderecoService = $enderecoService;
            $this->chaveService = $chaveService;
    }
    
    public function findAllWhere(): Collection
    {
        return $this->usuarioRepository->findAllWhere(['excluido' => 0]);
    }
    
    public function findByUuid(string $uuid): ?UsuarioModel
    {
        $usuario = $this->usuarioRepository->findByUuid($uuid);
        if (!$usuario || $usuario->excluido) {
            throw new Exception('Usuário não encontrado');
        }
        return $usuario;
    }

    public function create(array $data, string $uuidUsuarioLogado): UsuarioModel
    { 
        if($uuidUsuarioLogado == "NEW_ACCOUNT"){
            echo "=============> yey";
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
                $this->cargoService->findByUuid($data['cargo_uuid']);
            }

            if (!empty($data['associacao_uuid'])){
                $this->associacaoService->findByUuid($data['associacao_uuid']);
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
                $this->cargoService->findByUuid($data['cargo_uuid']);
            }

            if (!empty($data['associacao_uuid'])){
                $this->associacaoService->findByUuid($data['associacao_uuid']);
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


    public function update(string $uuid, array $data, string $uuidUsuarioLogado): UsuarioModel
    {
        $usuario = $this->usuarioRepository->findByUuid($uuid);
        if (!$usuario || $usuario->excluido) {
            throw new Exception('Usuário não encontrado');
        }

        v::key('nome_completo', v::stringType()->notEmpty(), false)
            ->key('cpf', v::cpf(), false)
            ->key('email', v::email(), false)
            ->key('senha', v::stringType()->length(6, null), false)
            ->key('taxa_associado_em_centavos', v::intVal()->positive(), false)
            ->key('data_de_nascimento', v::date(), false)
            ->key('associacao_uuid', v::uuid(), false)
            ->key('horta_uuid', v::uuid(), false)
            ->key('cargo_uuid', v::uuid(), false)
            ->key('endereco_uuid', v::uuid(), false)
            ->key('dias_ausente', v::intVal()->positive(), false)
            ->key('chave_uuid', v::uuid(), false)
            ->key('apelido', v::stringType()->notEmpty(), false)
            ->assert($data);

        $email = $data['email'];
        $usuarioComEsseEmail = $this->usuarioRepository->findByEmail($email);
        if ($usuarioComEsseEmail->uuid != $usuario->uuid) {
            throw new Exception('Usuário com o email:' . $email . ' já existe');
        }

        $cpf = $data['cpf'];
        $usuarioComEsseCPF = $this->usuarioRepository->findByCpf($cpf);
        if ($usuarioComEsseCPF->uuid != $usuario->uuid) {
            throw new Exception('Usuário com o cpf:' . $cpf . ' já existe');
        }
        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        if (!empty($data['senha'])) {
            $data['senha'] = password_hash($data['senha'], PASSWORD_DEFAULT);
        }

        if (!empty($data['cargo_uuid'])) {
            $this->cargoService->findByUuid($data['cargo_uuid']);
        }

        if (!empty($data['associacao_uuid'])) {
            $this->associacaoService->findByUuid($data['associacao_uuid']);
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

    
    public function delete(string $uuid, string $uuidUsuarioLogado): bool {
        $usuario = $this->usuarioRepository->findByUuid($uuid);
        if (!$usuario || $usuario->excluido) {
            throw new Exception('Usuário não encontrado');
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $uuidUsuarioLogado,
        ];

        return $this->usuarioRepository->delete($usuario, $data) ? true : false;
    }

}
