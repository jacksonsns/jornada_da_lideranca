<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DesafioUser extends Model
{
    protected $table = 'desafio_user';

    protected $fillable = [
        'desafio_id',
        'user_id',
        'concluido',
        'concluido_em',
    ];

    protected $casts = [
        'concluido' => 'boolean',
        'concluido_em' => 'datetime',
    ];

    public function desafio(): BelongsTo
    {
        return $this->belongsTo(Desafio::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
