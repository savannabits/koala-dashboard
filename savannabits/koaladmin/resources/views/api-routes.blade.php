/* Auto-generated {{$modelRouteName}} api routes */
Route::group(['prefix' => config('koaladmin.prefix',''),'as' => 'api.', 'namespace' => "Api"], function() {
    Route::group(['middleware' => ["auth:sanctum","verified"]], function() {
        Route::group(['prefix' => "{{$modelRouteName}}", 'as' => '{{$modelRouteName}}.'],function() {
            Route::get("dt", "{{$controllerClassName}}@dt")->name('dt');
        });
        Route::apiResource('{{$modelRouteName}}',"{{$controllerClassName}}")->parameters(["{{$modelRouteName}}" => "{{$modelVariableName}}"]);
    });
});
