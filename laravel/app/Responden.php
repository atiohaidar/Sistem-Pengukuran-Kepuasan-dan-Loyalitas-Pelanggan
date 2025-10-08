<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Responden extends Model
{
    

    protected $primaryKey = 'id_responden';
    protected $table = 'tbl_responden';

    protected $fillable = [
        'id_bisnis',
        'email',
        'whatsapp',
        'jk',
        'usia',
        'pekerjaan',
        'pekerjaan_lain',
        'domisili',
    ];

    public function bisnis()
    {
    	return $this->belongsTo('App\Bisnis','id_bisnis');
    }

    public function domi()
    {
    	return $this->belongsTo('App\Provinsi','domisili');
    }
}