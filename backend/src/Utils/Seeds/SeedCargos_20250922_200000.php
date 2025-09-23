<?php
declare(strict_types=1);

use Illuminate\Database\Capsule\Manager as Capsule;
use Ramsey\Uuid\Uuid;

class SeedCargos_20250922_200000
{
    protected Capsule $capsule;

    public function __construct(Capsule $capsule)
    {
        $this->capsule = $capsule;
    }

    public function up(): void
    {
        $capsule = $this->capsule;

        // Checa se a tabela cargos existe
        if (!$capsule::schema()->hasTable('cargos')) {
            echo "A tabela 'cargos' não existe. Rode a migration antes do seed.\n";
            return;
        }

        // Define cargos iniciais
        $cargos = [
            [
                'codigo' => 0,
                'slug' => 'admin_plataforma',
                'nome' => 'Administração da Plataforma',
                'descricao' => 'Usuário com acesso total ao sistema.',
                'cor' => '#FF0000', // vermelho
            ],
            [
                'codigo' => 1,
                'slug' => 'admin_associacao_geral',
                'nome' => 'Administração da Associação',
                'descricao' => 'Gerencia todas as associações.',
                'cor' => '#00FF00', // verde
            ],
            [
                'codigo' => 2,
                'slug' => 'admin_horta_geral',
                'nome' => 'Administração da Horta',
                'descricao' => 'Gerencia todas as hortas.',
                'cor' => '#0000FF', // azul
            ],
            [
                'codigo' => 3,
                'slug' => 'canteirista',
                'nome' => 'Canteirista',
                'descricao' => 'Responsável por cuidar dos canteiros.',
                'cor' => '#FFFF00', // amarelo
            ],
            [
                'codigo' => 4,
                'slug' => 'dependente',
                'nome' => 'Dependente',
                'descricao' => 'Usuário dependente de outro associado.',
                'cor' => '#FF00FF', // magenta
            ],
        ];

        // Insere no banco
        foreach ($cargos as $cargo) {
            $exists = $capsule::table('cargos')->where('codigo', $cargo['codigo'])->exists();
            if ($exists) {
                continue; // já existe
            }

            $capsule::table('cargos')->insert([
                'uuid' => Uuid::uuid4()->toString(),
                'codigo' => $cargo['codigo'],
                'slug' => $cargo['slug'],
                'nome' => $cargo['nome'],
                'descricao' => $cargo['descricao'],
                'cor' => $cargo['cor'],
                'excluido' => false,
                'usuario_criador_uuid' => null,
                'data_de_criacao' => date('Y-m-d H:i:s'),
                'usuario_alterador_uuid' => null,
                'data_de_ultima_alteracao' => date('Y-m-d H:i:s'),
            ]);

            echo "Cargo '{$cargo['nome']}' inserido.\n";
        }

        echo "Todos os cargos iniciais foram inseridos.\n";
    }
}
