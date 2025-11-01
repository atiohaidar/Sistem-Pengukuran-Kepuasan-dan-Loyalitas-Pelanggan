<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RfmCustomer extends Model
{
    protected $fillable = [
        'umkm_id',
        'custom_id',
        'nama_lengkap',
        'jenis_kelamin',
        'jenis_pelanggan',
    ];

    public function umkm(): BelongsTo
    {
        return $this->belongsTo(UmkmProfile::class, 'umkm_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(RfmTransaction::class, 'customer_id');
    }
}
