<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capacitacao extends Model
{
    use HasFactory;

    protected $table = 'capacitacoes';

    protected $fillable = [
        'data',
        'titulo',
        'insights',
        'material_url'
    ];

    protected $casts = [
        'data' => 'date'
    ];
}