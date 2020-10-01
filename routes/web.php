<?php

use App\Http\Controllers\PasswordController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// Auth::routes();

// Route::get('/register', );

Route::get('/home', 'HomeController@index')->name('home');

// Route::group(['middleware' => 'auth'], function () {

//     Route::get('profile', 'ProfileController@edit')->name('profile.edit');

//     Route::patch('profile', 'ProfileController@update')->name('profile.update');

//     Route::get('password', 'PasswordController@edit')->name('user.password.edit');

//     Route::patch('password', 'PasswordController@update')->name('user.password.update');
// });

Route::get('/register', 'FirebaseController@index')->name('register');
Route::get('/login', 'LoginController@index')->name('login');
Route::get('/forgot', 'ForgotPasswordController@index')->name('user.forgot');
Route::post('/forgot', 'ForgotPasswordController@reset')->name('user.reset');

Route::post('/user', 'LoginController@user')->name('user.login');
Route::post('/create','FirebaseController@create')->name('user.create');

Route::group(['middleware' => 'firebase'], function () {
    Route::get('/profile','ProfileController@index')->name('profile');
    Route::post('/profile/user/update','FirebaseController@update')->name('user.update');
    Route::post('/profile/user/delete','FirebaseController@delete')->name('user.delete');

    Route::post('/profile/password/update', 'PasswordController@update')->name('password.update');
    Route::get('/logout', 'LoginController@logout')->name('logout');
    Route::post('/logout', 'LoginController@logout');

    //Arduino
    Route::get('arduino/{id}', 'ArduinoController@read')->name('arduino.read');
    Route::post('arduino/update/{id}', 'ArduinoController@update')->name('arduino.update');
    Route::get('arduino', 'ArduinoController@index')->name('arduino');
});

