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
Route::group(['prefix' => config('koaladmin.prefix',''),'as' => 'api.', 'namespace' => "Api"], function() {
    Route::group(['middleware' => ["auth:sanctum","verified"]], function() {
        Route::group(['prefix' => "authors", 'as' => 'authors.'],function() {
            Route::get("dt", "AuthorController@dt")->name('dt');
        });
        Route::apiResource('authors',"AuthorController")->parameters(["authors" => "author"]);
    });
});


/* Auto-generated articles api routes */
Route::group(['prefix' => config('koaladmin.prefix',''),'as' => 'api.', 'namespace' => "Api"], function() {
    Route::group(['middleware' => ["auth:sanctum","verified"]], function() {
        Route::group(['prefix' => "articles", 'as' => 'articles.'],function() {
            Route::get("dt", "ArticleController@dt")->name('dt');
        });
        Route::apiResource('articles',"ArticleController")->parameters(["articles" => "article"]);
    });
});
