<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaFinanceira extends Model
{
    use HasFactory;

    protected $table = 'area_financeira';

    protected $fillable = [
        'projeto_id',
        'user_id',
        'tipo', // receita ou despesa
        'descricao',
        'valor',
        'data_lancamento',
        'categoria',
        'status',
        'comprovante'
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'data_lancamento' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function projeto()
    {
        return $this->belongsTo(ProjetoIndividual::class, 'projeto_id');
    }

    public function scopeReceitas($query)
    {
        return $query->where('tipo', 'receita');
    }

    public function scopeDespesas($query)
    {
        return $query->where('tipo', 'despesa');
    }
} 