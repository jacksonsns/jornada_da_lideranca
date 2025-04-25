<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntegracaoAcompanhamento extends Model
{
    use HasFactory;

    protected $table = 'integracao_acompanhamento';

    protected $fillable = [
        'user_id',
        'mentor_id',
        'tipo', // mentoria, feedback, avaliacao
        'data_encontro',
        'duracao_minutos',
        'observacoes',
        'metas_definidas',
        'proximos_passos',
        'status',
        'metricas_desempenho'
    ];

    protected $casts = [
        'data_encontro' => 'datetime',
        'metas_definidas' => 'array',
        'proximos_passos' => 'array',
        'metricas_desempenho' => 'array'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function avaliacoes()
    {
        return $this->hasMany(AvaliacaoDesempenho::class, 'acompanhamento_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'acompanhamento_id');
    }

    public function scopeMentorias($query)
    {
        return $query->where('tipo', 'mentoria');
    }

    public function scopeFeedbacks($query)
    {
        return $query->where('tipo', 'feedback');
    }

    public function scopeAvaliacoes($query)
    {
        return $query->where('tipo', 'avaliacao');
    }
} 