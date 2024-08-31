<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserSeeder;
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

    public function testRegisterSuccess()
    {


        // $photo = base64_encode("tes foto");
        $photo = UploadedFile::fake()->image('avatar.jpg');

        $this->post('/api/v1/users', [
            'user_id' => '901111',
            'password' => '123456789',
            'name' => 'Joko Baswedan',
            'photo' => $photo,
            'rights' => ['buatCPL', 'editCPL', 'rancangKurikulum', 'editKurikulum']
        ])->assertStatus(201)
            ->assertJson([
                "userName" => "Joko Baswedan",
                'userRights' => ['buatCPL', 'editCPL', 'rancangKurikulum', 'editKurikulum']

            ]);

        $this->assertEquals($photo, base64_decode(User::where('user_id', '901111')->first()->photo));
    }

    public function testRegisterFailed()
    {
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

    public function testRegisterUsernameAlreadyExists()
    {
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

    public function testLoginSuccess()
    {

        $this->seed([UserSeeder::class]);
        $this->post('/api/v1/users/login', [
            'userID' => '901111',
            'pwd' => '123456789'
        ])->assertStatus(200)
            ->assertJson([
                'userName' => 'Joko Baswedan'
            ]);

        $user = User::where('user_id', '901111')->first();
        self::assertNotNull($user->token);
    }

    public function testLoginFailed()
    {
        $this->seed([UserSeeder::class]);
        $this->post('/api/v1/users/login', [
            'userID' => '901111',
            'pwd' => '1234456789'
        ])->assertStatus(401)
            ->assertJson([
                'errors' => [
                    'message' => [
                        'username or password wrong'
                    ]
                ]
            ]);

        $user = User::where('user_id', '901111')->first();
        self::assertNull($user->token);
    }
}
