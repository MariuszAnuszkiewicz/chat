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
    return redirect('/application/login');
});

Route::get('/application', function () {
    if (Auth::check()) {
        return redirect('/application/profile/' . Auth::user()->id);
    } else {
        return redirect('/application/login');
    }
});

Route::group(['prefix' => 'application'], function() {
  Auth::routes();
  Route::match(['get', 'post'], '/profile/{id}', 'UserProfileController@index')->where('id', '[0-9]+')->name('user_profile');
  Route::match(['get', 'post'], '/chat', 'ChatController@index')->name('chat');
  Route::match(['get', 'post'], '/profile/{id}/edit', 'UserProfileController@edit')->where('id', '[0-9]+')->name('edit_profile');
  Route::delete('/chat/clear', 'ChatController@clear')->name('clear');
  Route::post('/logout', 'UserProfileController@logout')->name('logout');
});