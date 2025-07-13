<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class pelanggan extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\PelangganFactory> */
    use HasFactory;

    protected $table = 'pelanggans';
    protected $fillable = ['id_tarif', 'username', 'password', 'nomor_KWh', 'nama_pelanggan'];
    protected $hidden = ['password'];

    public function tarif() : BelongsTo
    {
        return $this->belongsTo(Tarif::class, 'id_tarif');
    }
}
