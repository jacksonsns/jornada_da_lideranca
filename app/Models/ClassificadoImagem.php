<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassificadoImagem extends Model
{
    use HasFactory;

    protected $table = 'classificado_imagens';

    protected $fillable = [
        'classificado_id',
        'caminho',
    ];

    public function classificado()
    {
        return $this->belongsTo(Classificado::class);
    }
} 