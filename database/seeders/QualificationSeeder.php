<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QualificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan data seeder - hanya data yang diinput manual yang akan ada
        $qualifications = [];

        foreach ($qualifications as $qualification) {
            \App\Models\Qualification::create($qualification);
        }
    }
}
