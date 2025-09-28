<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilaDeUsuarioModel extends Model
{
    protected $table = 'fila_de_usuarios';
    protected $primaryKey = 'uuid';
    public $incrementing = false;

    public $timestamps = true;
    const CREATED_AT = 'data_de_criacao';
    const UPDATED_AT = 'data_de_ultima_alteracao';

    protected $fillable = [
        'uuid',
        'usuario_uuid',
        'horta_uuid',
        'data_entrada',
        'ordem',
        'excluido',
        'usuario_criador_uuid',
        'usuario_alterador_uuid',
    ];

    // Relacionamentos
    public function usuario()
    {
        return $this->belongsTo(UsuarioModel::class, 'usuario_uuid', 'uuid');
    }

    public function horta()
    {
        return $this->belongsTo(HortaModel::class, 'horta_uuid', 'uuid');
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
