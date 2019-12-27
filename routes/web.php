<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile', 'ProfileController@index')->name('profile');
Route::get('/edit_profile', 'ProfileController@edit_profile')->name('edit_profile');
Route::get('/edit_profile_image', 'ProfileImageController@index')->name('edit_profile_image');
Route::post('/update_profile', 'ProfileController@update_profile')->name('update_profile');
Route::post('/upload_profile_image', 'ProfileImageController@store')->name('upload_profile_image');
