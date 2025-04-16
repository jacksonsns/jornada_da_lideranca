<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capacitacao extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descricao',
        'tipo',
        'data_inicio',
        'data_fim',
        'link_material',
        'ativo'
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim' => 'date',
        'ativo' => 'boolean'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'capacitacao_user')
            ->withPivot('concluido', 'data_conclusao')
            ->withTimestamps();
    }
} 