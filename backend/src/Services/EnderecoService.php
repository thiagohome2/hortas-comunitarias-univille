<?php

namespace App\Services;

use App\Models\EnderecoModel;
use App\Repositories\EnderecoRepository;
use Respect\Validation\Validator as v;
use Illuminate\Database\Eloquent\Collection;
use Exception;
use Ramsey\Uuid\Uuid;

class EnderecoService
{
    protected EnderecoRepository $enderecoRepository;
    protected CargoService $cargoService;

    public function __construct(EnderecoRepository $enderecoRepository, CargoService $cargoService)
    {
        $this->enderecoRepository = $enderecoRepository;
        $this->cargoService = $cargoService;
    }

    public function findAllWhere(array $payloadUsuarioLogado): Collection
    {
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);

        switch ($cargo) {
            case 'admin_plataforma':
            case 'admin_associacao_geral':
            case 'admin_horta_geral':
            case 'canteirista':
            case 'dependente':
                return $this->enderecoRepository->findAllWhere(['excluido' => 0]);
            default:
                throw new Exception("Permissão insuficiente | findAllWhere");
        }
    }

    public function findByUuid(string $uuid, array $payloadUsuarioLogado): ?EnderecoModel
    {
        $endereco = $this->enderecoRepository->findByUuid($uuid);
        if (!$endereco || $endereco->excluido) {
            throw new Exception('Endereço não encontrado');
        }

        $cargo = $this->getCargoSlug($payloadUsuarioLogado);

        switch ($cargo) {
            case 'admin_plataforma':
            case 'admin_associacao_geral':
            case 'admin_horta_geral':
            case 'canteirista':
            case 'dependente':
                return $endereco;
            default:
                throw new Exception("Permissão insuficiente | findByUuid");
        }
    }

    public function create(array $data, array $payloadUsuarioLogado): EnderecoModel
    {
        $cargo = $this->getCargoSlug($payloadUsuarioLogado);

        switch ($cargo) {
            case 'admin_plataforma':
            case 'admin_associacao_geral':
            case 'admin_horta_geral':
                break; // permitido criar
            default:
                throw new Exception("Permissão insuficiente | create");
        }

        v::key('tipo_logradouro', v::stringType()->length(0, 50))
            ->key('logradouro', v::stringType()->length(0, 255))
            ->key('numero', v::stringType()->length(0, 20))
            ->key('complemento', v::stringType()->length(0, 100))
            ->key('bairro', v::stringType()->length(0, 100))
            ->key('cidade', v::stringType()->length(0, 100))
            ->key('estado', v::stringType()->length(0, 2))
            ->key('cep', v::stringType()->length(0, 9))
            ->key('latitude', v::optional(v::numericVal()->between(-90, 90)))
            ->key('longitude', v::optional(v::numericVal()->between(-180, 180)))
            ->assert($data);

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['uuid'] = Uuid::uuid1()->toString();
        $data['usuario_criador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];
        $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];

        return $this->enderecoRepository->create($data);
    }

    public function update(string $uuid, array $data, array $payloadUsuarioLogado): EnderecoModel
    {
        $endereco = $this->enderecoRepository->findByUuid($uuid);
        if (!$endereco || $endereco->excluido) {
            throw new Exception('Endereço não encontrado');
        }

        $cargo = $this->getCargoSlug($payloadUsuarioLogado);

        switch ($cargo) {
            case 'admin_plataforma':
            case 'admin_associacao_geral':
            case 'admin_horta_geral':
                break; // permitido editar
            default:
                throw new Exception("Permissão insuficiente | update");
        }

        v::key('tipo_logradouro', v::stringType()->length(0, 50), false)
            ->key('logradouro', v::stringType()->length(0, 255), false)
            ->key('numero', v::stringType()->length(0, 20), false)
            ->key('complemento', v::stringType()->length(0, 100), false)
            ->key('bairro', v::stringType()->length(0, 100), false)
            ->key('cidade', v::stringType()->length(0, 100), false)
            ->key('estado', v::stringType()->length(0, 2), false)
            ->key('cep', v::stringType()->length(0, 9), false)
            ->key('latitude', v::optional(v::numericVal()->between(-90, 90)), false)
            ->key('longitude', v::optional(v::numericVal()->between(-180, 180)), false)
            ->assert($data);

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];

        return $this->enderecoRepository->update($endereco, $data);
    }

    public function delete(string $uuid, array $payloadUsuarioLogado): bool
    {
        $endereco = $this->enderecoRepository->findByUuid($uuid);
        if (!$endereco || $endereco->excluido) {
            throw new Exception('Endereço não encontrado');
        }

        $cargo = $this->getCargoSlug($payloadUsuarioLogado);

        switch ($cargo) {
            case 'admin_plataforma':
            case 'admin_associacao_geral':
            case 'admin_horta_geral':
                break; // permitido deletar
            default:
                throw new Exception("Permissão insuficiente | delete");
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $payloadUsuarioLogado['usuario_uuid'],
        ];

        return $this->enderecoRepository->delete($endereco, $data);
    }

    private function getCargoSlug(array $payloadUsuarioLogado): string
    {
        return $this->cargoService->findByUuidInternal($payloadUsuarioLogado['cargo_uuid'])->slug;
    }
}
