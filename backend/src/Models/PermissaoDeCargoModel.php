<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissaoDeCargoModel extends Model
{
    protected $table = 'permissoes_de_cargo';
    protected $primaryKey = 'uuid';
    public $incrementing = false;

    public $timestamps = true;
    const CREATED_AT = 'data_de_criacao';
    const UPDATED_AT = 'data_de_ultima_alteracao';

    protected $fillable = [
        'uuid',
        'cargo_uuid',
        'permissao_uuid',
        'liberado',
        'excluido',
        'usuario_criador_uuid',
        'usuario_alterador_uuid',
    ];

    // Relacionamentos
    public function cargo()
    {
        return $this->belongsTo(CargoModel::class, 'cargo_uuid', 'uuid');
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
