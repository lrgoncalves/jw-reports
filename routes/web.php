<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('congregation')->group(function() {
    Route::get('/list', 'CongregationController@index')->name('congregation');
    Route::get('/new', 'CongregationController@edit')->name('congregation.new');
    Route::get('/edit/{id}', 'CongregationController@edit')->name('congregation.edit');
    Route::post('/new', 'CongregationController@new');
    Route::post('/edit', 'CongregationController@update');
    Route::get('ajaxData', 'CongregationController@ajaxData')->name('congregation.ajaxData');
});

Route::prefix('publisher')->group(function() {
    Route::get('/list', 'PublisherController@index')->name('publisher');
    Route::get('/new', 'PublisherController@edit')->name('publisher.new');
    Route::get('/edit/{id}', 'PublisherController@edit')->name('publisher.edit');
    Route::post('/new', 'PublisherController@new');
    Route::post('/edit', 'PublisherController@update');
    Route::get('ajaxData', 'PublisherController@ajaxData')->name('publisher.ajaxData');
    Route::get('/delete/{id}', 'PublisherController@delete')->name('publisher.delete');
});

Route::prefix('field_service')->group(function() {
    Route::get('/list', 'FieldServiceController@index')->name('field_service');
    Route::get('/new', 'FieldServiceController@edit')->name('field_service.new');
    Route::get('/edit/{id}', 'FieldServiceController@edit')->name('field_service.edit');
    Route::post('/new', 'FieldServiceController@new');
    Route::post('/edit', 'FieldServiceController@update');
    Route::get('ajaxData', 'FieldServiceController@ajaxData')->name('field_service.ajaxData');
    Route::get('/delete/{id}', 'FieldServiceController@delete')->name('field_service.delete');
});