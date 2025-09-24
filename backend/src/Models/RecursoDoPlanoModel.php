<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecursoDoPlanoModel extends Model
{
    protected $table = 'recursos_do_plano';
    protected $primaryKey = 'uuid';
    public $incrementing = false;

    public $timestamps = true;
    const CREATED_AT = 'data_de_criacao';
    const UPDATED_AT = 'data_de_ultima_alteracao';

    protected $fillable = [
        'uuid',
        'plano_uuid',
        'nome_do_recurso',
        'quantidade',
        'descricao',
        'excluido',
        'usuario_criador_uuid',
        'usuario_alterador_uuid',
    ];

    // Relacionamentos
    public function plano()
    {
        return $this->belongsTo(PlanoModel::class, 'plano_uuid', 'uuid');
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
