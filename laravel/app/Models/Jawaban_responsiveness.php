<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jawaban_responsiveness extends Model
{
    

    protected $primaryKey = 'id_jawaban';
    protected $table = 'tbl_jawaban_responsiveness';

    protected $fillable = [
        'id_responden',
        'rs1',
        'rs2',
        'rs3',
        'rs4',
        'rs5',
        'kategori',
    ];
   
}