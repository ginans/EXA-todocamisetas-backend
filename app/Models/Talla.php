<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Talla extends Model
{
    use HasFactory;

    protected $table = 'tallas';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function camisetas(): BelongsToMany
    {
        return $this->belongsToMany(Camiseta::class, 'camiseta_talla')->withTimestamps();
    }
}