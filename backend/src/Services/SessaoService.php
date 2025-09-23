<?php
namespace App\Services;

use App\Models\UsuarioModel;
use Firebase\JWT\JWT;

class SessaoService
{
    public function __construct(private UsuarioModel $usuarioModel){}

    public function login(string $email, string $senha): string
    {
        $usuario = $this->usuarioModel->where('email', $email)->first();
        if (!$usuario) {
            throw new \Exception("Usuário inválido");
        }

        if (!password_verify($senha, $usuario->senha)) {
            throw new \Exception("Senha inválida");
        }

        $payload = [
            'usuario_uuid' => $usuario->uuid,
            'cargo_uuid' => $usuario->cargo_uuid,
            'exp' => time() + 3600, // 1h de expiração
        ];

        return JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS256');
    }
}
