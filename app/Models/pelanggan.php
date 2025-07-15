<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class pelanggan extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\PelangganFactory> */
    use HasFactory;

    protected $table = 'pelanggans';
    protected $fillable = ['id_tarif', 'username', 'password', 'nomor_kwh', 'nama_pelanggan', 'alamat'];
    protected $hidden = ['password'];

    public function tarif() : BelongsTo
    {
        return $this->belongsTo(tarif::class, 'id_tarif', 'id');
    }

    public function pembayaran() : HasMany
    {
        return $this->hasMany(pembayaran::class, 'id_pelanggan');
    }

    public function tagihan() : HasMany
    {
        return $this->hasMany(tagihan::class, 'id_pelanggan');
    }

    public function penggunaan() : HasMany
    {
        return $this->hasMany(penggunaan::class, 'id_pelanggan');
    }

    public static function searchByNomorKwh($query)
    {
        return self::where('nomor_kwh', 'LIKE', "%{$query}%")
            ->orWhere('nama_pelanggan', 'LIKE', "%{$query}%")
            ->select('id', 'nomor_kwh', 'nama_pelanggan')
            ->limit(10)
            ->get();
    }
}
