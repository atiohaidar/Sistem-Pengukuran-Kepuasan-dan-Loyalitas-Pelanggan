<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jawaban_assurance extends Model
{
    

    protected $primaryKey = 'id_jawaban';
    protected $table = 'tbl_jawaban_assurance';

    protected $fillable = [
        'id_responden',
        'a1',
        'a2',
        'a3',
        'a4',
        'a5',
        'kategori',
    ];
   
}