<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuadroSonhos extends Model
{
    use HasFactory;

    protected $table = 'quadro_dos_sonhos';

    protected $fillable = [
        'user_id',
        'titulo',
        'descricao',
        'imagem',
        'data_realizacao'
    ];

    protected $casts = [
        'data_realizacao' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 