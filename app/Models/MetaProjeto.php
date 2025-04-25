<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetaProjeto extends Model
{
    use HasFactory;

    protected $fillable = [
        'projeto_id',
        'descricao',
        'prazo',
        'status'
    ];

    protected $casts = [
        'prazo' => 'datetime'
    ];

    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pendente' => '<span class="badge bg-warning">Pendente</span>',
            'em_andamento' => '<span class="badge bg-primary">Em Andamento</span>',
            'concluida' => '<span class="badge bg-success">Concluída</span>',
            default => '<span class="badge bg-secondary">' . ucfirst($this->status) . '</span>'
        };
    }
} 