<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Donation_typeController;
use App\Http\Controllers\HomeController;
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

Route::middleware('auths')->get('/users', function (Request $request) {
    return $request->user();
});
Route::post('register', [AuthController::class,'register']);
Route::get('approve/{id}', [AuthController::class,'approve']);
//Route::get('register/{id}', [AuthController::class,'register']);
Route::post('login', [AuthController::class,'login']);

Route::post('/insert_type', [Donation_typeController::class, 'inserttype']);
Route::get('/get_donation_types', [Donation_typeController::class, 'getAllData']);

Route::post('/insert_company_data', [HomeController::class, 'insertcompanedata']);
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', [AuthController::class,'me']);
    Route::delete('delete_user/{id}',[AuthController::class,'delete_user']);
    Route::put('update_user',[AuthController::class,'update_user']);

});