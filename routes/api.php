<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RefreshTokenController;
use App\Http\Controllers\RegisterController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middleware' => 'guest'], function () {

    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisterController::class, 'register']);

});

Route::group(['middleware' => 'auth:api'], function () {

    Route::post('/logout', [LoginController::class, 'logout']);
    Route::post('/refresh', [RefreshTokenController::class, 'refresh']);

    Route::apiResource('categories', CategoryController::class)->missing(
        fn() => response()->json(['message' => 'Not Found'], 404)
    );
    Route::apiResource('products', ProductController::class)->missing(
        fn() => response()->json(['message' => 'Not Found'], 404)
    );

});

