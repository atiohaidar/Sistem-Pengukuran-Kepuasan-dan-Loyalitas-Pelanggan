<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jawaban_kritik_saran extends Model
{
    

    protected $primaryKey = 'id_jawaban';
    protected $table = 'tbl_jawaban_kritik_saran';

    protected $fillable = [
        'id_responden',
        'no1',
        'no2',
        'no3_online',
        'no3_offlone',
        'no3_streaming',
        'no3_elearning',
    ];
   
}