<?php
namespace App\Services;

use App\Models\CargoModel;
use App\Services\UsuarioService;
use App\Services\AssociacaoService;
use App\Services\MensalidadeDaPlataformaService;
use App\Services\PlanoService;
use Firebase\JWT\JWT;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Capsule\Manager as Capsule;

class SessaoService
{
    public function __construct(
        private UsuarioService $usuarioService,
        private AssociacaoService $associacaoService,
        private CargoModel $cargoModel,
        private MensalidadeDaPlataformaService $mensalidadeService,
        private PlanoService $planoService,
        private Capsule $capsule
    ) {}

    public function signIn(string $email, string $senha, array $payloadUsuarioLogado): string
    {
        $usuario = $this->usuarioService->findByEmail($email);
        if (!$usuario) {
            throw new Exception("Usuário inválido");
        }

        if (!password_verify($senha, $usuario->senha)) {
            throw new Exception("Senha inválida");
        }

        $payload = [
            'usuario_uuid' => $usuario->uuid,
            'cargo_uuid' => $usuario->cargo_uuid,
            'associacao_uuid' => $usuario->associacao_uuid,
            'horta_uuid' => $usuario->horta_uuid,
            'exp' => time() + 7200,
        ];

        return JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS256');
    }
    public function signUp(array $data): array
    {
        $uuidSistema = "NEW_ACCOUNT";



        return $this->capsule->connection()->transaction(function () use ($data, $uuidSistema) {
            $payloadMinimo = [
                'usuario_uuid' => null,
                'cargo_uuid' => null,
                'associacao_uuid' => null,
                'horta_uuid' => null
            ];


            $associacaoData = $data['associacao'] ?? [];
            $usuarioData = $data['usuario'] ?? [];

            $payloadMinimo["usuario_uuid"] = $uuidSistema;

            $cargo = $this->cargoModel->firstOrCreate(['slug' => 'admin_associacao_geral']);
            $usuarioData['cargo_uuid'] = $cargo->uuid;

            $associacao = $this->associacaoService->create($associacaoData, $payloadMinimo);
            $usuarioData['associacao_uuid'] = $associacao->uuid;

            $payloadMinimo['cargo_uuid'] =$cargo->uuid;
            $payloadMinimo['associacao_uuid'] = $associacao->uuid;

            $usuario = $this->usuarioService->create($usuarioData, $uuidSistema, $payloadMinimo);

            $plano = $this->planoService->findBySlug('plano_bronze', $payloadMinimo);

            $hoje = new \DateTime();
            $dataVencimento = $hoje->modify('+30 days')->format('Y-m-d');

            $mensalidadeData = [
                'valor_em_centavos' => $plano->valor_em_centavos,
                'usuario_uuid' => $usuario->uuid,
                'plano_uuid' => $plano->uuid,
                'data_vencimento' => $dataVencimento,
                'data_pagamento' => null,
                'status' => 1,
                'dias_atraso' => 0,
                'usuario_criador_uuid' => $usuario->uuid,
                'usuario_alterador_uuid' => $usuario->uuid,
            ];

            $mensalidade = $this->mensalidadeService->create($mensalidadeData, $payloadMinimo);

            $payload = [
                'usuario_uuid' => $usuario->uuid,
                'cargo_uuid' => $usuario->cargo_uuid,
                'associacao_uuid' => $usuario->associacao_uuid,
                'horta_uuid' => $usuario->horta_uuid,
                'exp' => time() + 7200,
            ];

            $token = \Firebase\JWT\JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS256');

            return [
                'associacao' => $associacao,
                'usuario' => $usuario,
                'mensalidade' => $mensalidade,
                'token' => $token
            ];
        });
    }
}

