<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MensalidadeDaPlataformaModel extends Model
{
    protected $table = 'mensalidades_da_plataforma';
    protected $primaryKey = 'uuid';
    public $incrementing = false;

    public $timestamps = true;
    const CREATED_AT = 'data_de_criacao';
    const UPDATED_AT = 'data_de_ultima_alteracao';

    protected $fillable = [
        'uuid',
        'usuario_uuid',
        'associacao_uuid',
        'valor_em_centavos',
        'mes_referencia',
        'plano',
        'data_vencimento',
        'data_pagamento',
        'status',
        'dias_atraso',
        'url_anexo',
        'url_recibo',
        'excluido',
        'usuario_criador_uuid',
        'usuario_alterador_uuid',
    ];

    // Relacionamentos
    public function usuario()
    {
        return $this->belongsTo(UsuarioModel::class, 'usuario_uuid', 'uuid');
    }

    public function associacao()
    {
        return $this->belongsTo(AssociacaoModel::class, 'associacao_uuid', 'uuid');
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
