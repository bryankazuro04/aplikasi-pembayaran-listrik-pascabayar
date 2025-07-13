<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class tagihan extends Model
{
    /** @use HasFactory<\Database\Factories\TagihanFactory> */
    use HasFactory;

    protected $table = 'tagihans';
    protected $fillable = ['id_penggunaan', 'id_pelanggan', 'bulan', 'tahun', 'jumlah_', 'status_pembayaran'];

    public function pelanggan() : BelongsTo
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function penggunaan() : BelongsTo
    {
        return $this->belongsTo(Penggunaan::class);
    }

    public function pembayaran() : HasOne
    {
        return $this->hasOne(Pembayaran::class, 'id_tagihan', 'id');
    }
}
