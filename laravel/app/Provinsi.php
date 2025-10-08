<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'provinsi';

    protected $fillable = [
        'title',
    ];

    
}