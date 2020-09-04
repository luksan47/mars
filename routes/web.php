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

    /** User data */
    Route::get('/user', 'UserController@index')->name('user');
    Route::post('/userdata/update_email', 'UserController@updateEmail')->name('userdata.update_email');
    Route::post('/userdata/update_phone', 'UserController@updatePhone')->name('userdata.update_phone');
    Route::get('/admin/user/list', 'UserController@list')->name('admin.user.list');
    Route::get('/admin/user/show/{id}', 'UserController@show')->name('admin.user.show');

    /** Localization */
    Route::get('/localizations', 'LocaleController@index')->name('localizations');
    Route::post('/localizations/add', 'LocaleController@add')->name('localizations.add');
    Route::middleware(['can:approve,App\LocalizationContribution'])->group(function () {
        Route::get('/localizations/admin', 'LocaleController@indexAdmin')->name('localizations.admin');
        Route::post('/localizations/approve', 'LocaleController@approve')->name('localizations.approve');
        Route::post('/localizations/approve_all', 'LocaleController@approveAll')->name('localizations.approve_all');
        Route::post('/localizations/delete', 'LocaleController@delete')->name('localizations.delete');
    });

    /** Printing */
    Route::get('/print', 'PrintController@index')->name('print');
    Route::get('/print/free_pages/all', 'PrintController@listFreePages')->name('print.free_pages.all');
    Route::get('/print/print_jobs/all', 'PrintController@listPrintJobs')->name('print.print_jobs.all');
    Route::post('/print/transfer_balance', 'PrintController@transferBalance')->name('print.transfer-balance');
    Route::post('/print/print_jobs/{id}/cancel', 'PrintController@cancelPrintJob')->name('print.print_jobs.cancel');
    Route::put('/print/print', 'PrintController@print')->name('print.print');
    Route::middleware(['can:print.modify'])->group(function () {
        Route::get('/print/account_history', 'PrintController@listPrintAccountHistory')->name('print.account_history');
        Route::get('/print/admin', 'PrintController@admin')->name('print.admin');
        Route::post('/print/modify_balance', 'PrintController@modifyBalance')->name('print.modify');
    });
    Route::post('/print/add_free_pages', 'PrintController@addFreePages')->name('print.free_pages')->middleware('can:print.modify-free');

    /** Internet */
    Route::get('/internet', 'InternetController@index')->name('internet');
    Route::get('/internet/mac_addresses/users', 'InternetController@getUsersMacAddresses')->name('internet.mac_addresses.users');
    Route::get('/internet/admin/mac_addresses/all', 'InternetController@getUsersMacAddressesAdmin')->name('internet.admin.mac_addresses.all');
    Route::get('/internet/admin/internet_accesses/all', 'InternetController@getInternetAccessesAdmin')->name('internet.admin.internet_accesses.all');
    Route::get('/internet/admin', 'InternetController@admin')->name('internet.admin');
    Route::post('/internet/mac_addresses/add', 'InternetController@addMacAddress')->name('internet.mac_addresses.add');
    Route::post('/internet/mac_addresses/{id}/edit', 'InternetController@editMacAddress')->name('internet.mac_addresses.edit');
    Route::post('/internet/mac_addresses/{id}/delete', 'InternetController@deleteMacAddress')->name('internet.mac_addresses.delete');
    Route::post('/internet/wifi_password/reset', 'InternetController@resetWifiPassword')->name('internet.wifi_password.reset');
    Route::post('/internet/internet_accesses/{id}/edit', 'InternetController@editInternetAccess')->name('internet.internet_accesses.edit');

    /** Registration handling */
    Route::middleware(['can:registration.handle'])->group(function () {
        Route::get('/admin/registrations', 'Admin\RegistrationsController@index')->name('admin.registrations');
        Route::get('/admin/registrations/show/{id}', 'Admin\RegistrationsController@show')->name('admin.registrations.show');
        Route::get('/admin/registrations/accept/{id}', 'Admin\RegistrationsController@accept')->name('admin.registrations.accept');
        Route::get('/admin/registrations/reject/{id}', 'Admin\RegistrationsController@reject')->name('admin.registrations.reject');
    });

    /** Permission handling */
    Route::middleware(['can:permission.handle'])->group(function () {
        Route::get('/admin/permissions', 'Admin\PermissionController@index')->name('admin.permissions.list');
        Route::get('/admin/permissions/{id}/show', 'Admin\PermissionController@show')->name('admin.permissions.show');
        Route::post('/admin/permissions/{id}/edit/{role_id}', 'Admin\PermissionController@edit')->name('admin.permissions.edit');
        Route::post('/admin/permissions/{id}/remove/{role_id}/{object_id?}', 'Admin\PermissionController@remove')->name('admin.permissions.remove');
    });

    /** Faults */
    Route::get('/faults', 'FaultsController@index')->name('faults');
    Route::get('/faults/table', 'FaultsController@GetFaultsTable')->name('faults.table');
    Route::post('/faults/add', 'FaultsController@addFault')->name('faults.add');
    Route::post('/faults/update', 'FaultsController@updateStatus')->name('faults.update');

    /** WIP: Secretariat */
    Route::get('/secretariat/users', 'SecretariatController@list')->name('secretariat.users');

    /** Documents */
    Route::get('/documents', 'DocumentController@index')->name('documents');
    Route::get('/documents/license/download', 'DocumentController@downloadLicense')->name('documents.license.download');
    Route::get('/documents/license/print', 'DocumentController@printLicense')->name('documents.license.print');
    Route::get('/documents/import/show', 'DocumentController@showImport')->name('documents.import.show');
    Route::post('/documents/import/add', 'DocumentController@addImport')->name('documents.import.add');
    Route::post('/documents/import/remove', 'DocumentController@removeImport')->name('documents.import.remove');
    Route::get('/documents/import/download', 'DocumentController@downloadImport')->name('documents.import.download');
    Route::get('/documents/import/print', 'DocumentController@printImport')->name('documents.import.print');
    Route::get('/documents/status-cert/download', 'DocumentController@downloadStatusCertificate')->name('documents.status-cert.download');
    Route::get('/documents/status-cert/request', 'DocumentController@requestStatusCertificate')->name('documents.status-cert.request');
    Route::get('/documents/status-cert/{id}/show', 'DocumentController@showStatusCertificate')->name('documents.status-cert.show');
});
