<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class tarif extends Model
{
    /** @use HasFactory<\Database\Factories\TarifFactory> */
    use HasFactory;

    protected $table = 'tarifs';
    protected $fillable = ['daya', 'tarif_per_kWh'];

    public function pelanggan(): HasMany
    {
        return $this->hasMany(Pelanggan::class, 'id_tarif');
    }
}
