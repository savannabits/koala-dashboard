<?php
use Illuminate\Support\Facades\Route;
$adminPrefix = config('koaladmin.prefix','');
/**
 * ADMIN/BACKEND ROUTES
 */
Route::group(['namespace' => 'Admin','prefix' => $adminPrefix,'as' =>'admin.','middleware' => ['auth:web']], function () {
    Route::get('dashboard', function(Request $request) {
        return view('koaladmin.dashboard');
    })->name('dashboard');
});


/* Auto-generated admin routes */

Route::group(["prefix" => config('koaladmin.prefix',''),
    "namespace" => "Admin",
    "as" => config('koaladmin.prefix').".",'middleware' => ['auth','verified']],function() {
    Route::group(['as' => "authors.", 'prefix' => "authors"], function() {
        Route::get('',[App\Http\Controllers\Admin\AuthorController::class, 'index'])->name('index');
    });
});


/* Auto-generated admin routes */

Route::group(["prefix" => config('koaladmin.prefix',''),
    "namespace" => "Admin",
    "as" => config('koaladmin.prefix').".",'middleware' => ['auth','verified']],function() {
    Route::group(['as' => "articles.", 'prefix' => "articles"], function() {
        Route::get('',[App\Http\Controllers\Admin\ArticleController::class, 'index'])->name('index');
    });
});


/* Auto-generated admin routes */

Route::group(["prefix" => config('koaladmin.prefix',''),
    "namespace" => "Admin",
    "as" => config('koaladmin.prefix').".",'middleware' => ['auth','verified']],function() {
    Route::group(['as' => "roles.", 'prefix' => "roles"], function() {
        Route::get('',[App\Http\Controllers\Admin\RoleController::class, 'index'])->name('index');
    });
});
