<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\TeachingClassSeeder;
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
        $photo = UploadedFile::fake()->image('avatar.jpg');
        $binaryPhoto = file_get_contents($photo->getPathname());

        $this->post('/api/v1/users', [
            'user_id' => '901111',
            'password' => '123456789',
            'name' => 'Joko Baswedan',
            'photo' => $photo,
            'rights' => ['buatCPL', 'editCPL', 'rancangKurikulum', 'editKurikulum']
        ])->assertStatus(201)
            ->assertJson([
                "status" => "ok"
            ]);

        $savedPhoto = User::where('user_id', '901111')->first()->photo;

        $this->assertEquals($binaryPhoto, $savedPhoto);
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
                'message' => [
                    'Login Gagal'
                ]
            ]);

        $user = User::where('user_id', '901111')->first();
        self::assertNull($user->token);
    }

    public function testGetTeachingClass(){

        $this->seed([DatabaseSeeder::class, TeachingClassSeeder::class]);

        // get joko
        $this->post('/api/v1/users/class', [
            "class" => "list"
        ], [
            'Authorization' => 'contohABC'
        ])->assertJson([
            "class" => [
                "Basis Data Jumat 7.30-10.00"
            ]
        ]);

        // get anis
        $this->post('/api/v1/users/class', [
            "class" => "list"
        ] ,[
            'Authorization' => 'contohDEF'
        ])->assertJson([
            "class" => [
                "Grafika Rabu 7.30-10.00",
                "Grafika Kamis 13.30-15.00"
            ]
        ]);

        // get prabowo
        $this->post('/api/v1/users/class', [
            "class" => "list"
        ], [
            'Authorization' => 'contohGHI'
        ])->assertJson([
            "class" => [
                "Algoritma Senin 7.30-10.00",
                "Algoritma Selasa 13.30-15.00",
                "Algoritma Kamis 7.30-10.00"
            ]
        ]);
    }

    public function testLogoutSuccess(){
        $this->seed([DatabaseSeeder::class]);

        $this->delete(uri: '/api/v1/users/logout', headers: [
            'Authorization' => 'contoh'
        ])->assertStatus(200)
            ->assertJson([
                'status' => true
            ]);

        $user = User::where('token', 'contoh')->first();
        self::assertNull($user);
    }


    public function testLogoutFailed(){
        $this->seed([DatabaseSeeder::class]);

        $this->delete(uri: '/api/v1/users/logout', headers: [
            'Authorization' => 'contcdh'
        ])->assertStatus(401)
            ->assertJson([
                'status' => "Gagal"
            ]);
    }

}
