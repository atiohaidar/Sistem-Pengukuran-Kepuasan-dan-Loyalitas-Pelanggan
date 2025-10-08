<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jawaban_lp extends Model
{
    

    protected $primaryKey = 'id_jawaban';
    protected $table = 'tbl_jawaban_lp';

    protected $fillable = [
        'id_responden',
        'l1',
        'l2',
        'l3',
        'kategori',
    ];
   
}