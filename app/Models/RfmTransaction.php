<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RfmTransaction extends Model
{
    protected $fillable = [
        'customer_id',
        'umkm_id',
        'tanggal_transaksi',
        'nilai_transaksi',
    ];

    protected $casts = [
        'tanggal_transaksi' => 'date',
        'nilai_transaksi' => 'decimal:2',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(RfmCustomer::class, 'customer_id');
    }

    public function umkm(): BelongsTo
    {
        return $this->belongsTo(UmkmProfile::class, 'umkm_id');
    }
}
