<?php

namespace App\Services;

use App\Repositories\UsuarioRepository;
use Respect\Validation\Validator as v;
use Ramsey\Uuid\Uuid;
use App\Models\UsuarioModel;
use App\Repositories\AssociacaoRepository;
use App\Repositories\CargoRepository;
use App\Repositories\HortaRepository;
use Exception;

class UsuarioService
{
    protected $usuarioRepository;
    protected $cargoRepository;
    protected $associacaoRepository;
    protected $hortaRepository;

    public function __construct(
        UsuarioRepository $usuarioRepository, 
        CargoRepository $cargoRepository,
        AssociacaoRepository $associacaoRepository,
        HortaRepository $hortaRepository,

        )
    {
        $this->usuarioRepository = $usuarioRepository;
        $this->cargoRepository = $cargoRepository;
        $this->cargoRepository = $cargoRepository;
        $this->associacaoRepository = $associacaoRepository;
        $this->hortaRepository = $hortaRepository;
    }

    public function create(array $data, string $uuidUsuarioLogado): UsuarioModel
    {
        v::key('nome_completo', v::stringType()->notEmpty())
          ->key('cpf', v::cpf())
          ->key('email', v::email())
          ->key('senha', v::stringType()->length(6, null))
          ->assert($data);
          
          
        $data['uuid'] = Uuid::uuid1()->toString();

        $data['senha'] = password_hash($data['senha'], PASSWORD_DEFAULT);
        $data['status_de_acesso'] = 1;
        $data['responsavel_da_conta'] = 0;
        $data['data_bloqueio_acesso'] = null;
        $data['usuario_associado_uuid'] = null;
        $data['motivo_bloqueio_acesso'] = null;
        $data['excluido'] = 0;
        
        $data['usuario_criador_uuid'] = $uuidUsuarioLogado;
        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;
        // Se informou cargo válido
        if (!empty($data['cargo_uuid']) && !$this->cargoRepository->existsByUuid($data['cargo_uuid'])) {
            $cargos = $this->cargoRepository->findAll();
            $lista = array_map(fn($c) => "{$c['slug']} | {$c['uuid']}", $cargos);
            throw new Exception("Cargo informado não existe. Cargos válidos: " . implode(', ', $lista));
        }
        // Se informou associação válida, por padrão é a do usuário que cadastra
            // só cargo 0 - admin da plataforma que pode alterar   
        if (empty($data['associacao_uuid'])
            || !$this->associacaoRepository->existsByUuid($data['associacao_uuid'])) {
            $associacoes = $this->associacaoRepository->findAll();
            $lista = array_map(fn($c) => "{$c['nome']} | {$c['uuid']}", $associacoes->all());
            throw new Exception("Associação informada não existe. Associações válidas: " . implode(', ', $lista));
        }
        // Se informou horta válida
        if (empty($data['horta_uuid']) || !$this->hortaRepository->existsByUuid($data['horta_uuid'])) {
            $hortas = $this->hortaRepository->findAll();
            $lista = array_map(fn($c) => "{$c->nome} | {$c->uuid}", $hortas->all()); 
            throw new Exception("Horta informada não existe. Hortas válidas: " . implode(', ', $lista));
        } 
        return $this->usuarioRepository->create($data);
    }

    public function update(string $uuid, array $data, string $uuidUsuarioLogado): UsuarioModel
    {
        $usuario = $this->usuarioRepository->findByUuid($uuid);
        if (!$usuario) {
            throw new Exception('Usuário não encontrado');
        }

        v::key('nome_completo', v::optional(v::stringType()->notEmpty()))
          ->key('cpf', v::optional(v::cpf()))
          ->key('email', v::optional(v::email()))
          ->key('senha', v::optional(v::stringType()->length(6, null)))
          ->assert($data);

        if (!empty($data['senha'])) {
            $data['senha'] = password_hash($data['senha'], PASSWORD_DEFAULT);
        }

        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        return $this->usuarioRepository->update($usuario, $data);
    }

    public function delete(string $uuid): bool
    {
        $usuario = $this->usuarioRepository->findByUuid($uuid);
        if (!$usuario) {
            throw new Exception('Usuário não encontrado');
        }

        return $this->usuarioRepository->delete($usuario);
    }

    public function listAll()
    {
        return $this->usuarioRepository->findAll();
    }

    public function getByUuid(string $uuid): ?UsuarioModel
    {
        return $this->usuarioRepository->findByUuid($uuid);
    }
}
