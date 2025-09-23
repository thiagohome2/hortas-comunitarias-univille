<?php

namespace App\Services;

use App\Repositories\UsuarioRepository;
use Respect\Validation\Validator as v;
use Ramsey\Uuid\Uuid;
use App\Models\UsuarioModel;
use App\Repositories\AssociacaoRepository;
use App\Repositories\CargoRepository;
use App\Repositories\EnderecoRepository;
use App\Repositories\HortaRepository;
use Exception;

class UsuarioService
{
    protected $usuarioRepository;
    protected $cargoRepository;
    protected $associacaoRepository;
    protected $hortaRepository;
    protected $enderecoRepository;

    public function __construct(
        UsuarioRepository $usuarioRepository, 
        CargoRepository $cargoRepository,
        AssociacaoRepository $associacaoRepository,
        HortaRepository $hortaRepository,
        EnderecoRepository $enderecoRepository) {
        $this->usuarioRepository = $usuarioRepository;
        $this->cargoRepository = $cargoRepository;
        $this->cargoRepository = $cargoRepository;
        $this->associacaoRepository = $associacaoRepository;
        $this->hortaRepository = $hortaRepository;
        $this->enderecoRepository = $enderecoRepository;
    }

    public function create(array $data, string $uuidUsuarioLogado): UsuarioModel {
        v::key('nome_completo', v::stringType()->notEmpty())
          ->key('cpf', v::cpf())
          ->key('email', v::email())
          ->key('senha', v::stringType()->length(6, null))
          ->key('taxa_associado_em_centavos', v::intVal()->positive())
          ->key('associacao_uuid', v::uuid())
          ->key('horta_uuid', v::uuid())
          ->key('cargo_uuid', v::uuid())
          ->key('endereco_uuid', v::uuid())
          ->assert($data);
          
        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) {
            unset($data[$g]);
        }
          
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
        // Se informou endereço válido
        if (empty($data['endereco_uuid']) || !$this->enderecoRepository->existsByUuid($data['endereco_uuid'])) {
            $enderecos = $this->enderecoRepository->findAll();
            $lista = array_map(fn($c) => "{$c->nome} | {$c->uuid}", $enderecos->all()); 
            throw new Exception("Endereço informado não existe. Endereços válidos: " . implode(', ', $lista));
        } 
        return $this->usuarioRepository->create($data);
    }

    public function update(string $uuid, array $data, string $uuidUsuarioLogado): UsuarioModel {
        
        $usuario = $this->usuarioRepository->findByUuid($uuid);
        if (!$usuario || $usuario->excluido) {
            throw new Exception('Usuário não encontrado');
        }

        v::key('nome_completo', v::stringType()->notEmpty(), false)
            ->key('cpf', v::cpf(), false)
            ->key('email', v::email(), false)
            ->key('senha', v::stringType()->length(6, null), false)
            ->key('taxa_associado_em_centavos', v::intVal()->positive(), false)
            ->key('associacao_uuid', v::uuid(), false)
            ->key('horta_uuid', v::uuid(), false)
            ->key('cargo_uuid', v::uuid(), false)
            ->key('endereco_uuid', v::uuid(), false)
            ->assert($data);

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) {
            unset($data[$g]);
        }

        if (!empty($data['senha'])) {
            $data['senha'] = password_hash($data['senha'], PASSWORD_DEFAULT);
        }

        // valida foreign keys opcionais
        if (!empty($data['cargo_uuid']) && !$this->cargoRepository->existsByUuid($data['cargo_uuid'])) {
            $cargos = $this->cargoRepository->findAll();
            $lista = array_map(fn($c) => "{$c['slug']} | {$c['uuid']}", $cargos);
            throw new Exception("Cargo informado não existe. Cargos válidos: " . implode(', ', $lista));
        }

        if (!empty($data['associacao_uuid']) && !$this->associacaoRepository->existsByUuid($data['associacao_uuid'])) {
            $associacoes = $this->associacaoRepository->findAll();
            $lista = array_map(fn($c) => "{$c['nome']} | {$c['uuid']}", $associacoes->all());
            throw new Exception("Associação informada não existe. Associações válidas: " . implode(', ', $lista));
        }

        if (!empty($data['horta_uuid']) && !$this->hortaRepository->existsByUuid($data['horta_uuid'])) {
            $hortas = $this->hortaRepository->findAll();
            $lista = array_map(fn($c) => "{$c->nome} | {$c->uuid}", $hortas->all());
            throw new Exception("Horta informada não existe. Hortas válidas: " . implode(', ', $lista));
        }

        if (!empty($data['endereco_uuid']) && !$this->enderecoRepository->existsByUuid($data['endereco_uuid'])) {
            $enderecos = $this->enderecoRepository->findAll();
            $lista = array_map(fn($c) => "{$c->nome} | {$c->uuid}", $enderecos->all());
            throw new Exception("Endereço informado não existe. Endereços válidos: " . implode(', ', $lista));
        }

        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

            return $this->usuarioRepository->update($usuario, $data);
    }

    public function delete(string $uuid, string $uuidUsuarioLogado): bool
    {
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

    public function listAll()
    {
        // só retorna os não excluídos
        return $this->usuarioRepository->findAllWhere(['excluido' => 0]);
    }

    public function getByUuid(string $uuid): ?UsuarioModel
    {
        $usuario = $this->usuarioRepository->findByUuid($uuid);
        if (!$usuario || $usuario->excluido) {
            throw new Exception('Usuário não encontrado');
        }
        return $usuario;
    }

}
