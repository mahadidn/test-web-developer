<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    public function testRegisterSuccess(){


        // $photo = base64_encode("tes foto");
        $photo = base64_encode(UploadedFile::fake()->image('avatar.jpg'));

        $this->post('/api/v1/users', [
            'user_id' => '901111',
            'password' => '123456789',
            'name' => 'Joko Baswedan',
            'photo' => $photo,
            'rights' => ['buatCPL', 'editCPL', 'rancangKurikulum', 'editKurikulum']
        ])->assertStatus(201)
            ->assertJson([
                "data" => [
                    "user_id" => "901111",
                    "name" => "Joko Baswedan",
                    'rights' => json_encode(['buatCPL', 'editCPL', 'rancangKurikulum', 'editKurikulum'])
                ]
            ]);

        $this->assertEquals($photo, base64_encode(User::where('user_id', '901111')->first()->photo));

    }

    public function testRegisterFailed(){
        $photo = base64_encode(UploadedFile::fake()->image('avatar.jpg'));

        $this->post('/api/v1/users', [
            'user_id' => '',
            'password' => '',
            'name' => '',
            'photo' => $photo,
            'rights' => ['buatCPL', 'editCPL', 'rancangKurikulum', 'editKurikulum']
        ])->assertStatus(400)->assertJson([
            'errors' => [
                "user_id" => [
                    "The user id field is required."
                ],
                "password" => [
                    "The password field is required."
                ],
                "name" => [
                    "The name field must be a string."
                ]
            ]
        ]);
    }

    public function testRegisterUsernameAlreadyExists(){
        $this->testRegisterSuccess();

        $photo = base64_encode(UploadedFile::fake()->image('avatar.jpg'));

        $this->post('/api/v1/users', [
            'user_id' => '901111',
            'password' => '123456789',
            'name' => 'Joko Baswedan',
            'photo' => $photo,
            'rights' => ['buatCPL', 'editCPL', 'rancangKurikulum', 'editKurikulum']
        ])->assertStatus(400)->assertJson([
            'errors' => [
                "user_id" => [
                    "The user id has already been taken."
                ],
            ]
        ]);

    }

}
