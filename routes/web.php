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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('index');

Route::get('/setlocale/{locale}',  'LocaleController@set')->name('setlocale');

Route::get('/privacy_policy', function() {
    return Storage::download('public/Adatvédelmi tájékoztató.pdf');
})->name('privacy_policy');

Auth::routes();

Route::get('/register/guest', 'Auth\RegisterController@showTenantRegistrationForm')->name('register.guest');

Route::get('/verification', function () {
    return view('auth.verification');
})->name('verification');

Route::middleware(['auth', 'log', 'verified'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/print', 'PrintController@index')->name('print');
    Route::post('/print/modify_balance', 'PrintController@modify_balance')->name('print.modify')->middleware('can:print.modify');
    Route::post('/print/modify_free_pages', 'PrintController@modify_free_pages')->name('print.free_pages')->middleware('can:print.modify-free');
    Route::put('/print/print', 'PrintController@print')->name('print.print');

    Route::get('/internet', 'InternetController@index')->name('internet');
    Route::get('/internet/mac_addresses/users', 'InternetController@getUsersMacAddresses')->name('internet.mac_addresses.users');
    Route::post('/internet/mac_addresses/{id}/delete', 'InternetController@deleteMacAddress')->name('internet.mac_addresses.delete');
    Route::post('/internet/mac_addresses/add', 'InternetController@addMacAddress')->name('internet.mac_addresses.add');
    Route::post('/internet/wifi_password/reset', 'InternetController@resetWifiPassword')->name('internet.wifi_password.reset');

    Route::get('/internet/admin/mac_addresses/all', 'InternetController@getUsersMacAddressesAdmin')->name('internet.admin.mac_addresses.all');
    Route::get('/internet/admin/internet_accesses/all', 'InternetController@getInternetAccessesAdmin')->name('internet.admin.internet_accesses.all');
    Route::get('/internet/admin', 'InternetController@admin')->name('internet.admin');
    Route::post('/internet/mac_addresses/{id}/edit', 'InternetController@editMacAddress')->name('internet.mac_addresses.edit');
    Route::post('/internet/internet_accesses/{id}/edit', 'InternetController@editInternetAccess')->name('internet.internet_accesses.edit');

    Route::get('/admin/registrations', 'Admin\RegistrationsController@index')->name('admin.registrations');
    Route::post('/admin/registrations/accept', 'Admin\RegistrationsController@accept')->name('admin.registrations.accept');
    Route::post('/admin/registrations/reject', 'Admin\RegistrationsController@reject')->name('admin.registrations.reject');
    Route::post('/admin/registrations/show', 'Admin\RegistrationsController@show')->name('admin.registrations.show');

});
