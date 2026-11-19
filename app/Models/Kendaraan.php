<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kendaraan extends Model
{
    protected $fillable = [
        'plat_nomor',
        'jenis_kendaraan',
        'warna',
        'nama_pemilik',
        'area_id',
    ];

    public function area(): BelongsTo
    {
        return $this->belongsTo(AreaParkir::class, 'area_id');
    }
}
