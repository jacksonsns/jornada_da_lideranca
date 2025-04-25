<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtualizacaoProjeto extends Model
{
    use HasFactory;

    protected $fillable = [
        'projeto_id',
        'descricao',
        'progresso',
        'dificuldades',
        'solucoes'
    ];

    protected $casts = [
        'progresso' => 'integer'
    ];

    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }

    public function getProgressoFormatadoAttribute()
    {
        return $this->progresso . '%';
    }
} 