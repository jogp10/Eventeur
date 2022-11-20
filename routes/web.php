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
Route::get('/', 'EventController@index')->name('home');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm');
Route::post('register', 'Auth\RegisterController@register')->name('register');


//User
#Route::get('profile','ProfileController@show');
#Route::get('editProfile', 'ProfileController@showEditPage');
#Route::post('editProfile', 'ProfileController@edit')->name('editProfile');
#Route::get('settigsProfile', 'ProfileController@showSettingsPage');

//User
Route::get('profile/{id}', 'ProfileController@show')->name('profile');
Route::get('profile/{id}/settings', 'ProfileController@showEditPage');
Route::put('profile/{id}/edit', 'ProfileController@update')->name('editProfile');
Route::get('profile/{id}/security', 'ProfileController@showSettingsPage');
Route::get('profile/{id}/{invite_id}/accept_invitation', 'ProfileController@acceptInvitation')->name('AcceptInvitation');
Route::get('profile/{id}/{invite_id}/ignore_invitation', 'ProfileController@ignoreInvitation')->name('IgnoreInvitation');

//Event
Route::get('event/{id}', 'EventController@show');
Route::get('event/{id}/event_settings', 'EventController@showEditEvent')->name('eventSettings');
Route::post('event/{id}/event_settings', 'EventController@edit')->name('editEvent');
Route::get('event/{id}/delete_event', 'EventController@destroy')->name('deleteEvent');

//Static Pages
Route::get('about', 'StaticPageController@about');
Route::get('contact', 'StaticPageController@contact');
Route::post('submitContact', 'StaticPageController@submitContact');
Route::get('faq', 'StaticPageController@faq');

// Actions
Route::get('search', 'SearchController@searchEvent');
Route::get('api/searchuser', 'SearchController@showUser');
Route::get('vote', 'VoteController@vote');
Route::post('api/invite', 'InviteController@invite');

Route::post('api/invite/accept', 'InviteController@accept');
Route::post('api/invite/ignore', 'InviteController@ignore');

// Admin
Route::get('admin', 'AdminController@index');
Route::get('admin/create', 'AdminController@createAccount');
Route::post('admin/create', 'AdminController@storeAccount')->name('admin.storeAccount');
Route::get('admin/users', 'ProfileController@index')->name('admin.users');
Route::get('admin/users/{id}', 'ProfileController@show')->name('admin.user');
Route::get('admin/users/{id}/edit', 'ProfileController@showEditPage')->name('admin.editUser');
Route::put('admin/users/{id}/edit', 'ProfileController@update')->name('admin.updateUser');
Route::get('admin/users/{id}/delete', 'ProfileController@destroy')->name('admin.deleteUser');
