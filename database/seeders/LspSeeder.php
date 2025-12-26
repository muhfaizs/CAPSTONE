<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LspSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan data seeder - hanya data yang diinput manual yang akan ada
        $lsps = [];

        foreach ($lsps as $lsp) {
            \App\Models\Lsp::create($lsp);
        }
    }
}
