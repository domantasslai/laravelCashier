<?php
namespace App\Extra;

use \Laravel\Cashier\Payment;

class PaymentClass extends Payment{

  /**
   * Determine if the payment was successful.
   *
   * @return bool
   */
  public function isSucceeded()
  {
      return $this->paymentIntent->status === StripePaymentIntent::STATUS_SUCCEEDED;
  }
}
