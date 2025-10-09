<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    

    protected $primaryKey = 'id_pertanyaan';
    protected $table = 'tbl_dimensi_pertanyaan';

    protected $fillable = [
        'id_dimensi',
        'pertanyaan',
        'kode'
    ];

    public function id_dimensi()
    {
        return $this->belongsTo('App\Models\Pertanyaan_kat','id_dimensi');
    }
}