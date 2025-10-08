<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jawaban_tangible extends Model
{
    

    protected $primaryKey = 'id_jawaban';
    protected $table = 'tbl_jawaban_tangible';

    protected $fillable = [
        'id_responden',
        't1',
        't2',
        't3',
        't4',
        't5',
        't6',
        'kategori',
    ];
   
}