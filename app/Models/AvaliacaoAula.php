<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvaliacaoAula extends Model
{
    use HasFactory;

    protected $fillable = [
        'aula_id',
        'user_id',
        'avaliacao',
        'comentario'
    ];

    protected $casts = [
        'avaliacao' => 'integer'
    ];

    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 