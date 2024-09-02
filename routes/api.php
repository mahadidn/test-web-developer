<?php

use App\Http\Controllers\v1\CourseController;
use App\Http\Controllers\v1\CplController;
use App\Http\Controllers\v1\CpmkController;
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
        Route::post('/users/cpl/update/{kodecpmk}', [CplController::class, 'updateCpl']);


        // cpmk
        Route::post('/users/cpmk/get', [CpmkController::class, 'list']);
        Route::post('/users/cpmk/add', [CpmkController::class, 'addCpmk']);
        Route::post('/users/cpmk/remove/{kodecpmk}', [CpmkController::class, 'removeCpmk']);
        Route::post('/users/cpmk/update/{kodecpmk}', [CpmkController::class, 'updateCpmk']);

        // course
        Route::post('/users/mk/get', [CourseController::class, 'listCourse']);
        Route::post('/users/mk/add', [CourseController::class, 'addCourse']);
        Route::post('/users/mk/remove', [CourseController::class, 'removeCourse']);
        Route::post('/users/mk/update/{kodemk}', [CourseController::class, 'updateCourse']);


        Route::delete('/users/logout', [UserController::class, 'logout']);
    });

});
