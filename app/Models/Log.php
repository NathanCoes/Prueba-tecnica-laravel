<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $table = 'logs';

    protected $fillable = [
        'hecho_por',
        'descripcion',
        'updated_at',
        'created_at'
    ];

    protected function casts(): array
    {
        return [
            'updated_at' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    // Relación con Cliente
    public function usuarios()
    {
        return $this->belongsTo(User::class, 'hecho_por');
    }
}
