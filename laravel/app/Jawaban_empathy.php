<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jawaban_empathy extends Model
{
    

    protected $primaryKey = 'id_jawaban';
    protected $table = 'tbl_jawaban_empathy';

    protected $fillable = [
        'id_responden',
        'e1',
        'e2',
        'e3',
        'e4',
        'e5',
        'e6',
        'kategori',
    ];
   
}