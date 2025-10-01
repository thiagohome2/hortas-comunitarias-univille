<?php
namespace App\Services;

use App\Models\PlanoModel;
use App\Repositories\MensalidadeDaPlataformaRepository;
use App\Repositories\PlanoRepository;
use Respect\Validation\Validator as v;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Ramsey\Uuid\Uuid;

class PlanoService
{
    protected PlanoRepository $planoRepository;
    protected UsuarioService $usuarioService;
    protected CargoService $cargoService;
    protected MensalidadeDaPlataformaRepository $mensalidadeDaPlataformaRepository;

    public function __construct(PlanoRepository $planoRepository,
    UsuarioService $usuarioService,
    MensalidadeDaPlataformaRepository $mensalidadeDaPlataformaRepository,
    CargoService $cargoService
    ){
        $this->planoRepository = $planoRepository;
        $this->usuarioService = $usuarioService;
        $this->cargoService = $cargoService;
        $this->mensalidadeDaPlataformaRepository = $mensalidadeDaPlataformaRepository;
    }

    public function findAllWhere(array $payloadUsuarioLogado): Collection {
        if(!$this->isCargoAdminPlataforma($payloadUsuarioLogado)){
            throw new Exception("Permissão de cargo 0 necessária | findAllWhere");
        }
        return $this->planoRepository->findAllWhere(['excluido' => 0]);
    }

    public function findByUuid(string $uuid, array $payloadUsuarioLogado): ?PlanoModel {
        if(!$this->isCargoAdminPlataforma($payloadUsuarioLogado)){
            throw new Exception("Permissão de cargo 0 necessária | findByUuid");
        }

        $plano = $this->planoRepository->findByUuid($uuid);
        if(!$plano || $plano->excluido){
            throw new Exception('Plano não encontrado');
        }
        return $plano;
    }
    public function findBySlug(string $slug, array $payloadUsuarioLogado): ?PlanoModel {
        if(!$this->isCargoAdminPlataforma($payloadUsuarioLogado) &&
            $payloadUsuarioLogado['usuario_uuid'] !== "NEW_ACCOUNT"){
            throw new Exception("Permissão de cargo 0 necessária | findBySlug");
        }
        
        $plano = $this->planoRepository->findBySlug($slug);
        if(!$plano || $plano->excluido){
            throw new Exception('Plano não encontrado pela slug: ' . $slug);
        }
        return $plano;
    }

    public function findByUsuarioUuid(string $usuarioUuid, array $payloadUsuarioLogado): array
    {
        if(!$this->isCargoAdminPlataforma($payloadUsuarioLogado)){
            throw new Exception("Permissão de cargo 0 necessária | findByUsuarioUuid");
        }

        $usuario = $this->usuarioService->findByUuid($usuarioUuid, $payloadUsuarioLogado);
        if (!$usuario || $usuario->excluido) {
            throw new Exception('Usuário não encontrado');
        }

        $plano = $this->mensalidadeDaPlataformaRepository->findPlanoByUsuarioUuid($usuarioUuid);
        if (!$plano) {
            throw new Exception('Plano do usuário não encontrado');
        }
        return ["plano_uuid" => $plano];
    }

    public function create(array $data, array $payloadUsuarioLogado): PlanoModel {
        if(!$this->isCargoAdminPlataforma($payloadUsuarioLogado)){
            throw new Exception("Permissão de cargo 0 necessária | create");
        }

        v::key('codigo', v::stringType()->notEmpty())
           ->key('valor_em_centavos', v::intType()->positive())
          ->key('slug', v::stringType()->notEmpty())
          ->key('nome', v::stringType()->notEmpty())
          ->key('descricao', v::stringType()->notEmpty())
          ->check($data);

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['uuid'] = Uuid::uuid1()->toString();
        $data['usuario_criador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];
        $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];

        return $this->planoRepository->create($data);
    }

    public function update(string $uuid, array $data, array $payloadUsuarioLogado): PlanoModel {
        if(!$this->isCargoAdminPlataforma($payloadUsuarioLogado)){
            throw new Exception("Permissão de cargo 0 necessária | update");
        }

        $plano = $this->planoRepository->findByUuid($uuid);
        if(!$plano || $plano->excluido){
            throw new Exception('Plano não encontrado');
        }

        v::key('codigo', v::stringType()->notEmpty(), false)
          ->key('valor_em_centavos', v::intType()->positive(), false)
          ->key('slug', v::stringType()->notEmpty(), false)
          ->key('nome', v::stringType()->notEmpty(), false)
          ->key('descricao', v::stringType()->notEmpty(), false)
          ->check($data);

        $guarded = ['uuid', 'usuario_criador_uuid', 'data_de_criacao', 'data_de_ultima_alteracao'];
        foreach ($guarded as $g) unset($data[$g]);

        $data['usuario_alterador_uuid'] = $payloadUsuarioLogado['usuario_uuid'];

        return $this->planoRepository->update($plano, $data);
    }

    public function delete(string $uuid, array $payloadUsuarioLogado): bool {
        if(!$this->isCargoAdminPlataforma($payloadUsuarioLogado)){
            throw new Exception("Permissão de cargo 0 necessária | delete");
        }

        $plano = $this->planoRepository->findByUuid($uuid);
        if (!$plano || $plano->excluido) {
            throw new Exception('Plano não encontrado');
        }

        $data = [
            'excluido' => 1,
            'usuario_alterador_uuid' => $payloadUsuarioLogado['usuario_uuid'],
        ];

        return $this->planoRepository->delete($plano, $data);
    }

    private function isCargoAdminPlataforma(array $payloadUsuarioLogado): bool
    {
        return $this->cargoService->findByUuid($payloadUsuarioLogado['cargo_uuid'], $payloadUsuarioLogado)->slug === "admin_plataforma";
    }
}
