<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CanteiroEUsuarioModel extends Model
{
    protected $table = 'canteiros_e_usuarios';
    protected $primaryKey = 'uuid';
    public $incrementing = false;

    public $timestamps = true;
    const CREATED_AT = 'data_de_criacao';
    const UPDATED_AT = 'data_de_ultima_alteracao';

    protected $fillable = [
        'uuid',
        'canteiro_uuid',
        'usuario_uuid',
        'tipo_vinculo',
        'data_inicio',
        'data_fim',
        'percentual_responsabilidade',
        'observacoes',
        'ativo',
        'excluido',
        'usuario_criador_uuid',
        'usuario_alterador_uuid',
    ];

    // Relacionamentos
    public function canteiro()
    {
        return $this->belongsTo(CanteiroModel::class, 'canteiro_uuid', 'uuid');
    }

    public function usuario()
    {
        return $this->belongsTo(UsuarioModel::class, 'usuario_uuid', 'uuid');
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
