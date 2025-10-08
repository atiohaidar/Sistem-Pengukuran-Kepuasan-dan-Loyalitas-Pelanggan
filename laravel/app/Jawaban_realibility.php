<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jawaban_realibility extends Model
{
    

    protected $primaryKey = 'id_jawaban';
    protected $table = 'tbl_jawaban_realibility';

    protected $fillable = [
        'id_responden',
        'r1',
        'r2',
        'r3',
        'r4',
        'r5',
        'r6',
        'r7',
        'kategori',
    ];
   
}