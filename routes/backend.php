<?php
use Illuminate\Support\Facades\Route;

/**
 * BACKEND ROUTES
 */
/*{{ROUTES}}*/
Route::group(['namespace' => 'Admin','as' =>'admin.','middleware' => ['auth:web']], function () {
    Route::get('dashboard', function(Request $request) {
        return view('admin.dashboard');
    })->name('dashboard');
});
