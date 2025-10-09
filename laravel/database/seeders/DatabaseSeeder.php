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
        $this->call(\Database\Seeders\JawabanMigrationSeeder::class);
        $this->call(\Database\Seeders\ProvinsiSeeder::class);
        $this->call(\Database\Seeders\DimensiSeeder::class);

        // Only seed users if none exist
        if (\App\Models\User::count() === 0) {
            $this->call(\Database\Seeders\UserSeeder::class);
        }

        $this->call(\Database\Seeders\RespondenSeeder::class);

        // Seed sample jawaban data for testing
        $this->call(\Database\Seeders\SampleJawabanSeeder::class);
    }
}
