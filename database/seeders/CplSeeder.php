<?php

namespace Database\Seeders;

use App\Models\Cpl;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CplSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Cpl::create([
            'kode_cpl' => "CPL01",
            "deskripsi" => "Mampu bekerja sama secara interpersonal"
        ]);

        Cpl::create([
            "kode_cpl" => "CPL02",
            "deskripsi" => "Menginternalisasi nilai keimanan"
        ]);

    }
}
