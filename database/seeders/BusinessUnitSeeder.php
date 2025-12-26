<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusinessUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan data seeder - hanya data yang diinput manual yang akan ada
        $businessUnits = [];

        foreach ($businessUnits as $unit) {
            \App\Models\BusinessUnit::create($unit);
        }
    }
}
