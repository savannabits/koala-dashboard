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

Auth::routes();

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware('auth')->get('/alerts', function (Request $request) {
    return view('alerts');
})->name('alerts');
Route::middleware('auth')->get('/buttons', function (Request $request) {
    return view('buttons');
})->name('buttons');
