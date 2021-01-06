<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Payment;
use Laravel\Cashier\Cashier;
use Stripe\PaymentIntent as StripePaymentIntent;

class TestController extends Controller
{
    public function show($id){
        return view('stripe.3d-secure')->with([
            'payment' => new Payment(
                StripePaymentIntent::retrieve($id, Cashier::stripeOptions())
            )
        ]);
    }


    public function approval()
    {
        return redirect()
            ->route('dashboard')
            ->with('success_message', 'The payment was successful.');
    }

    public function cancelled()
    {
      return redirect()
          ->route('dashboard')
          ->withErrors('Payment cancelled');

    }
}
