<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class penggunaan extends Model
{
    /** @use HasFactory<\Database\Factories\PenggunaanFactory> */
    use HasFactory;

    protected $table = 'penggunaans';
    protected $fillable = ['id_pelanggan', 'bulan', 'tahun', 'meter_awal', 'meter_akhir'];

    public function pelanggan() : BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }
}
