<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::prefix('/users')->namespace('\App\Http\Controllers')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/', 'UserController@index')->name('users.index');
    Route::get('/show', 'UserController@show')->name('users.show');
    Route::delete('/', 'UserController@destroy')->name('users.destroy');
});

Route::prefix('/token')->namespace('\App\Http\Controllers\Auth')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/', 'SanctumApiController@index')->name('token.index');
        Route::delete('/revoke/{tokenId}', 'SanctumApiController@revoke')->name('token.revoke');
        Route::delete('/revoke-all/', 'SanctumApiController@revokeAll')->name('token.revoke-all');
    });
    Route::post('/create', 'SanctumApiController@create')->name('token.create');
});
