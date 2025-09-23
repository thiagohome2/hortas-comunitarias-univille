<?php
declare(strict_types=1);

use Illuminate\Database\Capsule\Manager as Capsule;
use Ramsey\Uuid\Uuid;

class SeedUsuarioAdmin_20250922_220000
{
    protected Capsule $capsule;

    public function __construct(Capsule $capsule)
    {
        $this->capsule = $capsule;
    }

    public function up(): void
    {
        $uuid = Uuid::uuid4()->toString(); // UUID do usuário
        $nome = 'Admin Plataforma';
        $email = 'admin@plataforma.com';
        $senha = password_hash('lvcas12345678', PASSWORD_DEFAULT); // senha padrão
        $cargoUuid = '7e41e97e-8036-434f-9990-04fd2d92755f';
        $enderecoUuid = '3b3a7f48-fc7f-4231-855d-63fcd89e5114'; // endereço da Univille

        $this->capsule::table('usuarios')->insert([
            'uuid' => $uuid,
            'nome_completo' => $nome,
            'cpf' => '000.000.000-00',
            'email' => $email,
            'senha' => $senha,
            'cargo_uuid' => $cargoUuid,
            'endereco_uuid' => $enderecoUuid,
            'excluido' => false,
            'data_de_criacao' => date('Y-m-d H:i:s'),
        ]);

        echo "Usuário Admin da Plataforma inserido com UUID: {$uuid}\n";
    }
}
