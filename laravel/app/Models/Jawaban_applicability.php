<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jawaban_applicability extends Model
{
    

    protected $primaryKey = 'id_jawaban';
    protected $table = 'tbl_jawaban_applicability';

    protected $fillable = [
        'id_responden',
        'ap1',
        'ap2',
        'kategori',
    ];
   
}