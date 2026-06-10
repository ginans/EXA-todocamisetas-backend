<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Camiseta extends Model
{
    use HasFactory;

    protected $table = 'camisetas';

    protected $fillable = [
        'titulo',
        'club',
        'pais',
        'tipo',
        'color',
        'precio',
        'precio_oferta',
        'detalles',
        'codigo_producto',
    ];

    public function tallas(): BelongsToMany
    {
        return $this->belongsToMany(Talla::class, 'camiseta_talla')->withTimestamps();
    }

    public function clientes(): BelongsToMany
    {
        return $this->belongsToMany(Cliente::class, 'camiseta_cliente')->withTimestamps();
    }
}