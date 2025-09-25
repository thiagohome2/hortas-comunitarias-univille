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

    public function __construct(MensalidadeDaAssociacaoRepository $mensalidadeDaAssociacaoRepository,
    AssociacaoService $associacaoService,
    UsuarioService $usuarioService){
        $this->mensalidadeDaAssociacaoRepository = $mensalidadeDaAssociacaoRepository;
        $this->associacaoService = $associacaoService;
        $this->usuarioService = $usuarioService;
    }

    public function findAllWhere(): Collection {
        return $this->mensalidadeDaAssociacaoRepository->findAllWhere(['excluido' => 0]);
    }

    public function findByUuid(string $uuid): ?MensalidadeDaAssociacaoModel {
        $mensalidadeDaAssociacao = $this->mensalidadeDaAssociacaoRepository->findByUuid($uuid);
        if(!$mensalidadeDaAssociacao || $mensalidadeDaAssociacao->excluido){
            throw new Exception('Mensalidade da Associação não encontrado');
        }
        return $mensalidadeDaAssociacao;
    }


    public function findByAssociacaoUuid(string $associacaoUuid): Collection
    {
        $associacao = $this->associacaoService->findByUuid($associacaoUuid);
        if (!$associacao || $associacao->excluido) {
            throw new Exception('Usuário não encontrado');
        }

        $mensalidades = $this->mensalidadeDaAssociacaoRepository->findByAssociacaoUuid($associacaoUuid);
        if ($mensalidades->isEmpty()) {
            throw new Exception('Mensalidades de associação da associação não encontradas');
        }
        return $mensalidades;
    }


        public function findByUsuarioUuid(string $usuarioUuid): Collection
    {
        $usuario = $this->usuarioService->findByUuid($usuarioUuid);
        if (!$usuario || $usuario->excluido) {
            throw new Exception('Usuário não encontrado');
        }

        $mensalidades = $this->mensalidadeDaAssociacaoRepository->findByUsuarioUuid($usuarioUuid);
        if ($mensalidades->isEmpty()) {
            throw new Exception('Mensalidades de associação do usuário não encontradas');
        }
        return $mensalidades;
    }

    public function create(array $data, string $uuidUsuarioLogado): MensalidadeDaAssociacaoModel {
        v::key('valor_em_centavos', v::intType()->positive())
        ->key('usuario_uuid', v::uuid())
        ->key('associacao_uuid', v::uuid())
        ->key('data_vencimento',  v::date('Y-m-d'))
        ->key('data_pagamento', v::optional(v::date('Y-m-d')))
        ->key('status', v::intType()->positive())
        ->key('dias_atraso', v::intType()->positive())
        ->key('url_anexo', v::optional(v::url()))
          ->check($data);

        if (!empty($data['usuario_uuid'])){
            $this->usuarioService->findByUuid($data['usuario_uuid']);
        }

        if (!empty($data['associacao_uuid'])){
            $this->associacaoService->findByUuid($data['associacao_uuid']);
        }

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['uuid'] = Uuid::uuid1()->toString();
        $data['usuario_criador_uuid'] = $uuidUsuarioLogado;
        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        return $this->mensalidadeDaAssociacaoRepository->create($data);
    }

    public function update(string $uuid, array $data, string $uuidUsuarioLogado): MensalidadeDaAssociacaoModel {
        $mensalidadeDaAssociacao = $this->mensalidadeDaAssociacaoRepository->findByUuid($uuid);
        if(!$mensalidadeDaAssociacao || $mensalidadeDaAssociacao->excluido){
            throw new Exception('Mensalidade da Associação não encontrado');
        }

        v::key('valor_em_centavos', v::intType()->positive(), false)
        ->key('usuario_uuid', v::uuid(), false)
        ->key('associacao_uuid', v::uuid(), false)
        ->key('data_vencimento',  v::date('Y-m-d'), false)
        ->key('data_pagamento', v::date('Y-m-d'), false)
        ->key('status', v::intType()->positive(), false)
        ->key('dias_atraso', v::intType()->positive(), false)
        ->key('url_anexo', v::optional(v::url()), false)
          ->check($data);

        if (!empty($data['usuario_uuid'])){
            $this->usuarioService->findByUuid($data['usuario_uuid']);
        }

        if (!empty($data['associacao_uuid'])){
            $this->associacaoService->findByUuid($data['associacao_uuid']);
        }

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['usuario_alterador_uuid'] = $uuidUsuarioLogado;

        return $this->mensalidadeDaAssociacaoRepository->update($mensalidadeDaAssociacao, $data);
    }

    public function delete(string $uuid, string $uuidUsuarioLogado): bool {
        $mensalidadeDaAssociacao = $this->mensalidadeDaAssociacaoRepository->findByUuid($uuid);
        if (!$mensalidadeDaAssociacao || $mensalidadeDaAssociacao->excluido) {
            throw new Exception('Mensalidade da Associação não encontrado');
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $uuidUsuarioLogado,
        ];

        return $this->mensalidadeDaAssociacaoRepository->delete($mensalidadeDaAssociacao, $data);
    }
}
