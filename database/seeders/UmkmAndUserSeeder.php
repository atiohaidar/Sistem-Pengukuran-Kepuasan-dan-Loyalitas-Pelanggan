<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UmkmProfile;

class UmkmAndUserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Superadmin account
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('superadmin'),
            'role' => 'superadmin',
            'status' => 'approved',
        ]);

        // Sample UMKM profile
        $umkm = UmkmProfile::create([
            'nama_usaha' => 'UMKM Contoh',
            'deskripsi' => 'Contoh UMKM untuk testing fitur',
            'kategori_usaha' => 'Kuliner',
            'alamat' => 'Jl. Contoh No.1, Jakarta'
        ]);

        // Admin untuk UMKM tersebut
        User::create([
            'name' => 'Admin UMKM',
            'email' => 'admin@umkm.example.com',
            'password' => bcrypt('password'),
            'role' => 'umkm',
            'status' => 'approved',
            'umkm_id' => $umkm->id,
        ]);

        // Tambahan: user pending (belum approve)
        User::create([
            'name' => 'Pending UMKM Owner',
            'email' => 'pending@umkm.example.com',
            'password' => bcrypt('password'),
            'role' => 'umkm',
            'status' => 'pending',
        ]);
    }
}
