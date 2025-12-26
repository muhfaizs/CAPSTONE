<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tidak ada data dummy user

        // Seed the dropdown data
        $this->call([
            BusinessUnitSeeder::class,
            QualificationSeeder::class,
            LspSeeder::class,
        ]);
    }
}
