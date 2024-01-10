<?php

// use App\Http\Controllers\Admin\AuthController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeneficiariesController;
use App\Http\Controllers\ArchivesController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\ComplaintsController;
use App\Http\Controllers\CharitesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NeedsTypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\DividableDonationController;
use App\Http\Controllers\HeroSectionController;
use App\Http\Controllers\NeedsController;
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



//Route::post('/insert_service', [ServicesController::class, 'store']);
Route::post('/insert_complain', [ComplaintsController::class, 'store']);
Route::get('/get_complain', [ComplaintsController::class, 'index']);
//Route::get('/get_services', [ServicesController::class, 'index']);
Route::post('/insert_company_data', [HomeController::class, 'insertcompanedata']);
//Route::post('images', [ImageController::class, 'store']);
//Route::post('/insert_need_type',[NeedsTypeController::class, 'store']);
//Route::post('/insert_service',[ServicesController::class, 'store']);
Route::post('/insert_company',[CompaniesController::class,'store']);
Route::get('/get_company',[CompaniesController::class,'index']);
//Route::get('/get_types',[NeedsTypeController::class,'index']);
//Route::post('/insert_dividable', [DividableDonationController::class, 'store']);
//Route::get('/get_dividable', [DividableDonationController::class, 'index']);
//Route::put('/update_dividable', [DividableDonationController::class, 'update']);
//Route::post('/inser_needs', [NeedsController::class, 'store']);
//Route::get('/get_needs', [NeedsController::class, 'index']);
//Route::post('/insert_hero', [HeroSectionController::class, 'store']);
//Route::get('/get_hero', [HeroSectionController::class, 'index']);
//Route::post('/insert_beneficiar',[BeneficiariesController::class, 'store']);
//Route::get('/get_beneficiar', [BeneficiariesController::class, 'index']);

//////////////////////////////////////////////////////////////////////////
Route::post('register_Beneficiaries', [CharitesController::class,'register_Beneficiaries']);
Route::delete('delete_Beneficiaries/{id}',[CharitesController::class,'delete_Beneficiaries']);
Route::put('update_Beneficiaries/{id}',[CharitesController::class,'update_Beneficiaries']);
Route::get('get_beneficiaries/{charity_id}/{needy_type}', [CharitesController::class, 'get_beneficiaries_for_charity']);
Route::get('get_sponsored_beneficiaries/{charity_id}/{needy_type}', [CharitesController::class, 'get_sponsored_beneficiaries_for_charity']);
Route::get('get_notsponsored_beneficiaries/{charity_id}/{needy_type}', [CharitesController::class, 'get_notsponsored_beneficiaries_for_charity']);
Route::get('get_srvices_count_for_charity/{charity_id}',[CharitesController::class,'getNeedyCountByCharity']);
Route::get('get_needs_count_for_charity/{charity_id}',[CharitesController::class,'getNeedsCountByCharity']);
Route::get('get_all_donations_for_user/{users_id}', [ArchivesController::class, 'get_alldonations_for_user']);
Route::get('get_all_donations_for_charity/{users_id}', [ArchivesController::class, 'getNeedyAndNeedsCountByCharity']);
//////////////////////
Route::post('register_Dividable_donations', [CharitesController::class,'register_Dividable_donations']);
Route::delete('delete_Dividable_donations/{id}',[CharitesController::class,'delete_Dividable_donations']);
Route::put('update_Dividable_donations/{id}',[CharitesController::class,'update_Dividable_donations']);
Route::get('get_Dividable/{charity_id}/{type}', [CharitesController::class, 'get_Dividable_donations_for_charity']);
Route::get('get_sponsored_Dividable/{charity_id}/{type}', [CharitesController::class, 'get_sponsored_Dividable_donations_for_charity']);
Route::get('get_notsponsored_Dividable/{charity_id}/{type}', [CharitesController::class, 'get_notsponsored_Dividable_donations_for_charity']);

/////////////////////
Route::post('register_Needs', [CharitesController::class,'register_Needs']);
Route::delete('delete_Needs/{id}',[CharitesController::class,'delete_Needs']);
Route::put('update_Needs/{id}',[CharitesController::class,'update_Needs']);
Route::get('get_needs_for_charity/{charity_id}/{type_of_proudct}',[CharitesController::class,'get_needs_for_charity']);
////////////////////
Route::post('register_Academic_fields', [CharitesController::class,'register_Academic_fields']);
Route::delete('delete_Academic_fields/{id}',[CharitesController::class,'delete_Academic_fields']);
Route::put('update_Academic_fields/{id}',[CharitesController::class,'update_Academic_fields']);
///////////////////
//////////////////
Route::post('register_Services', [AdminController::class,'register_Services']);
Route::delete('delete_Services/{id}',[AdminController::class,'delete_Services']);
Route::put('update_Services/{id}',[AdminController::class,'update_Services']);
////////////////////////////////
Route::post('register_Hero_section', [AdminController::class,'register_Hero_section']);
Route::delete('delete_Hero_section/{id}',[AdminController::class,'delete_Hero_section']);
Route::put('update_Hero_section/{id}',[AdminController::class,'update_Hero_section']);
//////////////////////////
Route::get('get_Beneficiaries', [AdminController::class, 'get_all_Beneficiaries']);
Route::get('get_dividable_donations', [AdminController::class, 'get_all_dividable_donations']);
Route::get('get_needs', [AdminController::class, 'get_needs']);




Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', [AuthController::class,'me']);
    Route::post('direct', [AuthController::class,'direct']);
    Route::delete('delete_user/{id}',[UserController::class,'delete_user']);
    Route::put('update_user',[UserController::class,'update_user']);

});