<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

use Ramsey\Uuid\Uuid;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;
    const CREATED_AT = 'data_de_criacao';
    const UPDATED_AT = 'data_de_ultima_alteracao';

    protected $guarded = ['uuid','usuario_criador_uuid','usuario_alterador_uuid','data_de_criacao','data_de_ultima_alteracao'];


    protected $fillable = [
        'uuid',
        'nome_completo',
        'cpf',
        'email',
        'senha',
        'data_de_nascimento',
        'cargo_uuid',
        'taxa_associado_em_centavos',
        'endereco_uuid',
        'associacao_uuid',
        'horta_uuid',
        'usuario_associado_uuid',
        'status_de_acesso',
        'apelido',
        'dias_ausente',
        'chave_uuid',
        'responsavel_da_conta',
        'data_bloqueio_acesso',
        'motivo_bloqueio_acesso',
        'usuario_criador_uuid',
        'usuario_alterador_uuid',
        'excluido',
    ];

    protected $hidden = [
        'senha',
    ];

    public function cargo()
    {
        return $this->belongsTo(CargoModel::class, 'cargo_uuid', 'uuid');
    }

    public function endereco()
    {
        return $this->belongsTo(EnderecoModel::class, 'endereco_uuid', 'uuid');
    }

    public function associacao()
    {
        return $this->belongsTo(AssociacaoModel::class, 'associacao_uuid', 'uuid');
    }

    public function horta()
    {
        return $this->belongsTo(HortaModel::class, 'horta_uuid', 'uuid');
    }

    public function usuarioAssociado()
    {
        return $this->belongsTo(UsuarioModel::class, 'usuario_associado_uuid', 'uuid');
    }

    public function usuarioCriador()
    {
        return $this->belongsTo(UsuarioModel::class, 'usuario_criador_uuid', 'uuid');
    }

    public function usuarioAlterador()
    {
        return $this->belongsTo(UsuarioModel::class, 'usuario_alterador_uuid', 'uuid');
    }
}
