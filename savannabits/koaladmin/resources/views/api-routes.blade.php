/* Auto-generated {{$modelRouteName}} api routes */
Route::group(['as' => 'api.'], function() {
    Route::group(['middleware' => ["auth:sanctum"]], function() {
        Route::group(['prefix' => "{{$modelRouteName}}", 'as' => '{{$modelRouteName}}.'],function() {
            Route::get("dt", [{{$controllerFullName}}::class,'dt'])->name('dt');
        });
        Route::apiResource('{{$modelRouteName}}',{{ $controllerFullName }}::class)->parameters(["{{$modelRouteName}}" => "{{$modelVariableName}}"]);
    });
});
