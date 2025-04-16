<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaFinanceira extends Model
{
    use HasFactory;

    protected $table = 'area_financeira';

    protected $fillable = [
        'user_id',
        'tipo',
        'categoria',
        'valor',
        'descricao',
        'data',
        'status'
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'data' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 