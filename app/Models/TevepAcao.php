<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TevepAcao extends Model
{
    use HasFactory;

    // Usa a tabela existente criada pela migration `create_tevep_acoes_table`
    protected $table = 'tevep_acoes';

    protected $fillable = [
        'tevep_id',
        'prazo',
        'evento_acao',
        'espaco',
        'pessoas',
        'piloto',
        'recursos',
        'status',
    ];

    protected $casts = [
        'prazo' => 'date',
    ];

    public function tevep()
    {
        return $this->belongsTo(Tevep::class);
    }
}
