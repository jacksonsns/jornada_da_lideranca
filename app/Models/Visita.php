<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    use BelongsToTenant;

    protected $table = 'visitas';
    
    protected $fillable = [
        'tenant_id',
        'user_id',
        'secao'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 