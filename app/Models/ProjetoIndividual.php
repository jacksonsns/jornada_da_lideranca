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
} 