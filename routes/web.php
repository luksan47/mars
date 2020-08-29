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
    if (Auth::user()) {
        return redirect('home');
    }

    return view('welcome');
})->name('index');

Route::get('/setlocale/{locale}', 'LocaleController@set')->name('setlocale');

Route::get('/privacy_policy', function () {
    return Storage::response('public/adatvedelmi_tajekoztato.pdf');
})->name('privacy_policy');

Route::get('/img/{filename}', 'EmailController@getPicture');

Auth::routes();

Route::get('/register/guest', 'Auth\RegisterController@showTenantRegistrationForm')->name('register.guest');

Route::get('/verification', function () {
    return view('auth.verification');
})->name('verification');

Route::middleware(['auth', 'log'])->group(function () {
    Route::get('/test_mails/{mail}/{send?}', 'EmailController@testEmail');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/userdata/update_password', 'UserController@updatePassword')->name('userdata.update_password');
});

Route::middleware(['auth', 'log', 'verified'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('userdata', 'UserController@showData')->name('userdata');
    Route::get('/user', 'UserController@index')->name('user');
    Route::get('/userdata', 'UserController@showData')->name('userdata');
    Route::post('/userdata/update_email', 'UserController@updateEmail')->name('userdata.update_email');
    Route::post('/userdata/update_phone', 'UserController@updatePhone')->name('userdata.update_phone');

    Route::get('localizations', 'LocaleController@index')->name('localizations');
    Route::get('localizations/admin', 'LocaleController@indexAdmin')->name('localizations.admin')->middleware('can:approve,App\LocalizationContribution');
    Route::post('localizations/add', 'LocaleController@add')->name('localizations.add');
    Route::post('localizations/approve', 'LocaleController@approve')->name('localizations.approve')->middleware('can:approve,App\LocalizationContribution');
    Route::post('localizations/approve_all', 'LocaleController@approveAll')->name('localizations.approve_all')->middleware('can:approve,App\LocalizationContribution');
    Route::post('localizations/delete', 'LocaleController@delete')->name('localizations.delete')->middleware('can:approve,App\LocalizationContribution');

    Route::get('/print', 'PrintController@index')->name('print');
    Route::post('/print/modify_balance', 'PrintController@modifyBalance')->name('print.modify')->middleware('can:print.modify');
    Route::post('/print/add_free_pages', 'PrintController@addFreePages')->name('print.free_pages')->middleware('can:print.modify-free');
    Route::post('/print/transfer_balance', 'PrintController@transferBalance')->name('print.transfer-balance');
    Route::put('/print/print', 'PrintController@print')->name('print.print');
    Route::get('/print/free_pages/all', 'PrintController@listFreePages')->name('print.free_pages.all');
    Route::get('/print/print_jobs/all', 'PrintController@listPrintJobs')->name('print.print_jobs.all');
    Route::get('/print/account_history', 'PrintController@listPrintAccountHistory')->name('print.account_history')->middleware('can:print.modify');
    Route::post('/print/print_jobs/{id}/cancel', 'PrintController@cancelPrintJob')->name('print.print_jobs.cancel');
    Route::get('/print/admin', 'PrintController@admin')->name('print.admin');

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
    Route::get('/admin/registrations/show/{id}', 'Admin\RegistrationsController@show')->name('admin.registrations.show');

    Route::get('/admin/permissions', 'Admin\PermissionController@index')->name('admin.permissions.list');
    Route::get('/admin/permissions/{id}/show', 'Admin\PermissionController@show')->name('admin.permissions.show');
    Route::post('/admin/permissions/{id}/edit/{role_id}', 'Admin\PermissionController@edit')->name('admin.permissions.edit');
    Route::post('/admin/permissions/{id}/remove/{role_id}/{object_id?}', 'Admin\PermissionController@remove')->name('admin.permissions.remove');

    Route::get('/faults', 'FaultsController@index')->name('faults');
    Route::get('/faults/table', 'FaultsController@GetFaultsTable')->name('faults.table');
    Route::post('/faults/add', 'FaultsController@addFault')->name('faults.add');
    Route::post('/faults/update', 'FaultsController@updateStatus')->name('faults.update');

    Route::get('/secretariat/users', 'SecretariatController@list')->name('secretariat.users');

    Route::get('/locale', 'LocaleController@list')->name('locales');

    Route::get('/documents', 'LatexController@index')->name('documents');
    Route::get('/documents/license/download', 'LatexController@downloadLicense')->name('documents.license.download');
    Route::get('/documents/license/print', 'LatexController@printLicense')->name('documents.license.print');
});
