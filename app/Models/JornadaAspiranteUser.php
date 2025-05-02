<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\JornadaAspirante;

class JornadaAspiranteUser extends Model
{
    protected $table = 'jornada_aspirante_user';

    protected $fillable = [
        'user_id',
        'jornada_aspirante_id',
        'concluido',
        'data_conclusao',
        'progresso',
    ];

    protected $casts = [
        'concluido' => 'boolean',
        'data_conclusao' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function jornada(): BelongsTo
    {
        return $this->belongsTo(JornadaAspirante::class, 'jornada_aspirante_id');
    }
}
