<?php

use App\Http\Controllers\Api\DevelopersApiController;
use App\Http\Controllers\Api\HireApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Developers'], function() {

    Route::get('/', [DevelopersApiController::class, 'index']);

    Route::post('/developers', [DevelopersApiController::class, 'create']);

    Route::put('/developers/edit/{developer}', [DevelopersApiController::class, 'update']);

    Route::delete('/developers/delete/{developer}', [DevelopersApiController::class, 'destroy']);
});

Route::group(['namespace' => 'Hire'], function() {

    Route::get('/hire', [HireApiController::class, 'index']);

    Route::post('/hire', [HireApiController::class, 'create']);

    Route::delete('/hire/delete/{hire}', [HireApiController::class, 'destroy']);
});
