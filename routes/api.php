<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('user/profile', 'UsersController@profile')->name('profile');
// Route::middleware('auth:api')->get('user/logout', 'UsersController@logout')->name('logout');

Route::group(['prefix' => 'admin'], function () {
    Route::post('login', 'UsersController@adminLogin');
    Route::group(['middleware' => ['auth:api', 'role:superadmin']], function () {
        Route::post('profile', 'UsersController@adminProfile');
        Route::post('logout', 'UsersController@adminLogout');
    });
});


Route::post('login', 'UsersController@login')->name('login');
Route::get('token/{id}', 'UsersController@token')->name('token');
Route::post('logout', 'UsersController@logout')->name('logout');
Route::post('check_email_phone_exist', 'UsersController@check_email_phone_exist');
Route::post('register', 'UsersController@register');
Route::post('forgot_password', 'UsersController@forgotPassword');

// Route::get('/greetings/send', 'GreetingController@sendGreetings');
Route::get('/notification', 'InsuranceNotificationController@notification3');

Route::middleware('auth.custom')->post('client/change-pin', 'UsersController@changeMpin');
Route::middleware('auth.custom')->post('client/verify-pin', 'UsersController@verifyMpin');
Route::middleware('auth.custom')->post('client/profile', 'ClientController@profile');
Route::middleware('auth.custom')->post('client/profileupdate', 'ClientController@profileUpdate');
Route::middleware('auth.custom')->post('client/uploaduserdoc', 'ClientController@uploadUserDoc');
Route::middleware('auth.custom')->post('client/getuserdocuments', 'ClientController@getUserDocuments');
Route::middleware('auth.custom')->post('client/gettargetedsip', 'ClientController@getTargetedSIP');
Route::middleware('auth.custom')->post('client/removeuserdocument', 'ClientController@removeUserDocument');
Route::middleware('auth.custom')->post('client/mainscreen', 'ClientController@mainScreen');
Route::middleware('auth.custom')->post('clientplan/getuserplans', 'UserPlanController@getUserPlans');
Route::middleware('auth.custom')->post('clientplan/net-worth-report', 'UserMutualFundController@netWorthReport');
Route::middleware('auth.custom')->post('insurance/document/{policy_id}/{tbl_key}/{document}', 'PolicyDocumentsController@show')->name('policy-document.show');
Route::middleware('auth.custom')->post('insurance/types', 'Api\InsuranceController@index');
Route::middleware('auth.custom')->post('insurance/persons', 'Api\InsuranceController@persons');
Route::middleware('auth.custom')->post('insurance/list', 'Api\InsuranceController@list');
Route::middleware('auth.custom')->post('insurance/details/{id}', 'Api\InsuranceController@details');
Route::middleware('auth.custom')->post('insurance/ulip-request', 'Api\InsuranceController@ulipRequest');
Route::middleware('auth.custom')->post('insurance/get-ulip-requests', 'Api\InsuranceController@ulipRequestGet');

Route::middleware('auth.custom')->post('mutual-fund/scheme-wise', 'UserMutualFundController@schemeWise');
Route::middleware('auth.custom')->post('mutual-fund/sub-type-wise', 'UserMutualFundController@subTypeWise');
Route::middleware('auth.custom')->post('mutual-fund/sub-type-wise/{type_id}', 'UserMutualFundController@subTypeWise');
Route::middleware('auth.custom')->post('mutual-fund/get-company-funds', 'MutualFundController@getFundsByCompany');
Route::middleware('auth.custom')->post('policies', 'PolicyMasterController@userInsurance');
Route::middleware('auth.custom')->post('insurance', 'PolicyMasterController@userInsurance');



// Route::get('user', 'UsersController@all')->name('all');
// Route::get('user/{id}', 'UsersController@one')->name('one');
// Route::post('user', 'UsersController@create')->name('create');
// Route::post('user/edit/{id}', 'UsersController@edit')->name('edit');
// Route::delete('user/{id}', 'UsersController@destroy')->name('delete');

// Route::get('user', 'UsersController@all')->name('all');
