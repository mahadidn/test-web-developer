<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $photo = base64_encode(UploadedFile::fake()->image('avatar.jpg'));


        User::create([
            'user_id' => 'mahadi',
            'password' => Hash::make('mahadi123'),
            'name' => 'Mahadi Dwi Nugraha',
            'photo' => $photo,
            'rights' => json_encode(['buatCPL', 'editCPL', 'rancangKurikulum', 'editKurikulum'])
        ]);

        User::create([
            'user_id' => '901111',
            'password' => Hash::make('123456789'),
            'name' => 'Joko Baswedan',
            'photo' => $photo,
            'rights' => json_encode(['buatCPL', 'editCPL', 'rancangKurikulum', 'editKurikulum'])
        ]);

        User::create([
            'user_id' => 'Aa7610',
            'password' => Hash::make('123456789'),
            'name' => 'Anis Subianto',
            'photo' => $photo,
            'rights' => json_encode(['cetakLaporan', 'cetakRekap'])
        ]);

        User::create([
            'user_id' => 'US$100',
            'name' => 'Prabowo Widodo',
            'password' => Hash::make('123456789'),
            'photo' => $photo,
            'rights' => json_encode(['buatRPS', 'editRPS', 'buatBasisEvaluasi', 'editBasisEvaluasi', 'cetakLaporan', 'inputNilai'])
        ]);
        
    }
}
