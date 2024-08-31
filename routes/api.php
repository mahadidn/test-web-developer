<?php

use App\Http\Controllers\v1\CplController;
use App\Http\Controllers\v1\TeachingClassController;
use App\Http\Controllers\v1\UserController;
use App\Http\Middleware\ApiAuthMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function(){

    Route::post('/users', [UserController::class, 'register']);
    Route::post('/users/login', [UserController::class, 'login']);    


    Route::middleware(ApiAuthMiddleware::class)->group(function(){

        // get class
        Route::post('/users/class', [TeachingClassController::class, 'getTeachingClass']);

        // cpl
        Route::post('/users/cpl/get', [CplController::class, 'get']);
        Route::post('/users/cpl', [CplController::class, 'add']);
        Route::post('/users/cpl/delete', [CplController::class, 'removeCpl']);
        Route::post('/users/cpl/update', [CplController::class, 'updateCpl']);

        Route::delete('/users/logout', [UserController::class, 'logout']);
    });

});
