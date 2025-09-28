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

    public function __construct(EnderecoRepository $enderecoRepository)
    {
        $this->enderecoRepository = $enderecoRepository;
    }

    public function findAllWhere(): Collection
    {
        return $this->enderecoRepository->findAllWhere(['excluido' => 0]);
    }

    public function findByUuid(string $uuid): ?EnderecoModel
    {
        $endereco = $this->enderecoRepository->findByUuid($uuid);
        if (!$endereco || $endereco->excluido) {
            throw new Exception('Endereço não encontrado');
        }
        return $endereco;
    }

    public function create(array $data, string $uuidUsuarioLogado): EnderecoModel
    {
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
        $data['usuario_criador_uuid'] = $uuidUsuarioLogado;
        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        return $this->enderecoRepository->create($data);
    }

    public function update(string $uuid, array $data, string $uuidUsuarioLogado)
    {
        $endereco = $this->enderecoRepository->findByUuid($uuid);
        if (!$endereco || $endereco->excluido) {
            throw new Exception('Endereço não encontrado');
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

        $data['usuario_criador_uuid'] = $uuidUsuarioLogado;
        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        return $this->enderecoRepository->update($endereco, $data);
    }

    public function delete(string $uuid, string $uuidUsuarioLogado): bool {
        $endereco = $this->enderecoRepository->findByUuid($uuid);
        if (!$endereco || $endereco->excluido) {
            throw new Exception('Endereço não encontrado');
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $uuidUsuarioLogado,
        ];

        return $this->enderecoRepository->delete($endereco, $data) ? true : false;
    }
}
