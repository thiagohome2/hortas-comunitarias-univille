<?php
declare(strict_types=1);

use Illuminate\Database\Capsule\Manager as Capsule;

class CreateBaseTables_20250922_202400
{
    protected Capsule $capsule;

    public function __construct(Capsule $capsule)
    {
        $this->capsule = $capsule;
    }

    public function up(): void
    {
        $schema = $this->capsule::schema();

        // Cria tabela cargos
        if (!$schema->hasTable('cargos')) {
            $schema->create('cargos', function ($table) {
                $table->char('uuid', 36)->primary();
                $table->integer('codigo')->unique();
                $table->string('slug', 100)->unique();
                $table->string('nome', 100);
                $table->text('descricao')->nullable();
                $table->string('cor', 7)->nullable();
                $table->boolean('excluido')->default(false);
                $table->char('usuario_criador_uuid', 36)->nullable();
                $table->timestamp('data_de_criacao')->useCurrent();
                $table->char('usuario_alterador_uuid', 36)->nullable();
                $table->timestamp('data_de_ultima_alteracao')->useCurrent();
            });
        }

        // Cria tabela enderecos
        if (!$schema->hasTable('enderecos')) {
            $schema->create('enderecos', function ($table) {
                $table->char('uuid', 36)->primary();
                $table->string('tipo_logradouro', 50);
                $table->string('logradouro', 255);
                $table->string('numero', 20);
                $table->string('complemento', 100)->nullable();
                $table->string('bairro', 100);
                $table->string('cidade', 100);
                $table->string('estado', 2);
                $table->string('cep', 9);
                $table->decimal('latitude', 10, 8)->nullable();
                $table->decimal('longitude', 11, 8)->nullable();
                $table->boolean('excluido')->default(false);
                $table->char('usuario_criador_uuid', 36)->nullable();
                $table->timestamp('data_de_criacao')->useCurrent();
                $table->char('usuario_alterador_uuid', 36)->nullable();
                $table->timestamp('data_de_ultima_alteracao')->useCurrent();
            });
        }

        // Cria tabela associacoes
        if (!$schema->hasTable('associacoes')) {
            $schema->create('associacoes', function ($table) {
                $table->char('uuid', 36)->primary();
                $table->string('nome', 100);
                $table->string('descricao', 255)->nullable();
                $table->boolean('excluido')->default(false);
                $table->char('usuario_criador_uuid', 36)->nullable();
                $table->timestamp('data_de_criacao')->useCurrent();
                $table->char('usuario_alterador_uuid', 36)->nullable();
                $table->timestamp('data_de_ultima_alteracao')->useCurrent();
            });
        }

        // Cria tabela hortas
        if (!$schema->hasTable('hortas')) {
            $schema->create('hortas', function ($table) {
                $table->char('uuid', 36)->primary();
                $table->string('nome', 100);
                $table->string('descricao', 255)->nullable();
                $table->boolean('excluido')->default(false);
                $table->char('usuario_criador_uuid', 36)->nullable();
                $table->timestamp('data_de_criacao')->useCurrent();
                $table->char('usuario_alterador_uuid', 36)->nullable();
                $table->timestamp('data_de_ultima_alteracao')->useCurrent();
            });
        }

        // Cria tabela usuarios
        if (!$schema->hasTable('usuarios')) {
            $schema->create('usuarios', function ($table) {
                $table->char('uuid', 36)->primary();
                $table->string('nome_completo', 255);
                $table->string('cpf', 14);
                $table->string('email', 255)->unique();
                $table->string('senha', 255); // campo senha
                $table->date('data_de_nascimento')->nullable();
                $table->char('cargo_uuid', 36)->nullable();
                $table->integer('taxa_associado_em_centavos')->nullable();
                $table->char('endereco_uuid', 36)->nullable();
                $table->char('associacao_uuid', 36)->nullable();
                $table->char('horta_uuid', 36)->nullable();
                $table->char('usuario_associado_uuid', 36)->nullable();
                $table->string('status_de_acesso', 50)->nullable();
                $table->string('responsavel_da_conta', 255)->nullable();
                $table->dateTime('data_bloqueio_acesso')->nullable();
                $table->text('motivo_bloqueio_acesso')->nullable();
                $table->boolean('excluido')->default(false);
                $table->char('usuario_criador_uuid', 36)->nullable();
                $table->timestamp('data_de_criacao')->useCurrent();
                $table->char('usuario_alterador_uuid', 36)->nullable();
                $table->timestamp('data_de_ultima_alteracao')->useCurrent();
            });
        }
    }
}
