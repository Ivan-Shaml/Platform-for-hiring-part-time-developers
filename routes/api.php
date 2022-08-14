<?php

use App\Models\Developer;
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


Route::get('/developers', function() {
   return Developer::all();
});

Route::post('/developers', function() {
    return Developer::create([
        'name' => request('name'),
        'email' => request('email'),
        'phone' => request('phone'),
        'location' => request('location'),
        'profile_picture' => request('profile_picture'),
        'price_per_hour' => request('price_per_hour'),
        'technology' => request('technology'),
        'description' => request('description'),
        'years_of_experience' => request('years_of_experience'),
        'native_language' => request('native_language'),
        'linkedin_profile_link' => request('linkedin_profile_link'),
    ]);
});

Route::put('/developers/edit/{developer}', function(Developer $developer){
    $developer->update([
        'name' => request('name'),
        'email' => request('email'),
        'phone' => request('phone'),
        'location' => request('location'),
        'profile_picture' => request('profile_picture'),
        'price_per_hour' => request('price_per_hour'),
        'technology' => request('technology'),
        'description' => request('description'),
        'years_of_experience' => request('years_of_experience'),
        'native_language' => request('native_language'),
        'linkedin_profile_link' => request('linkedin_profile_link'),
    ]);
});

Route::delete('/developers/delete/{developer}', function(Developer $developer) {
       $success_delete = $developer->delete();

       return [
         'success' => $success_delete
       ];
});
