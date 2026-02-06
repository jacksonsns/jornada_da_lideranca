<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'user_id',
        'titulo',
        'descricao',
        'data_inicio',
        'data_fim',
        'local',
        'link_meet',
        'publico'
    ];

    protected $casts = [
        'data_inicio' => 'datetime',
        'data_fim' => 'datetime',
        'publico' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 