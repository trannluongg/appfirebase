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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::group(['prefix' => 'ajax', 'namespace' => 'App\Http\Controllers'], function ()
{
    Route::post('firebase/device-token/create-or-update', 'FirebaseController@createOrUpdate')
        ->name('ajax_post.firebase.device_token.create_or_update');
});