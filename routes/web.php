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
})->name('index');

Route::get('/setlocale/{locale}',  'LocaleController@set')->name('setlocale');

Auth::routes();
Route::get('/verification', function () {
    return view('auth.verification');
})->name('verification');

Route::middleware(['auth', 'log', 'verified'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/print', 'PrintController@index')->name('print')->middleware('can:print.print');
    Route::post('/print/modify_balance', 'PrintController@modify_balance')->name('print.modify')->middleware('can:print.modify');;
    Route::post('/print/modify_free_pages', 'PrintController@modify_free_pages')->name('print.free_pages')->middleware('can:print.modify');
    Route::put('/print/print', 'PrintController@print')->name('print.print')->middleware('can:print.print');;

    Route::get('/admin/registrations', 'Admin\RegistrationsController@index')->name('admin.registrations');
    Route::post('/admin/registrations/accept', 'Admin\RegistrationsController@accept')->name('admin.registrations.accept');
    Route::post('/admin/registrations/reject', 'Admin\RegistrationsController@reject')->name('admin.registrations.reject');
    Route::post('/admin/registrations/show', 'Admin\RegistrationsController@show')->name('admin.registrations.show');

});
