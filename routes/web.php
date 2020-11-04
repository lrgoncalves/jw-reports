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

Route::prefix('year_service')->group(function() {
    Route::get('/list', 'YearServiceController@index')->name('year_service');
    Route::get('/new', 'YearServiceController@edit')->name('year_service.new');
    Route::get('/edit/{id}', 'YearServiceController@edit')->name('year_service.edit');
    Route::post('/new', 'YearServiceController@new');
    Route::post('/edit', 'YearServiceController@update');
    Route::get('ajaxData', 'YearServiceController@ajaxData')->name('year_service.ajaxData');
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

Route::prefix('publisher_address')->group(function() {
    Route::get('/new', 'PublisherAddressController@edit')->name('publisher_address.new');
    Route::get('/edit/{id}', 'PublisherAddressController@edit')->name('publisher_address.edit');

    Route::post('/new', 'PublisherAddressController@new');
    Route::post('/edit', 'PublisherAddressController@update');

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


Route::prefix('regular_pioneer')->group(function() {
    Route::get('/list', 'RegularPioneerController@index')->name('regular_pioneer');
    Route::get('ajaxData', 'RegularPioneerController@ajaxData')->name('regular_pioneer.ajaxData');
});

Route::prefix('auxiliar_pioneer')->group(function() {
    Route::get('/list', 'AuxiliarPioneerController@index')->name('auxiliar_pioneer');
    Route::get('ajaxData', 'AuxiliarPioneerController@ajaxData')->name('auxiliar_pioneer.ajaxData');
});

Route::prefix('auxiliar_pioneer_30')->group(function() {
    Route::get('/list', 'AuxiliarPioneer30Controller@index')->name('auxiliar_pioneer_30');
    Route::get('ajaxData', 'AuxiliarPioneer30Controller@ajaxData')->name('auxiliar_pioneer_30.ajaxData');
});

Route::prefix('pioneer')->group(function() {
    Route::get('/list', 'PioneerController@index')->name('pioneer');
    Route::get('/new', 'PioneerController@edit')->name('pioneer.new');
    Route::get('/edit/{id}', 'PioneerController@edit')->name('pioneer.edit');
    Route::post('/new', 'PioneerController@new');
    Route::post('/edit', 'PioneerController@update');
    Route::get('ajaxData', 'PioneerController@ajaxData')->name('pioneer.ajaxData');
    Route::get('/delete/{id}', 'PioneerController@delete')->name('pioneer.delete');

    Route::get('report/auxiliar', 'PioneerController@reportMonth')->name('pioneer.auxilizar.reportMonth');
    Route::get('report/auxiliar/print', 'PioneerController@reportMonthPrint')->name('pioneer.auxilizar.reportMonthPrint');

});

Route::prefix('meeting')->group(function() {
    Route::get('/list', 'MeetingController@index')->name('meeting');
    Route::get('/new', 'MeetingController@edit')->name('meeting.new');
    Route::get('/edit/{id}', 'MeetingController@edit')->name('meeting.edit');
    Route::post('/new', 'MeetingController@new');
    Route::post('/edit', 'MeetingController@update');
    Route::get('ajaxData', 'MeetingController@ajaxData')->name('meeting.ajaxData');
    Route::get('/delete/{id}', 'MeetingController@delete')->name('meeting.delete');

});

Route::prefix('group')->group(function() {
    Route::get('/list', 'GroupController@index')->name('group');
    Route::get('/new', 'GroupController@edit')->name('group.new');
    Route::get('/edit/{id}', 'GroupController@edit')->name('group.edit');
    Route::post('/new', 'GroupController@new');
    Route::post('/edit', 'GroupController@update');
    Route::get('ajaxData', 'GroupController@ajaxData')->name('group.ajaxData');
    Route::get('/delete/{id}', 'GroupController@delete')->name('group.delete');
});

Route::prefix('non_reported')->group(function() {
    Route::get('/index', 'NonReportedController@index')->name('non_reported');
    Route::post('/generate', 'NonReportedController@generate')->name('non_reported.generate');
    Route::post('/close-month', 'NonReportedController@closeMonth')->name('non_reported.closeMonth');
    // non_reported/close-month
});

Route::prefix('publisher_unhealthy')->group(function() {
    Route::get('/list', 'PublisherUnhealthyController@index')->name('publisher_unhealthy');
    Route::get('/new', 'PublisherUnhealthyController@edit')->name('publisher_unhealthy.new');
    Route::get('/edit/{id}', 'PublisherUnhealthyController@edit')->name('publisher_unhealthy.edit');
    Route::post('/new', 'PublisherUnhealthyController@new');
    Route::post('/edit', 'PublisherUnhealthyController@update');
    Route::get('ajaxData', 'PublisherUnhealthyController@ajaxData')->name('publisher_unhealthy.ajaxData');
    Route::get('/delete/{id}', 'PublisherUnhealthyController@delete')->name('publisher_unhealthy.delete');
});

Route::prefix('publisher_field_service_report')->group(function() {
    Route::get('/list', 'PublisherFieldServiceReportController@index')->name('publisher_field_service_report');
    Route::get('ajaxData', 'PublisherFieldServiceReportController@ajaxData')->name('publisher_field_service_report.ajaxData');
    Route::get('/generate/{yearServiceId}', 'PublisherFieldServiceReportController@generate')->name('publisher_field_service_report.generate');
    Route::get('/report/{publisherId?}', 'PublisherFieldServiceReportController@report')->name('publisher_field_service_report.report');
});

Route::prefix('meeting_report')->group(function() {
    Route::get('/list', 'MeetingReportController@index')->name('meeting_report');
    Route::get('ajaxData', 'MeetingReportController@ajaxData')->name('meeting_report.ajaxData');
    Route::get('/report/{yearServiceId}', 'MeetingReportController@report')->name('meeting_report.report');
});

Route::prefix('publisher_address_report')->group(function() {
    Route::get('/list', 'PublisherAddressReportController@index')->name('publisher_address_report');
    Route::get('ajaxData', 'PublisherAddressReportController@ajaxData')->name('publisher_address_report.ajaxData');
    Route::get('/report', 'PublisherAddressReportController@report')->name('publisher_address_report.report');
});

Route::prefix('congregation_activity_report')->group(function() {
    Route::get('/list', 'CongregationActivityReportController@index')->name('congregation_activity_report');
    Route::get('ajaxData', 'CongregationActivityReportController@ajaxData')->name('congregation_activity_report.ajaxData');
    Route::get('/report/{yearServiceId}', 'CongregationActivityReportController@report')->name('congregation_activity_report.report');
});