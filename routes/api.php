<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


/* Auto-generated authors api routes */
Route::group(['as' => 'api.'], function() {
    Route::group(['middleware' => ["auth:sanctum"]], function() {
        Route::group(['prefix' => "authors", 'as' => 'authors.'],function() {
            Route::get("dt", [App\Http\Controllers\Api\AuthorController::class,'dt'])->name('dt');
        });
        Route::apiResource('authors',App\Http\Controllers\Api\AuthorController::class)->parameters(["authors" => "author"]);
    });
});


/* Auto-generated roles api routes */
Route::group(['as' => 'api.'], function() {
    Route::group(['middleware' => ["auth:sanctum"]], function() {
        Route::group(['prefix' => "roles", 'as' => 'roles.'],function() {
            Route::get("dt", [App\Http\Controllers\Api\RoleController::class,'dt'])->name('dt');
        });
        Route::apiResource('roles',App\Http\Controllers\Api\RoleController::class)->parameters(["roles" => "role"]);
    });
});
