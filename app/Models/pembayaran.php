<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class pembayaran extends Model
{
    /** @use HasFactory<\Database\Factories\PembayaranFactory> */
    use HasFactory;

    protected $table = 'pembayarans';
    protected $fillable = ['id_tagihan', 'id_pelanggan', 'tanggal_pembayaran', 'bulan', 'biaya_admin', 'total_bayar', 'id_user'];

    public function tagihan() : BelongsTo
    {
        return $this->belongsTo(tagihan::class, 'id_tagihan', 'id');
    }

    public function pelanggan() : BelongsTo
    {
        return $this->belongsTo(pelanggan::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
