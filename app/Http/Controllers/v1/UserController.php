<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\UserLoginRequest;
use App\Http\Requests\v1\UserRegisterRequest;
use App\Http\Resources\v1\UserResource;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function register(UserRegisterRequest $request): JsonResponse {

        $data = $request->validated();
        if(User::where('user_id', $data['user_id'])->count() == 1){
            throw new HttpResponseException(response([
                'errors' => [
                    'username' => [
                        'username already registered'
                    ]
                ]
            ], 400));
        }

        $user = new User($data);
        $user->password = Hash::make($data['password']);
        $user->photo = file_get_contents($request->file('photo')->getRealPath());
        $user->rights = json_encode($data['rights']);
        $user->save();

        return response()->json([
            "status" => "ok"
        ], 201);

    }




    public function login(UserLoginRequest $request): UserResource {

        $data = $request->validated();

        $user = User::where('user_id', $data['userID'])->first();
        if(!$user || !Hash::check($data['pwd'], $user->password)){
            throw new HttpResponseException(response([
                'message' => [
                    'Login Gagal'
                ]
                
            ], 401));
        }

        $user->token = Str::uuid()->toString();
        $user->save();

        $photoData = base64_encode($user->photo);
        $photoMimeType = "image/jpg";
        $photoBase64 = "data:$photoMimeType;base64,$photoData";
        $user->photo = $photoBase64;

        return new UserResource($user);

    }

    public function logout(Request $request): JsonResponse {

        $user = User::where('token', Auth::user()->token)->first();
        $user->token = null;
        $user->save();

        return response()->json([
            'status' => true
        ])->setStatusCode(200);

    }

}
