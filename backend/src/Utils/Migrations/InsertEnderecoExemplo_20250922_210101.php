<?php
declare(strict_types=1);

use Illuminate\Database\Capsule\Manager as Capsule;
use Ramsey\Uuid\Uuid;

class InsertEnderecoExemplo_20250922_210101
{
    protected Capsule $capsule;

    public function __construct(Capsule $capsule)
    {
        $this->capsule = $capsule;
    }

    public function up(): void
    {
        $capsule = $this->capsule;

        // Endereço fictício da Univille
        $enderecos = [
            [
                'uuid' => Uuid::uuid4()->toString(),
                'tipo_logradouro' => 'Rua',
                'logradouro' => 'Paulo Malschitzki',
                'numero' => '10',
                'complemento' => 'Bloco A',
                'bairro' => 'Itoupava Central',
                'cidade' => 'Blumenau',
                'estado' => 'SC',
                'cep' => '89033-901',
                'latitude' => -26.905123,
                'longitude' => -49.066456,
                'excluido' => false,
                'usuario_criador_uuid' => null,
                'usuario_alterador_uuid' => null,
                'data_de_criacao' => date('Y-m-d H:i:s'),
                'data_de_ultima_alteracao' => date('Y-m-d H:i:s'),
            ],
        ];

        foreach ($enderecos as $endereco) {
            $capsule::table('enderecos')->insert($endereco);
        }

        echo "Endereços da Univille inseridos com sucesso.\n";
    }
}
