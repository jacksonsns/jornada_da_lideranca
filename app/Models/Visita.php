<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    protected $table = 'visitas';
    
    protected $fillable = [
        'user_id',
        'secao'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 