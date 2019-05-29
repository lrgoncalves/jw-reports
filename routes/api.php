<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => 'timbancavirtual'], function () {

    Route::group(['prefix' => 'commands'], function() {
        Route::get('/magazine-feature', function(Request $request, $date = null){
            Artisan::call('timbanca:magazine-features');
            return '';
        });
    });
});


Route::group(['prefix' => 'oijornais'], function () {
    
    Route::group(['prefix' => 'commands'], function() {

        Route::get('/trending-topics/import', function(Request $request, $date = null){
            Artisan::call('oijornais:trending-topics');
            return (Artisan::output());
        });
    });

    Route::prefix('v1')->middleware('jwtbob')->group(function() {
        Route::get('/trending-topics/{productId?}', 'TrendingTopicsController@index')
            ->where('productId', '[0-9]+');
    });

});

Route::prefix('v1')->middleware('jwtbob')->group(function () {
    Route::get('/magazines/featured', 'MagazineController@getFeatured');
});