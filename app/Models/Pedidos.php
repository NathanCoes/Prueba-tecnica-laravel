<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Clientes;
use App\Models\User;

class Pedidos extends Model
{
    use HasFactory;

    protected $table = 'pedidos';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_productos',
        'id_cliente',
        'id_direccion_envio',
        'fecha_creacion',
        'status',
        'creado_por',
        'updated_at',
        'created_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [

    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fecha_creacion' => 'datetime',
            'updated_at' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    // Relación con Cliente
    public function clientes()
    {
        return $this->belongsTo(Clientes::class, 'id_cliente');
    }

    // Relación con Usuarios
    public function usuarios()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    // Relación con Envios
    public function envios()
    {
        return $this->belongsTo(Envios::class, 'id_direccion_envio');
    }
}
