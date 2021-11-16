<?php

use Illuminate\Http\Request;

Route::post('login', 'Admin\ProfileController@login');

Route::middleware(['auth:api', 'role:superadmin'])->group(function () {
    Route::post('logout', 'Admin\ProfileController@logout');
    Route::get('profile', 'Admin\ProfileController@profile');
    Route::post('change-password', 'Admin\PasswordController@changePassword');
    Route::post('clients', 'Admin\ClientAdminController@store');
    Route::get('clients/show/{id}', 'Admin\ClientAdminController@show');
    Route::get('clients/', 'Admin\ClientAdminController@index');
    Route::put('clients/update/{id}', 'Admin\ClientAdminController@update');
    Route::delete('clients/delete/{id}', 'Admin\ClientAdminController@destroy');
    Route::post('clients/change-password/{id}', 'Admin\PasswordController@clientPasswordChange');
});
