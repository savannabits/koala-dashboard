<?php
use Illuminate\Support\Facades\Route;
$adminPrefix = config('koaladmin.prefix','');
/**
 * ADMIN/BACKEND ROUTES
 */
Route::group(['namespace' => 'Admin','prefix' => $adminPrefix,'as' =>'admin.','middleware' => ['auth:web']], function () {
    Route::get('dashboard', function(Request $request) {
        return view('admin.dashboard');
    })->name('dashboard');
});
