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
    protected $fillable = ['id_penggunaan', 'id_pelanggan', 'bulan', 'tahun', 'jumlah_meter', 'status_pembayaran'];

    public function pelanggan() : BelongsTo
    {
        return $this->belongsTo(pelanggan::class, 'id_pelanggan', 'id');
    }

    public function penggunaan() : BelongsTo
    {
        return $this->belongsTo(penggunaan::class, 'id_penggunaan', 'id');
    }

    public function pembayaran() : HasOne
    {
        return $this->hasOne(pembayaran::class, 'id_tagihan', 'id');
    }
}
