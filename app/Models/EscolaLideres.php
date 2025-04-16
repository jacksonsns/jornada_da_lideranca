<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EscolaLideres extends Model
{
    use HasFactory;

    protected $table = 'escola_lideres';

    protected $fillable = [
        'titulo',
        'descricao',
        'nivel',
        'duracao_minutos',
        'link_video',
        'link_material',
        'ativo'
    ];

    protected $casts = [
        'ativo' => 'boolean'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'escola_lideres_user')
            ->withPivot('concluido', 'data_conclusao')
            ->withTimestamps();
    }
} 