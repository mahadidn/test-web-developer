<?php

namespace Tests\Feature;

use Database\Seeders\CplSeeder;
use Database\Seeders\CpmkSeeder;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CpmkTest extends TestCase
{

    public function testListCpmk()
    {

        $this->seed([DatabaseSeeder::class, CplSeeder::class, CpmkSeeder::class]);

        $this->post('/api/v1/users/cpmk/get', [
            "cpmk" => [
                "list"
            ]
        ], [
            "Authorization" => "contohABC"
        ])->assertStatus(201)
            ->assertJson([
                "cpmk" => [
                    [
                        "kodecpl" => "CPL01",
                        "kodecpmk" => "CPMK011",
                        "deskripsi" => "Mampu bekerja sama"
                    ],
                    [
                        "kodecpl" => "CPL01",
                        "kodecpmk" => "CPMK012",
                        "deskripsi" => "Mampu berkomunikasi"
                    ]

                ]
            ]);
    }


    public function testAddCpmk()
    {
        $this->seed([DatabaseSeeder::class, CplSeeder::class, CpmkSeeder::class]);

        $this->post(uri: '/api/v1/users/cpmk/add', data: [
            "cpmk" => [
                "kodecpl" => "CPL02",
                "kodecpmk" => "CPMK013",
                "deskripsi" => "Testing doang :v"
            ]
        ], headers: [
            "Authorization" => "contohABC"
        ])->assertStatus(403)
            ->assertJson([
                "status" => "Gagal"
            ]);

    }

    public function testUpdateCpmk(){

        $this->seed([DatabaseSeeder::class, CplSeeder::class, CpmkSeeder::class]);

        $this->post(uri: '/api/v1/users/cpmk/update/cpmk012', data: [
            "cpmk" => [
                "kodecpl" => "CPL02",
                "kodecpmk" => "CPMK012",
                "deskripsi" => "Mampu Berkomunikasi coba ubah"
            ]
        ], headers: [
            "Authorization" => "contohABC"
        ])->assertStatus(403)
            ->assertJson([
                "status" => "Gagal"
            ]);

    }

    public function testRemoveCpmk(){

        $this->seed([DatabaseSeeder::class, CplSeeder::class, CpmkSeeder::class]);

        $this->post(uri: '/api/v1/users/cpmk/remove/cpmk011', data: [
            "cpmk" => [
                "kodecpmk" => "CPMK011",
            ]
        ], headers: [
            "Authorization" => "contohABC"
        ])->assertStatus(403)
            ->assertJson([
                "status" => "Gagal"
            ]);

    }

    
}
