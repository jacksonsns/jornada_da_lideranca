<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuadroDosSonhos extends Model
{
    use HasFactory;

    protected $table = 'quadro_dos_sonhos';

    protected $fillable = [
        'user_id',
        'titulo',
        'descricao',
        'categoria',
        'data_limite',
        'concluido'
    ];

    protected $casts = [
        'data_limite' => 'date',
        'concluido' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 