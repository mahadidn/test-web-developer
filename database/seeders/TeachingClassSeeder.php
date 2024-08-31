<?php

namespace Database\Seeders;

use App\Models\TeachingClass;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeachingClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $joko = User::where('user_id', '901111')->first();
        $anis = User::where('user_id', 'Aa7610')->first();
        $prabowo = User::where('user_id', 'US$100')->first(); 

        $jokoClass = [
            "Basis Data Jumat 7.30-10.00"
        ];

        $prabowoClass = [
            "Algoritma Senin 7.30-10.00",
            "Algoritma Selasa 13.30-15.00",
            "Algoritma Kamis 7.30-10.00"
        ];

        $anisClass = [
            "Grafika Rabu 7.30-10.00",
            "Grafika Kamis 13.30-15.00"
        ];

        $i = 0;
        foreach ($prabowoClass as $value) {
            // prabowo
            TeachingClass::create([
                'user_id' => $prabowo->id,
                'class_name' => $value
            ]);

            // joko
            if ($i == 0){
                TeachingClass::create([
                    'user_id' => $joko->id,
                    'class_name' => $jokoClass[$i]
                ]);
            }

            if($i < 2){
                TeachingClass::create([
                    'user_id' => $anis->id,
                    'class_name' => $anisClass[$i]
                ]);
            }
            $i++;

        }

        
    }
}
