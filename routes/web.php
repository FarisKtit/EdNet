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
Route::get('/relationships', 'RelationshipController@index')->name('relationships');
Route::get('/get_relationships', 'RelationshipController@get_relationships')->name('get_relationships');
Route::get('/user_profile/{id}', 'ProfileController@view_user_profile')->name('view_user_profile');
Route::get('/get_user_posts', 'PostController@get_user_posts')->name('get_user_posts');

Route::get('/get_all_comments_for_post', 'PostCommentController@get_all_comments_for_post')->name('get_all_comments_for_post');

Route::post('/search_users', 'RelationshipController@search')->name('search_user');
Route::post('/update_profile', 'ProfileController@update_profile')->name('update_profile');
Route::post('/upload_profile_image', 'ProfileImageController@store')->name('upload_profile_image');
Route::post('/create_post', 'PostController@store')->name('create_post');
// Route::post('/create_post_on_wall', 'PostController@store')->name('create_post_on_wall');
Route::post('/form_relationship', 'RelationshipController@store')->name('form_relationship');
Route::post('/accept_relationship', 'RelationshipController@accept_request')->name('accept_relationship');
Route::post('/reject_relationship', 'RelationshipController@reject_request')->name('reject_relationship');
Route::post('/delete_relationship', 'RelationshipController@delete_relationship')->name('delete_relationship');
Route::post('/cancel_relationship_request', 'RelationshipController@cancel_relationship_request')->name('cancel_relationship_request');
Route::post('/add_like_to_post', 'LikeController@add_like_to_post')->name('add_like_to_post');
Route::post('/remove_like_from_post', 'LikeController@remove_like_from_post')->name('remove_like_from_post');

Route::post('add_comment_to_post', 'PostCommentController@add_comment_to_post')->name('add_comment_to_post');
