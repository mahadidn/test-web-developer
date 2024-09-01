<?php

namespace Tests\Feature;

use Database\Seeders\CourseSeeder;
use Database\Seeders\CplSeeder;
use Database\Seeders\CpmkSeeder;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\TeachingClassSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CourseTest extends TestCase
{
    
    public function testListCourse(){

        $this->seed([DatabaseSeeder::class, TeachingClassSeeder::class, CplSeeder::class, CpmkSeeder::class, CourseSeeder::class]);

        $this->post(uri: '/api/v1/users/mk/get', data: [
            "mk" => "list"
        ], headers: [
            'Authorization' => 'contohABC'
        ])->assertStatus(201)
            ->assertJson([
                "mk" => [
                    [
                        "kodemk" => "UNIV12101",
                        "namamk" => "Agama",
                        "sks" => 3
                    ],
                    [
                        "kodemk" => "UNIV12102",
                        "namamk" => "Bahasa Indonesia",
                        "sks" => 4
                    ]
                ]
            ]);

    }

    public function testAddCourse(){

        $this->seed([DatabaseSeeder::class, TeachingClassSeeder::class, CplSeeder::class, CpmkSeeder::class, CourseSeeder::class]);

        $this->post(uri:'/api/v1/users/mk/add', data: [
            "mk" => [
                "kodemk" => "UNIV12103",
                "namamk" => "Bahasa Inggris",
                "sks" => 3
            ]
            ], headers: [
                'Authorization' => "contohABC"
            ])->assertStatus(201)
                ->assertJson([
                    "status" => "OK"
                ]);

    }

    public function testUpdateCourse(){

        $this->seed([DatabaseSeeder::class, TeachingClassSeeder::class, CplSeeder::class, CpmkSeeder::class, CourseSeeder::class]);

        $this->post(uri:'/api/v1/users/mk/update/univ12102', data: [
            "mk" => [
                "kodemk" => "UNIV12102",
                "namamk" => "B Indo coba ubah",
                "sks" => 5
            ]
            ], headers: [
                'Authorization' => 'contohABC'
            ])->assertStatus(201)
                ->assertJson([
                    "status" => "OK"
                ]);

    }

    public function testRemoveCourse(){

        $this->seed([DatabaseSeeder::class, TeachingClassSeeder::class, CplSeeder::class, CpmkSeeder::class, CourseSeeder::class]);
        
        $this->post(uri: '/api/v1/users/mk/remove', data: [
            'mk' => [
                'kodemk' => 'UNIV12102',
                'namamk' => 'Bahasa Indonesia',
                'sks' => '5'
            ]
            ], headers: [
                'Authorization' => 'contohABC'
            ])->assertStatus(201)
                ->assertJson([
                    "status" => "OK"
                ]);

    }

}
