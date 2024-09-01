<?php

namespace Database\Seeders;

use App\Models\Cpmk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CpmkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Cpmk::create([
            "kode_cpl" => "CPL01",
            "kode_cpmk" => "CPMK011",
            "deskripsi" => "Mampu bekerja sama"
        ]);

        Cpmk::create([
            "kode_cpl" => "CPL01",
            "kode_cpmk" => "CPMK012",
            "deskripsi" => "Mampu berkomunikasi"
        ]);

    }
}
