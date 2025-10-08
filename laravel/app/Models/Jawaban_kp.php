<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jawaban_kp extends Model
{
    

    protected $primaryKey = 'id_jawaban';
    protected $table = 'tbl_jawaban_kp';

    protected $fillable = [
        'id_responden',
        'k1',
        'k2',
        'k3',
        'kategori',
    ];
   
}