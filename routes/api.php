<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CodeCheckController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('password/email',  'ForgotPasswordController@__invoke')->name('password.email2');
Route::post('password/code/check', 'CodeCheckController@__invoke')->name('password.code.check');
Route::post('password/reset', 'ResetPasswordController@__invoke')->name('password.reset2');
Route::middleware('auth:api')->get('/user', 'Auth\LoginController@getUser');
