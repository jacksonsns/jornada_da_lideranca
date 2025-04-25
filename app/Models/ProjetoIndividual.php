<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjetoIndividual extends Model
{
    use HasFactory;

    protected $table = 'projetos_individuais';

    protected $fillable = [
        'user_id',
        'titulo',
        'descricao',
        'objetivo',
        'data_inicio',
        'data_fim',
        'status',
        'progresso',
        'meta_5_anos',
        'indicadores_sucesso',
        'recursos_necessarios'
    ];

    protected $casts = [
        'data_inicio' => 'datetime',
        'data_fim' => 'datetime',
        'progresso' => 'integer',
        'indicadores_sucesso' => 'array',
        'recursos_necessarios' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function metas()
    {
        return $this->hasMany(MetaProjeto::class, 'projeto_id');
    }

    public function atualizacoes()
    {
        return $this->hasMany(AtualizacaoProjeto::class, 'projeto_id');
    }

    public function financeiro()
    {
        return $this->hasMany(AreaFinanceira::class, 'projeto_id');
    }

    public function mentores()
    {
        return $this->belongsToMany(User::class, 'projeto_mentores', 'projeto_id', 'mentor_id')
            ->withPivot('data_inicio', 'data_fim', 'feedback')
            ->withTimestamps();
    }
} 