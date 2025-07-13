<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class penggunaan extends Model
{
    /** @use HasFactory<\Database\Factories\PenggunaanFactory> */
    use HasFactory;

    protected $table = 'penggunaans';
    protected $fillable = ['id_pelanggan', 'bulan', 'tahun', 'meter_awal', 'meter_akhir'];

    public function pelanggan() : BelongsTo
    {
        return $this->belongsTo(pelanggan::class, 'id_pelanggan', 'id');
    }

    public function tagihan() : HasOne
    {
        return $this->hasOne(tagihan::class, 'id_penggunaan');
    }
}
