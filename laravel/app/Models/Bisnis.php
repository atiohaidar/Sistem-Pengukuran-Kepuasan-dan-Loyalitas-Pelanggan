<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bisnis extends Model
{
    protected $primaryKey = 'id_bisnis';
    protected $table = 'tbl_bisnis';

    protected $fillable = [
        'nama_bisnis',
        'keterangan'
    ];

    
}