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
// Home
Route::get('/', 'HomepageController@home');

// Cards
//Route::get('cards', 'CardController@list');
//Route::get('cards/{id}', 'CardController@show');

// API
//Route::put('api/cards', 'CardController@create');
//Route::delete('api/cards/{card_id}', 'CardController@delete');
//Route::put('api/cards/{card_id}/', 'ItemController@create');
//Route::post('api/item/{id}', 'ItemController@update');
//Route::delete('api/item/{id}', 'ItemController@delete');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm');
Route::post('register', 'Auth\RegisterController@register')->name('register');


//User
Route::get('profile', 'ProfileController@show');
Route::get('editProfile', 'ProfileController@showEditPage');
Route::post('editProfile', 'ProfileController@edit')->name('editProfile');
Route::get('event/{id}', 'EventController@show');
Route::get('settigsProfile', 'ProfileController@showSettingsPage');

//Static Pages
Route::get('about', 'StaticPageController@about');
Route::get('contact', 'StaticPageController@contact');
Route::get('faq', 'StaticPageController@faq');