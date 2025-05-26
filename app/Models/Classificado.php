<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classificado extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'titulo',
        'descricao',
        'preco',
        'categoria',
        'estado',
        'cidade',
        'bairro',
        'telefone',
        'destaque',
        'ativo',
        'visualizacoes',
    ];

    protected $casts = [
        'destaque' => 'boolean',
        'ativo' => 'boolean',
        'preco' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function imagens()
    {
        return $this->hasMany(ClassificadoImagem::class);
    }

    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeDestaques($query)
    {
        return $query->where('destaque', true);
    }

    public function scopePorCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    public function scopePorLocalizacao($query, $estado, $cidade = null)
    {
        $query->where('estado', $estado);
        
        if ($cidade) {
            $query->where('cidade', $cidade);
        }
        
        return $query;
    }
}
