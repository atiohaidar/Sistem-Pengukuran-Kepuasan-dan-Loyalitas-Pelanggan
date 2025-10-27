<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UmkmProfile extends Model
{
    use HasFactory;

    protected $table = 'umkm_profiles';

    protected $fillable = [
        'nama_usaha',
        'deskripsi',
        'kategori_usaha',
        'alamat',
    ];

    /**
     * One UMKM has one user (primary admin)
     */
    public function user()
    {
        return $this->hasOne(User::class, 'umkm_id');
    }
}
