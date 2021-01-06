<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Exceptions\IncompletePayment;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(['middleware' => 'auth'], function () {
    // SUBSCRIPTION //
    Route::get('/subscribe', function ()    {
        return view('subscribe', [
                  'intent' => auth()->user()->createSetupIntent()
              ]);
    })->name('subscribe')->middleware('nonPayingCustomer');

    Route::post('/subscribe', function (Request $request){

        auth()->user()->newSubscription('cashier', $request->plan)->create($request->paymentMethod);

        return redirect('/dashboard');
    })->name('subscribe')->middleware('nonPayingCustomer');
    // END SUBSCRIPTION //


    Route::get('/members', function ()    {
        return view('members');
    })->name('members')->middleware('payingCustomer');

    // SINGLE CHARGES //
    Route::get('/charge', function ()    {
        return view('charge', [
          'intent' => auth()->user()->createSetupIntent()
        ]);
    })->name('charge');

    Route::get('payment/{id}', [App\Http\Controllers\TestController::class, 'show'])->name('payment');
    Route::post('/charge', function (Request $request){
        try {
          $charge = auth()->user()->charge(100, $request->paymentMethod);

        } catch (IncompletePayment $exception) {
          return redirect()->route('payment',
              [$exception->payment->id]
          );
        }
        // try {
        //   auth()->user()->invoiceFor('One Time Fee', 100);
        // } catch (\Exception $e) {
        //   auth()->user()->createAsStripeCustomer();
        //   auth()->user()->updateDefaultPaymentMethod($request->paymentMethod);
        //   auth()->user()->invoiceFor('One Time Fee', 100);
        // }

        return redirect('/dashboard');
    })->name('charge');


    Route::get('payments/approval', [App\Http\Controllers\TestController::class, 'approval'])->name('payment.approval');
    Route::get('payments/cancelled', [App\Http\Controllers\TestController::class, 'cancelled'])->name('payment.cancelled');
    // END SINGLE CHARGES //

    // INVOICES //

    Route::get('/invoices', function ()    {

      return redirect()->route('dashboard')->withErrors('erororor');
        return view('invoices', [
          'invoices' => auth()->user()->invoices()
        ]);
    })->name('invoices');

    Route::get('/user/invoice/{invoice}', function (Request $request, $invoiceId) {
        return $request->user()->downloadInvoice($invoiceId, [
            'vendor' => 'Domantas',
            'product' => 'Bandymas',
        ]);
    });

    // END INVOICES //
});

require __DIR__.'/auth.php';
