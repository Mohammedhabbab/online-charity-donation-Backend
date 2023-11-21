<?php

// use App\Http\Controllers\Admin\AuthController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComplaintsController;
use App\Http\Controllers\Donation_typeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServicesController;
use App\Models\Admin;
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



 Route::post('/insert_service', [ServicesController::class, 'store']);
Route::post('/insert_complain', [ComplaintsController::class, 'store']);
Route::get('/get_complain', [ComplaintsController::class, 'index']);
Route::get('/get_services', [ServicesController::class, 'index']);
Route::post('/insert_company_data', [HomeController::class, 'insertcompanedata']);




Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', [AuthController::class,'me']);
    Route::delete('delete_user/{id}',[UserController::class,'delete_user']);
    Route::put('update_user',[UserController::class,'update_user']);

});