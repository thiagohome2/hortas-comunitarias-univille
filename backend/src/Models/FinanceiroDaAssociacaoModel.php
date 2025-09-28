<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceiroDaAssociacaoModel extends Model
{
    protected $table = 'financeiro_da_associacao';
    protected $primaryKey = 'uuid';
    public $incrementing = false;

    public $timestamps = true;
    const CREATED_AT = 'data_de_criacao';
    const UPDATED_AT = 'data_de_ultima_alteracao';

    protected $fillable = [
        'uuid',
        'tipo',
        'valor_em_centavos',
        'descricao_do_lancamento',
        'categoria_uuid',
        'url_anexo',
        'data_do_lancamento',
        'associacao_uuid',
        'mensalidade_uuid',
        'excluido',
        'usuario_criador_uuid',
        'usuario_alterador_uuid',
    ];

    // Relacionamentos
    public function associacao()
    {
        return $this->belongsTo(AssociacaoModel::class, 'associacao_uuid', 'uuid');
    }

    public function categoria()
    {
        return $this->belongsTo(CategoriaFinanceiraModel::class, 'categoria_uuid', 'uuid');
    }

    public function mensalidade()
    {
        return $this->belongsTo(MensalidadeDaAssociacaoModel::class, 'mensalidade_uuid', 'uuid');
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
