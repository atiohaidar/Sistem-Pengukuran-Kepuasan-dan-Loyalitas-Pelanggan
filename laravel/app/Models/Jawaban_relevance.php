<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jawaban_relevance extends Model
{
    

    protected $primaryKey = 'id_jawaban';
    protected $table = 'tbl_jawaban_relevance';

    protected $fillable = [
        'id_responden',
        'rl1',
        'rl2',
        'rl3',
        'kategori',
    ];
   
}