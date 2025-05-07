<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjetoIndividual extends Model
{
    use HasFactory;

    protected $table = 'projeto_individual';

    protected $fillable = [
        'user_id',
        'titulo',
        'descricao',
        'status',
        'data_inicio',
        'data_fim',
        'resultados'
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim' => 'date'
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