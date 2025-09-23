<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssociacaoModel extends Model
{
    protected $table = 'associacoes';
    protected $primaryKey = 'uuid';
    public $incrementing = false;

    public $timestamps = true;
    const CREATED_AT = 'data_de_criacao';
    const UPDATED_AT = 'data_de_ultima_alteracao';

    protected $fillable = [
        'uuid',
        'cnpj',
        'razao_social',
        'nome_fantasia',
        'endereco_uuid',
        'url_estatuto_social_pdf',
        'url_ata_associacao_pdf',
        'status_aprovacao',
        'excluido',
        'usuario_responsavel_uuid',
    ];

    // Relacionamentos
    public function endereco()
    {
        return $this->belongsTo(EnderecoModel::class, 'endereco_uuid', 'uuid');
    }

    public function usuarioResponsavel()
    {
        return $this->belongsTo(UsuarioModel::class, 'usuario_responsavel_uuid', 'uuid');
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
