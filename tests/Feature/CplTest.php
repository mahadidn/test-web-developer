<?php

namespace Tests\Feature;

use Database\Seeders\CplSeeder;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CplTest extends TestCase
{

    public function testGetCpl(){

        $this->seed([DatabaseSeeder::class, CplSeeder::class]);

        $this->post('/api/v1/users/cpl/get', [
            "class" => "list"
        ], [
            'Authorization' => 'contohABC'
        ])->assertJson([
            "cpl" => [
                [
                    "kodecpl" => "CPL01",
                    "deskripsi" => "Mampu bekerja sama secara interpersonal"
                ],
                [
                    "kodecpl" => "CPL02",
                    "deskripsi" => "Menginternalisasi nilai keimanan"
                ]
            ]
        ]);

    }
    
    public function testAddCpl(){

        $this->seed([DatabaseSeeder::class]);

        $this->post(uri: '/api/v1/users/cpl', data: [
            "cpl" => [
                "kodecpl" => "CPL01",
                "deskripsi" => "Mampu bekerja sama secara interpersonal"

            ]            
        ], headers: [
            "Authorization" => "contohABC"
        ])->assertStatus(201)
            ->assertJson([
                "status" => "OK"
            ]);

    }
    

    public function testRemoveCpl(){

        $this->seed([DatabaseSeeder::class, CplSeeder::class]);

        $this->post('/api/v1/users/cpl/delete', [
                'cpl' => [
                    "kodecpl" => "CPL01"
                ]
            ], [
                'Authorization' => 'ContohABC'
            ])->assertStatus(403)
                ->assertJson([
                    "status" => "Gagal"
                ]);

    }

    public function testUpdateCpl(){

        $this->seed([DatabaseSeeder::class, CplSeeder::class]);

        $this->post('/api/v1/users/cpl/update', [
                'cpl' => [
                    "kodecpl" => "CPL01",
                    "deskripsi" => "test coba ubah"
                ]
            ], [
                'Authorization' => 'ContohABC'
            ])->assertStatus(201)
                ->assertJson([
                    "status" => "OK"
                ]);

    }

}
