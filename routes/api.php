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

});


Route::group(['prefix' => 'oijornais'], function () {
    
    Route::group(['prefix' => 'commands'], function() {
        Route::get('/customer/category-trends/import/{date?}', function(Request $request, $date = null){
            if (!$date) {
                $date = Carbon\Carbon::yesterday()->format('Y-m-d');
            }
            Artisan::call('oijornais:customer-category-trend', ['date' => $date]);
            return (Artisan::output());
        });

        Route::get('/trending-topics/import', function(Request $request, $date = null){
            Artisan::call('oijornais:trending-topics');
            return (Artisan::output());
        });
    });

    Route::prefix('v1')->middleware('jwtbob')->group(function() {
        Route::prefix('customer')->group(function () {
            Route::get('/category-trends/{msisdn}', 'CustomerCategoryTrendController@categoryTrends')
                ->where('msisdn', '[0-9]+');
        });

        Route::get('/trending-topics/{productId?}', 'TrendingTopicsController@index')
            ->where('productId', '[0-9]+');
    });

});