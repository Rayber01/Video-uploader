<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\Auth\LoginController;

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

Route::get('sanctum/csrf-cookie', [Laravel\Sanctum\Http\Controllers\CsrfCookieController::class, 'show']);
Route::get('/user', [App\Http\Controllers\UserController::class, 'index']);
Route::get('/video/{perPage?}', [App\Http\Controllers\UploadController::class, 'getFiles']);
Route::post('/video', [App\Http\Controllers\UploadController::class, 'saveVideo']);
Route::post('/video/delete', [App\Http\Controllers\UploadController::class, 'deleteVideo']);
Route::post('/getLink', [App\Http\Controllers\UploaderController::class, 'getLink']);

Route::get('/clear-cache', function () {
	Artisan::call('cache:clear');
	Artisan::call('route:clear');
	Artisan::call('view:clear');
	Artisan::call('config:clear');
	return "Site cache cleared!";
});

Route::get('/{any}', [App\Http\Controllers\PageController::class, 'index'])->where('any','.*')->name('app');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);