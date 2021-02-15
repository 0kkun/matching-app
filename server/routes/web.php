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

Route::get('/home', 'HomeController@index')->name('home.index');

Route::get('/home/{any?}', function() {
    return view('home.index');
})->where('any', '.*');

// *******************
// *** API用のルート ***
// *******************
Route::middleware('throttle:60,1', 'auth:web')->prefix('/api/v1')->group(function () {
    // プロフィール関連のAPI
    Route::prefix('/profile')->name('profile.')->group(function () {
        Route::get('/login_user', 'ProfileController@getLoginUserProfile')->name('get_login_user');
        Route::post('/update', 'ProfileController@updateProfile')->name('update');
        Route::post('/image_upload', 'ProfileController@imageUpload')->name('image_upload');
    });

    Route::get('/search/fetch_users_list', 'SearchController@fetchUsersList')->name('search.fetch_users_list');
}); 