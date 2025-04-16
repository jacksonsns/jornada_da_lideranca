<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JornadaAspirante extends Model
{
    use HasFactory;

    protected $table = 'jornada_aspirante';

    protected $fillable = [
        'titulo',
        'descricao',
        'ordem',
        'obrigatorio'
    ];

    protected $casts = [
        'obrigatorio' => 'boolean'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'jornada_aspirante_user')
            ->withPivot('concluido', 'data_conclusao', 'progresso')
            ->withTimestamps();
    }
} 