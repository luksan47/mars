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

Route::get('/setlocale/{locale}', 'LocaleController@set')->name('setlocale');

Route::get('/privacy_policy', function () {
    return Storage::response('public/adatvedelmi_tajekoztato.pdf');
})->name('privacy_policy');

Route::get('/img/{filename}', function($filename){
    $path = public_path() . '//img//' . $filename;

    if(!File::exists($path)) {
        return response()->json(['message' => 'Image not found'], 404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

Auth::routes();

Route::get('/register/guest', 'Auth\RegisterController@showTenantRegistrationForm')->name('register.guest');

Route::get('/verification', function () {
    return view('auth.verification');
})->name('verification');

Route::middleware(['auth', 'log'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/user', 'UserController@index')->name('user');
});

Route::middleware(['auth', 'log', 'verified'])->group(function () {
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
    Route::post('/admin/registrations/show', 'Admin\RegistrationsController@show')->name('admin.registrations.show');

    Route::get('/faults', 'FaultsController@index')->name('faults');
    Route::get('/faults/table', 'FaultsController@GetFaultsTable')->name('faults.table');
    Route::post('/faults/add', 'FaultsController@addFault')->name('faults.add');
    Route::post('/faults/update', 'FaultsController@updateStatus')->name('faults.update');

    Route::get('/secretariat/users', 'SecretariatController@list')->name('secretariat.users');
});

//test emails with urls
Route::get('/test_mails/{mail}/{send?}', function ($mail, $send = false) {
    //to see preview:   /test_mails/Confirmation
    //to send:          /test_mails/Confirmation/send            
    if (config('app.debug')) {
        $user = Auth::user();
        $mailClass = '\\App\\Mail\\'.$mail;
        if($send == "send"){
            Mail::to($user)->queue(new $mailClass($user->name));
            return response("Email sent.");
        } else{
            return new $mailClass($user->name);
        }
    } else {
        abort(404);
    }
});