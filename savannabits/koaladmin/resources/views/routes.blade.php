
/* Auto-generated admin routes */

Route::group(["prefix" => config('koaladmin.prefix',''),
    "namespace" => "Admin",
    "as" => config('koaladmin.prefix').".",'middleware' => ['auth','verified']],function() {
    Route::group(['as' => "{{$modelRouteName}}.", 'prefix' => "{{$modelRouteName}}"], function() {
        {!! str_pad("Route::get('',", 10) !!}[{{ $controllerFullName }}::class, 'index'])->name('index');
    });
});
