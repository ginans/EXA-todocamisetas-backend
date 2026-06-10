<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
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

    public static function allRecords(): Collection
    {
        return self::query()->orderBy('id')->get();
    }

    public static function findById(int $id): ?self
    {
        return self::query()->find($id);
    }

    public static function createRecord(array $data): self
    {
        return self::query()->create($data);
    }

    public static function updateRecord(int $id, array $data): ?self
    {
        $record = self::findById($id);

        if (!$record) {
            return null;
        }

        $record->update($data);

        return $record->fresh();
    }

    public static function deleteRecord(int $id): bool
    {
        $record = self::findById($id);

        if (!$record) {
            return false;
        }

        return (bool) $record->delete();
    }

    public function tallas(): BelongsToMany
    {
        return $this->belongsToMany(Talla::class, 'camiseta_talla')->withTimestamps();
    }

    public function clientes(): BelongsToMany
    {
        return $this->belongsToMany(Cliente::class, 'camiseta_cliente')->withTimestamps();
    }
}