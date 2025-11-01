<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RfmCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\RfmCustomer::create([
            'umkm_id' => 1,
            'custom_id' => 'CUST001',
            'nama_lengkap' => 'John Doe',
            'jenis_kelamin' => 'L',
            'jenis_pelanggan' => 'regular',
        ]);

        \App\Models\RfmCustomer::create([
            'umkm_id' => 1,
            'custom_id' => 'STUDENT001',
            'nama_lengkap' => 'Jane Smith',
            'jenis_kelamin' => 'P',
            'jenis_pelanggan' => 'student',
        ]);

        \App\Models\RfmCustomer::create([
            'umkm_id' => 1,
            'custom_id' => 'CUST002',
            'nama_lengkap' => 'Bob Johnson',
            'jenis_kelamin' => 'L',
            'jenis_pelanggan' => 'regular',
        ]);
    }
}
