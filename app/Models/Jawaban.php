<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jawaban extends Model
{
    protected $primaryKey = 'id_jawaban';
    protected $table = 'tbl_jawaban';

    protected $fillable = [
        'id_responden',
        'dimensi_type',
        'kategori',
        'nilai',
    ];

    protected $casts = [
        'nilai' => 'array', // otomatis convert JSON ke array
    ];

    /**
     * Relationship dengan Responden
     */
    public function responden(): BelongsTo
    {
        return $this->belongsTo(Responden::class, 'id_responden', 'id_responden');
    }

    /**
     * Scope untuk filter berdasarkan dimensi type
     */
    public function scopeDimensi($query, string $dimensiType)
    {
        return $query->where('dimensi_type', $dimensiType);
    }

    /**
     * Scope untuk filter berdasarkan kategori (persepsi/harapan)
     */
    public function scopeKategori($query, string $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    /**
     * Helper method untuk mendapatkan nilai spesifik dari JSON
     */
    public function getNilai(string $key, $default = null)
    {
        return data_get($this->nilai, $key, $default);
    }

    /**
     * Helper method untuk set nilai spesifik ke JSON
     */
    public function setNilai(string $key, $value): void
    {
        $nilai = $this->nilai ?? [];
        data_set($nilai, $key, $value);
        $this->nilai = $nilai;
    }

    /**
     * Get rata-rata untuk dimensi tertentu
     */
    public static function getRataRataDimensi(string $dimensiType, string $kategori = null): float
    {
        $query = self::dimensi($dimensiType);

        if ($kategori) {
            $query->kategori($kategori);
        }

        $data = $query->get();

        if ($data->isEmpty()) {
            return 0.0;
        }

        $total = 0;
        $count = 0;

        foreach ($data as $item) {
            $nilaiArray = array_filter($item->nilai ?? []);
            if (!empty($nilaiArray)) {
                $total += array_sum($nilaiArray);
                $count += count($nilaiArray);
            }
        }

        return $count > 0 ? $total / $count : 0.0;
    }

    /**
     * Get count untuk dimensi tertentu
     */
    public static function getCountDimensi(string $dimensiType, string $kategori = null): int
    {
        $query = self::dimensi($dimensiType);

        if ($kategori) {
            $query->kategori($kategori);
        }

        return $query->count();
    }
}
