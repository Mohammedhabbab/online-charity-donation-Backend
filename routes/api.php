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
use App\Http\Controllers\PaymentController;
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



////Route::post('/insert_service', [ServicesController::class, 'store']);
Route::post('/insert_complain', [ComplaintsController::class, 'store']);
Route::get('/get_complain', [ComplaintsController::class, 'index']);
////Route::get('/get_services', [ServicesController::class, 'index']);
Route::post('/insert_company_data', [HomeController::class, 'insertcompanedata']);
////Route::post('images', [ImageController::class, 'store']);
////Route::post('/insert_need_type',[NeedsTypeController::class, 'store']);
////Route::post('/insert_service',[ServicesController::class, 'store']);
Route::post('/insert_company',[CompaniesController::class,'store']);
Route::get('/get_company',[CompaniesController::class,'index']);
////Route::get('/get_types',[NeedsTypeController::class,'index']);
////Route::post('/insert_dividable', [DividableDonationController::class, 'store']);
////Route::get('/get_dividable', [DividableDonationController::class, 'index']);
////Route::put('/update_dividable', [DividableDonationController::class, 'update']);
////Route::post('/inser_needs', [NeedsController::class, 'store']);
////Route::get('/get_needs', [NeedsController::class, 'index']);
////Route::post('/insert_hero', [HeroSectionController::class, 'store']);
////Route::get('/get_hero', [HeroSectionController::class, 'index']);
////Route::post('/insert_beneficiar',[BeneficiariesController::class, 'store']);
////Route::get('/get_beneficiar', [BeneficiariesController::class, 'index']);

//////////////////////////////////////////////////////////////////////////
Route::post('insert_beneficiar', [CharitesController::class,'register_Beneficiaries']);
Route::delete('delete_Beneficiaries/{id}',[CharitesController::class,'delete_Beneficiaries']);
Route::put('update_Beneficiaries/{id}',[CharitesController::class,'update_Beneficiaries']);
Route::get('get_beneficiaries/{charity_id}/{needy_type}', [CharitesController::class, 'get_beneficiaries_for_charity']);
Route::get('get_sponsored_beneficiaries/{charity_id}/{needy_type}', [CharitesController::class, 'get_sponsored_beneficiaries_for_charity']);
Route::get('get_notsponsored_beneficiaries/{charity_id}/{needy_type}', [CharitesController::class, 'get_notsponsored_beneficiaries_for_charity']);
Route::get('get_srvices_count_for_charity/{charity_id}',[CharitesController::class,'getNeedyCountByCharity']);
Route::get('get_needs_count_for_charity/{charity_id}',[CharitesController::class,'getNeedsCountByCharity']);
Route::get('get_all_donations_for_user/{users_id}', [ArchivesController::class, 'get_alldonations_for_user']);
Route::get('get_all_donations_for_charity/{users_id}', [ArchivesController::class, 'getNeedyAndNeedsCountByCharity']);
Route::get('search_beneficiaries/{id}', [ArchivesController::class, 'search_beneficiaries']);
//////////////////////
Route::post('insert_dividable', [CharitesController::class,'register_Dividable_donations']);
Route::delete('delete_Dividable_donations/{id}',[CharitesController::class,'delete_Dividable_donations']);
Route::put('update_dividable/{id}',[CharitesController::class,'update_Dividable_donations']);
Route::get('get_dividable/{charity_id}/{type}', [CharitesController::class, 'get_Dividable_donations_for_charity']);
Route::get('get_sponsored_Dividable/{charity_id}/{type}', [CharitesController::class, 'get_sponsored_Dividable_donations_for_charity']);
Route::get('get_notsponsored_Dividable/{charity_id}/{type}', [CharitesController::class, 'get_notsponsored_Dividable_donations_for_charity']);

/////////////////////
Route::post('insert_needs', [CharitesController::class,'register_Needs']);
Route::delete('delete_Needs/{id}',[CharitesController::class,'delete_Needs']);
Route::put('update_Needs/{id}',[CharitesController::class,'update_Needs']);
Route::get('get_needs_for_charity/{charity_id}/{type_of_proudct}',[CharitesController::class,'get_needs_for_charity']);
////////////////////
Route::post('register_Academic_fields', [CharitesController::class,'register_Academic_fields']);
Route::delete('delete_Academic_fields/{id}',[CharitesController::class,'delete_Academic_fields']);
Route::put('update_Academic_fields/{id}',[CharitesController::class,'update_Academic_fields']);
///////////////////
//////////////////
Route::post('insert_service', [AdminController::class,'register_Services']);
Route::delete('delete_Services/{id}',[AdminController::class,'delete_Services']);
Route::put('update_Services/{id}',[AdminController::class,'update_Services']);
Route::get('/get_services', [AdminController::class, 'index']);
////////////////////////////////
Route::post('insert_hero', [AdminController::class,'register_Hero_section']);
Route::delete('delete_Hero_section/{id}',[AdminController::class,'delete_Hero_section']);
Route::put('update_Hero_section/{id}',[AdminController::class,'update_Hero_section']);
Route::get('/get_hero', [AdminController::class, 'index1']);
//////////////////////////
Route::get('get_beneficiar', [AdminController::class, 'get_all_Beneficiaries']);
Route::get('get_dividable_donations', [AdminController::class, 'get_all_dividable_donations']);
Route::get('get_needs', [AdminController::class, 'get_needs']);
//////////////////////
Route::get('getProductsByType/{needs_type}', [CharitesController::class,'getProductsByType']);
Route::get('/products/{needs_type}/{charity_id}', [CharitesController::class,'getProductsByTypeAndCharity']);
/////////
Route::get('get_charities', [AdminController::class, 'get_all_Charities']);
Route::get('get_users', [AdminController::class, 'get_all_Users']);
Route::get('get_donations', [AdminController::class, 'get_all_Donations']);

Route::delete('delete_user/{id}', [AdminController::class, 'delete_Users']);
Route::post('/donate', [UserController::class,'makeDonation']);
////////////////////////
Route::post('/create-payment/{amount}', [PaymentController::class, 'createPayment']);
Route::get('/payment-callback/{paymentId}', [PaymentController::class, 'handleCallback']);
Route::post('/reverse-payment/{paymentId}', [PaymentController::class, 'reversePayment']);
////////////////////////
Route::get('/user-count', [AdminController::class, 'getUserCount']);
Route::get('/charity-count', [AdminController::class, 'getCharityCount']);
Route::get('/service-count', [AdminController::class, 'getServiceCount']);
Route::get('/beneficiary-count', [AdminController::class, 'getBeneficiaryCount']);
Route::get('/needs-count', [AdminController::class, 'getNeedsCount']);
Route::get('/complains-count', [AdminController::class, 'getComplainCount']);
Route::get('/heros-count', [AdminController::class, 'getHeroCount']);


Route::get('/archive-count', [AdminController::class, 'getArchiveCount']);
/////////
Route::get('get_charities', [AdminController::class, 'get_all_Charities']);
Route::get('get_users', [AdminController::class, 'get_all_Users']);
Route::delete('delete_user/{id}', [AdminController::class, 'delete_Users']);




Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {

    
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', [AuthController::class,'me']);
    Route::post('direct', [AuthController::class,'direct']);
    Route::delete('delete_user/{id}',[UserController::class,'delete_user']);
    Route::put('update_user/{id}',[UserController::class,'update_user']);
    Route::post('update_password',[UserController::class,'changePassword']);
});