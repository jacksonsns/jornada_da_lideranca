<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Transacao extends Model
{
    use HasFactory;

    protected $table = 'transacoes';

    protected $fillable = [
        'user_id',
        'tipo',
        'valor',
        'descricao',
        'data',
        'categoria',
        'status',
        'comprovante',
        'observacoes'
    ];

    protected $casts = [
        'data' => 'datetime',
        'valor' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeReceitas(Builder $query)
    {
        return $query->where('tipo', 'receita');
    }

    public function scopeDespesas(Builder $query)
    {
        return $query->where('tipo', 'despesa');
    }

    public function scopeAprovadas(Builder $query)
    {
        return $query->where('status', 'aprovado');
    }

    public function scopePendentes(Builder $query)
    {
        return $query->where('status', 'pendente');
    }

    public function getValorFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->valor, 2, ',', '.');
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pendente' => '<span class="badge bg-warning">Pendente</span>',
            'aprovado' => '<span class="badge bg-success">Aprovado</span>',
            'rejeitado' => '<span class="badge bg-danger">Rejeitado</span>',
            default => '<span class="badge bg-secondary">' . ucfirst($this->status) . '</span>'
        };
    }

    public function getTipoBadgeAttribute()
    {
        return match($this->tipo) {
            'receita' => '<span class="badge bg-success">Receita</span>',
            'despesa' => '<span class="badge bg-danger">Despesa</span>',
            default => '<span class="badge bg-secondary">' . ucfirst($this->tipo) . '</span>'
        };
    }
} 