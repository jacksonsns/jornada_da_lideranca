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
        'pontos',
        'ordem',
        'obrigatorio'
    ];

    protected $casts = [
        'obrigatorio' => 'boolean',
        'ordem' => 'integer'
    ];

    public function etapas()
    {
        return $this->hasMany(JornadaAspiranteEtapa::class)->orderBy('ordem');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'jornada_aspirante_user')
            ->withPivot('progresso', 'concluido')
            ->withTimestamps();
    }
} 