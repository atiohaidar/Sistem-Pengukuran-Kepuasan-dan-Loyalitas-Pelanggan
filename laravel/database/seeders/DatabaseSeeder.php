<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call(\Database\Seeders\ProvinsiSeeder::class);
        $this->call(\Database\Seeders\DimensiSeeder::class);
        $this->call(\Database\Seeders\UserSeeder::class);
        $this->call(\Database\Seeders\RespondenSeeder::class);
        $this->call(\Database\Seeders\JawabanSeeder::class);
    }
}
