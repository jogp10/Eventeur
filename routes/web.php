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

use Illuminate\Support\Facades\Route;

Route::get('/', 'EventController@index')->name('home');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm');

Route::post('register', 'Auth\RegisterController@register')->name('register');
Route::get('/forgot-password', 'PasswordController@viewForgotForm')->middleware('guest')->name('password.request');
Route::post('/forgot-password', 'PasswordController@sendResetLinkEmail')->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}/{email}', 'PasswordController@viewResetForm')->middleware('guest')->name('password.reset');
Route::post('/reset-password', 'PasswordController@resetPassword')->middleware('guest')->name('password.update');

//User
Route::get('profile/{id}', 'ProfileController@show')->name('profile');
Route::get('profile/{id}/edit', 'ProfileController@showEditPage');
Route::get('profile/{id}/my_events', 'ProfileController@showOwnEvents')->name('MyEvents');
Route::put('profile/{id}/edit', 'ProfileController@update')->name('editProfile');
Route::put('profile/{id}/editImage', 'ProfileController@updateImage')->name('editProfileImage');
Route::put('profile/{id}/editPassword', 'ProfileController@updatePassword')->name('editProfilePassword');
Route::put('profile/{id}/editEmail', 'ProfileController@updateEmail')->name('editProfileEmail');
Route::get('profile/{id}/{invite_id}/accept_invitation', 'ProfileController@acceptInvitation')->name('AcceptInvitation');
Route::get('profile/{id}/{invite_id}/ignore_invitation', 'ProfileController@ignoreInvitation')->name('IgnoreInvitation');
Route::get('profile/{id}/delete', 'ProfileController@destroy')->name('Delete');

//Event
Route::get('event/{id}', 'EventController@show')->name('event.show');
Route::get('event/{id}/event_settings', 'EventController@edit')->name('eventSettings');
Route::get('event/{id}/event_participants', 'EventController@showParticipantsEvent')->name('eventParticipants');
Route::post('event/{id}/event_settings', 'EventController@update')->name('editEvent');
Route::delete('event/{id}/delete_event', 'EventController@destroy')->name('deleteEvent');
Route::get('create_event', 'EventController@create')->name('createEvent');
Route::post('create_event', 'EventController@store')->name('storeEvent');
Route::get('event/{id}/create_poll', 'PollController@createPoll')->name('createPoll');
Route::post('event/{id}/answer_poll','PollController@votePoll')->name('votePoll');

//Static Pages
Route::get('about', 'StaticPageController@about');
Route::get('contact', 'StaticPageController@contact');
Route::post('submitContact', 'StaticPageController@submitContact')->name('submitContact');
Route::get('faq', 'StaticPageController@faq');

//Admin
Route::get('admin', 'AdminController@index');
Route::get('admin/create', 'AdminController@createAccount');
Route::post('admin/create', 'AdminController@storeAccount')->name('admin.storeAccount');
Route::get('admin/users', 'ProfileController@index')->name('admin.users');
Route::get('admin/users/{id}', 'ProfileController@show')->name('admin.user');
Route::get('admin/users/{id}/edit', 'ProfileController@showEditPage')->name('admin.editUser');
Route::put('admin/users/{id}/edit', 'ProfileController@update')->name('admin.updateUser');
Route::delete('admin/users/{id}/delete', 'ProfileController@destroy')->name('admin.deleteUser');
Route::post('admin/users/{id}/ban', 'BanController@store')->name('admin.banUser');
Route::post('admin/users/{id}/unban', 'BanController@update')->name('admin.unbanUser');
Route::get('admin/createEvent', 'AdminController@createEvent');
Route::post('admin/createEvent', 'AdminController@storeEvent')->name('admin.storeEvent');
Route::delete('admin/event/{id}/delete', 'EventController@destroy')->name('admin.deleteEvent');
Route::get('/admin/event/{id}/event_settings', 'EventController@edit')->name('admin.eventSettings');
Route::get('/admin/events', 'EventController@manageEvents')->name('admin.events');

//Actions
Route::get('search', 'SearchController@searchEvent');
Route::get('api/searchuser', 'SearchController@showUser');
Route::get('api/searchevent', 'SearchController@showEvent');
Route::get('api/searchattendee', 'SearchController@showAttendee');
Route::post('vote', 'VoteController@create')->name('vote');

//API
Route::post('api/invite', 'InviteController@store')->name('invite');
Route::delete('api/invite/delete', 'InviteController@destroy')->name('deleteInvite');
Route::post('api/ticket', 'TicketController@store')->name('ticket');
Route::delete('api/ticket/delete', 'TicketController@destroy')->name('deleteTicket');
Route::post('api/comment', 'CommentController@store')->name('comment');
Route::delete('api/comment/delete', 'CommentController@destroy')->name('deleteComment');
Route::post('api/answer', 'CommentController@answer')->name('answer');
Route::delete('api/answer/delete', 'CommentController@answerDestroy')->name('deleteAnswer');
Route::post('api/request_join', 'RequestController@store');
Route::delete('api/delete_join/{request_id}', 'RequestController@destroy');
Route::post('api/accept_join/{request_id}', 'RequestController@update');
Route::put('api/markAsRead/{notification_id}', 'NotificationController@markAsRead')->name('markAsRead');
Route::get('api/searchwfilter', 'SearchController@searchWithFilter')->name('searchwfilter');

// OAuth
Route::get('auth/redirect', 'OAuthController@redirectToProvider')->name('oauth');
Route::get('auth/callback', 'OAuthController@handleProviderCallback');
