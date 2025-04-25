<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'titulo',
        'descricao',
        'objetivo',
        'data_inicio',
        'data_fim',
        'status',
        'progresso',
        'metas_5_anos',
        'indicadores_sucesso',
        'recursos_necessarios'
    ];

    protected $casts = [
        'data_inicio' => 'datetime',
        'data_fim' => 'datetime',
        'progresso' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mentores()
    {
        return $this->belongsToMany(User::class, 'projeto_mentores', 'projeto_id', 'mentor_id')
            ->withTimestamps();
    }

    public function metas()
    {
        return $this->hasMany(MetaProjeto::class);
    }

    public function atualizacoes()
    {
        return $this->hasMany(AtualizacaoProjeto::class);
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'planejamento' => '<span class="badge bg-info">Planejamento</span>',
            'em_andamento' => '<span class="badge bg-primary">Em Andamento</span>',
            'concluido' => '<span class="badge bg-success">Concluído</span>',
            'suspenso' => '<span class="badge bg-warning">Suspenso</span>',
            default => '<span class="badge bg-secondary">' . ucfirst($this->status) . '</span>'
        };
    }

    public function getProgressoFormatadoAttribute()
    {
        return $this->progresso . '%';
    }
} 