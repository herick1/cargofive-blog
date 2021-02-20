<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'PostController@index');
Route::get('/home', ['as' => 'home', 'uses' => 'PostController@index']);

//authentication
// Route::resource('auth', 'Auth\AuthController');
// Route::resource('password', 'Auth\PasswordController');
Route::get('/logout', 'UserController@logout');
Route::group(['prefix' => 'auth'], function () {
  Auth::routes();
});


Route::get('/forget-password', 'Auth\ForgotPasswordController@getEmail')->name('forget-password');
Route::post('/forget-password', 'Auth\ForgotPasswordController@postEmail')->name('forget-password');

Route::get('/reset-password/{token}', 'Auth\ResetPasswordController@getPassword');
Route::post('/reset-password', 'Auth\ResetPasswordController@updatePassword');

// check for logged in user
Route::middleware(['auth'])->group(function () {

  //users profile
  Route::get('admin', 'UserController@profile')->where('id', '[0-9]+');

  // show new post form
  Route::get('new-post', 'PostController@create');
  // save new post
  Route::post('new-post', 'PostController@store');
  // edit post form
  Route::get('edit/{slug}', 'PostController@edit');
  // update post
  Route::post('update', 'PostController@update');
  // delete post
  Route::get('delete/{id}', 'PostController@destroy');
  // display user's all posts
  Route::get('my-all-posts', 'UserController@user_posts_all');
  // display user's drafts
  Route::get('my-drafts', 'UserController@user_posts_draft');
  // add comment
  Route::post('comment/add', 'CommentController@store');
  // delete comment
  Route::post('comment/delete/{id}', 'CommentController@distroy');
});


//users profile
Route::get('user/{id}', 'UserController@profileWithoutLogin')->where('id', '[0-9]+');

// display list of posts
Route::get('user/{id}/posts', 'UserController@user_posts')->where('id', '[0-9]+');
// display single post
Route::get('/{slug}', ['as' => 'post', 'uses' => 'PostController@show'])->where('slug', '[A-Za-z0-9-_]+');