<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RfmTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\RfmTransaction::create([
            'customer_id' => 1,
            'umkm_id' => 1,
            'tanggal_transaksi' => '2025-10-01',
            'nilai_transaksi' => 50000,
        ]);

        \App\Models\RfmTransaction::create([
            'customer_id' => 1,
            'umkm_id' => 1,
            'tanggal_transaksi' => '2025-10-15',
            'nilai_transaksi' => 75000,
        ]);

        \App\Models\RfmTransaction::create([
            'customer_id' => 2,
            'umkm_id' => 1,
            'tanggal_transaksi' => '2025-09-20',
            'nilai_transaksi' => 30000,
        ]);

        \App\Models\RfmTransaction::create([
            'customer_id' => 3,
            'umkm_id' => 1,
            'tanggal_transaksi' => '2025-10-10',
            'nilai_transaksi' => 100000,
        ]);

        \App\Models\RfmTransaction::create([
            'customer_id' => 3,
            'umkm_id' => 1,
            'tanggal_transaksi' => '2025-10-20',
            'nilai_transaksi' => 60000,
        ]);
    }
}
