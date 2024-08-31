<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\UserRegisterRequest;
use App\Http\Resources\v1\UserResource;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $user->photo = base64_decode($data['photo']);
        $user->rights = json_encode($data['rights']);
        $user->save();

        return (new UserResource($user))->response()->setStatusCode(201);

    }
}
