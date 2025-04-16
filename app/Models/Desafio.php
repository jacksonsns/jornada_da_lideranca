<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desafio extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descricao',
        'pontos',
        'tipo'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('concluido', 'concluido_em')
            ->withTimestamps();
    }
}