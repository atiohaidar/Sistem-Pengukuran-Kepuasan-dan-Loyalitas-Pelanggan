<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pertanyaan_kat extends Model
{
    

    protected $primaryKey = 'id_dimensi';
    protected $table = 'tbl_dimensi';

    protected $fillable = [
        'nama_dimensi'
    ];
}