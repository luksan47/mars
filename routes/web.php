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

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RegistrationsController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\FaultsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InternetController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\RouterController;
use App\Http\Controllers\SecretariatController;
use App\Http\Controllers\StudentCouncil\EconomicController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    if (Auth::user()) {
        return redirect('home');
    }

    return view('welcome');
})->name('index');

Route::get('/setlocale/{locale}', [LocaleController::class, 'set'])->name('setlocale');

Route::get('/privacy_policy', function () {
    return Storage::response('public/adatvedelmi_tajekoztato.pdf');
})->name('privacy_policy');

Route::get('/img/{filename}', [EmailController::class, 'getPicture']);

Auth::routes();

Route::get('/register/guest', [RegisterController::class, 'showTenantRegistrationForm'])->name('register.guest');

Route::get('/verification', function () {
    return view('auth.verification');
})->name('verification');

Route::middleware(['auth', 'log'])->group(function () {
    Route::get('/test_mails/{mail}/{send?}', [EmailController::class, 'testEmail']);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/userdata/update_password', [UserController::class, 'updatePassword'])->name('userdata.update_password');
});

Route::middleware(['auth', 'log', 'verified'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    /** User data */
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::post('/userdata/update_email', [UserController::class, 'updateEmail'])->name('userdata.update_email');
    Route::post('/userdata/update_phone', [UserController::class, 'updatePhone'])->name('userdata.update_phone');
    Route::get('/admin/user/list', [UserController::class, 'list'])->name('admin.user.list');
    Route::get('/admin/user/show/{id}', [UserController::class, 'show'])->name('admin.user.show');
    Route::get('/admin/semesters/{id}', [UserController::class, 'semesters'])->name('admin.user.semesters');
    Route::get('/admin/semesters/update/{id}/{semester}/{status}', [UserController::class, 'updateSemesterStatus'])->name('admin.user.semesters.update');

    /** Localization */
    Route::get('/localizations', [LocaleController::class, 'index'])->name('localizations');
    Route::post('/localizations/add', [LocaleController::class, 'add'])->name('localizations.add');
    Route::middleware(['can:viewAny,App\Models\LocalizationContribution'])->group(function () {
        Route::get('/localizations/admin', [LocaleController::class, 'indexAdmin'])->name('localizations.admin');
        Route::post('/localizations/approve', [LocaleController::class, 'approve'])->name('localizations.approve');
        Route::post('/localizations/approve_all', [LocaleController::class, 'approveAll'])->name('localizations.approve_all');
        Route::post('/localizations/delete', [LocaleController::class, 'delete'])->name('localizations.delete');
    });

    /** Printing */
    Route::get('/print', [PrintController::class, 'index'])->name('print');
    Route::get('/print/free_pages/all', [PrintController::class, 'listFreePages'])->name('print.free_pages.all');
    Route::get('/print/print_jobs/all', [PrintController::class, 'listPrintJobs'])->name('print.print_jobs.all');
    Route::post('/print/transfer_balance', [PrintController::class, 'transferBalance'])->name('print.transfer-balance');
    Route::post('/print/print_jobs/{id}/cancel', [PrintController::class, 'cancelPrintJob'])->name('print.print_jobs.cancel');
    Route::put('/print/print', [PrintController::class, 'print'])->name('print.print');
    Route::middleware(['can:print.modify'])->group(function () {
        Route::get('/print/account_history', [PrintController::class, 'listPrintAccountHistory'])->name('print.account_history');
        Route::get('/print/admin', [PrintController::class, 'admin'])->name('print.admin');
        Route::post('/print/modify_balance', [PrintController::class, 'modifyBalance'])->name('print.modify');
    });
    Route::post('/print/add_free_pages', [PrintController::class, 'addFreePages'])->name('print.free_pages')->middleware('can:print.modify-free');

    /** Internet */
    Route::get('/internet', [InternetController::class, 'index'])->name('internet');
    Route::get('/internet/mac_addresses/users', [InternetController::class, 'getUsersMacAddresses'])->name('internet.mac_addresses.users');
    Route::get('/internet/admin/mac_addresses/all', [InternetController::class, 'getUsersMacAddressesAdmin'])->name('internet.admin.mac_addresses.all');
    Route::get('/internet/admin/internet_accesses/all', [InternetController::class, 'getInternetAccessesAdmin'])->name('internet.admin.internet_accesses.all');
    Route::get('/internet/admin', [InternetController::class, 'admin'])->name('internet.admin');
    Route::post('/internet/mac_addresses/add', [InternetController::class, 'addMacAddress'])->name('internet.mac_addresses.add');
    Route::post('/internet/mac_addresses/{id}/edit', [InternetController::class, 'editMacAddress'])->name('internet.mac_addresses.edit');
    Route::post('/internet/mac_addresses/{id}/delete', [InternetController::class, 'deleteMacAddress'])->name('internet.mac_addresses.delete');
    Route::post('/internet/wifi_password/reset', [InternetController::class, 'resetWifiPassword'])->name('internet.wifi_password.reset');
    Route::post('/internet/internet_accesses/{id}/edit', [InternetController::class, 'editInternetAccess'])->name('internet.internet_accesses.edit');

    /** WIP: Admin Checkout **/
    //Route::get('/admin/checkout', 'InternetController@showCheckout')->name('admin.checkout');

    /** Routers */
    Route::get('/routers', [RouterController::class, 'index'])->name('routers');
    Route::get('/routers/{ip}', [RouterController::class, 'view'])->name('routers.view');

    /** Registration handling */
    Route::middleware(['can:registration.handle'])->group(function () {
        Route::get('/admin/registrations', [RegistrationsController::class, 'index'])->name('admin.registrations');
        Route::get('/admin/registrations/show/{id}', [RegistrationsController::class, 'show'])->name('admin.registrations.show');
        Route::get('/admin/registrations/accept/{id}', [RegistrationsController::class, 'accept'])->name('admin.registrations.accept');
        Route::get('/admin/registrations/reject/{id}', [RegistrationsController::class, 'reject'])->name('admin.registrations.reject');
    });

    /** Permission handling */
    Route::middleware(['can:permission.handle'])->group(function () {
        Route::get('/admin/permissions', [PermissionController::class, 'index'])->name('admin.permissions.list');
        Route::get('/admin/permissions/{id}/show', [PermissionController::class, 'show'])->name('admin.permissions.show');
        Route::post('/admin/permissions/{id}/edit/{role_id}', [PermissionController::class, 'edit'])->name('admin.permissions.edit');
        Route::post('/admin/permissions/{id}/remove/{role_id}/{object_id?}', [PermissionController::class, 'remove'])->name('admin.permissions.remove');
    });

    /** Faults */
    Route::get('/faults', [FaultsController::class, 'index'])->name('faults');
    Route::get('/faults/table', [FaultsController::class, 'GetFaultsTable'])->name('faults.table');
    Route::post('/faults/add', [FaultsController::class, 'addFault'])->name('faults.add');
    Route::post('/faults/update', [FaultsController::class, 'updateStatus'])->name('faults.update');

    /** WIP: Secretariat */
    Route::get('/secretariat/users', [SecretariatController::class, 'list'])->name('secretariat.users');

    /** Documents */
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents');
    Route::get('/documents/register-statement/download', [DocumentController::class, 'downloadRegisterStatement'])->name('documents.register-statement.download');
    Route::get('/documents/register-statement/print', [DocumentController::class, 'printRegisterStatement'])->name('documents.register-statement.print');
    Route::get('/documents/import/show', [DocumentController::class, 'showImport'])->name('documents.import.show');
    Route::post('/documents/import/add', [DocumentController::class, 'addImport'])->name('documents.import.add');
    Route::post('/documents/import/remove', [DocumentController::class, 'removeImport'])->name('documents.import.remove');
    Route::get('/documents/import/download', [DocumentController::class, 'downloadImport'])->name('documents.import.download');
    Route::get('/documents/import/print', [DocumentController::class, 'printImport'])->name('documents.import.print');
    Route::get('/documents/status-cert/download', [DocumentController::class, 'downloadStatusCertificate'])->name('documents.status-cert.download');
    Route::get('/documents/status-cert/request', [DocumentController::class, 'requestStatusCertificate'])->name('documents.status-cert.request');
    Route::get('/documents/status-cert/{id}/show', [DocumentController::class, 'showStatusCertificate'])->name('documents.status-cert.show');

    /** Student Council */
    Route::get('/economic_committee', [EconomicController::class, 'index'])->name('economic_committee');
    Route::get('/economic_committee/transaction', [EconomicController::class, 'indexTransaction'])->name('economic_committee.transaction');
    Route::post('/economic_committee/transaction/add', [EconomicController::class, 'addTransaction'])->name('economic_committee.transaction.add');
    Route::get('/economic_committee/transaction/delete/{transaction}', [EconomicController::class, 'deleteTransaction'])->name('economic_committee.transaction.delete');
    Route::get('/economic_committee/kktnetreg', [EconomicController::class, 'indexKKTNetreg'])->name('kktnetreg');
    Route::post('/economic_committee/kktnetreg/pay', [EconomicController::class, 'payKKTNetreg'])->name('kktnetreg.pay');
    Route::post('/economic_committee/kktnetreg/to_checkout', [EconomicController::class, 'KKTNetregToCheckout'])->name('kktnetreg.to_checkout');
});
