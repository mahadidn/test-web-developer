<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Course::create([
            'kode_mk' => "UNIV12101",
            "nama_mk" => "Agama",
            "sks" => 3
        ]);

        Course::create([
            'kode_mk' => "UNIV12102",
            "nama_mk" => "Bahasa Indonesia",
            "sks" => 4
        ]);

    }
}
