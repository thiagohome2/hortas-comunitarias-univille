<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HortaModel extends Model
{
    protected $table = 'hortas';
    protected $primaryKey = 'uuid';
    public $incrementing = false;

    public $timestamps = true;
    const CREATED_AT = 'data_de_criacao';
    const UPDATED_AT = 'data_de_ultima_alteracao';

    protected $fillable = [
        'uuid',
        'nome_da_horta',
        'endereco_uuid',
        'associacao_vinculada_uuid',
        'percentual_taxa_associado',
        'excluido',
        'usuario_criador_uuid',
        'usuario_alterador_uuid',
    ];

    // Relacionamentos
    public function endereco()
    {
        return $this->belongsTo(EnderecoModel::class, 'endereco_uuid', 'uuid');
    }

    public function associacao()
    {
        return $this->belongsTo(AssociacaoModel::class, 'associacao_vinculada_uuid', 'uuid');
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
