<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerManagementEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'maturity_data',
        'priority_data',
        'readiness_data',
    ];

    protected $casts = [
        'maturity_data' => 'array', // Cast sebagai array untuk skor maturity (misalnya: ['visi' => 3, 'strategi' => 4, ...])
        'priority_data' => 'array', // Cast sebagai array untuk nilai prioritas (misalnya: ['kepemimpinan_strategis' => 85.5, ...])
        'readiness_data' => 'array', // Cast sebagai array untuk skor readiness (misalnya: ['q1' => 4, 'q2' => 3, ...])
    ];
}