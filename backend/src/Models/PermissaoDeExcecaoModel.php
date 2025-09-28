<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissaoDeExcecaoModel extends Model
{
    protected $table = 'permissoes_de_excecao';
    protected $primaryKey = 'uuid';
    public $incrementing = false;

    public $timestamps = true;
    const CREATED_AT = 'data_de_criacao';
    const UPDATED_AT = 'data_de_ultima_alteracao';

    protected $fillable = [
        'uuid',
        'usuario_uuid',
        'permissao_uuid',
        'liberado',
        'excluido',
        'usuario_criador_uuid',
        'usuario_alterador_uuid',
    ];

    // Relacionamentos
    public function usuario()
    {
        return $this->belongsTo(UsuarioModel::class, 'usuario_uuid', 'uuid');
    }

    public function permissao()
    {
        return $this->belongsTo(PermissaoModel::class, 'permissao_uuid', 'uuid');
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
