@push('style')
  <style>
      /**
      * The CSS shown here will not be introduced in the Quickstart guide, but shows
      * how you can use CSS to style your Element's container.
      */
      .StripeElement {
      box-sizing: border-box;

      height: 40px;

      padding: 10px 12px;

      border: 1px solid transparent;
      border-radius: 4px;
      background-color: white;

      box-shadow: 0 1px 3px 0 #e6ebf1;
      -webkit-transition: box-shadow 150ms ease;
      transition: box-shadow 150ms ease;
      }

      .StripeElement--focus {
      box-shadow: 0 1px 3px 0 #cfd7df;
      }

      .StripeElement--invalid {
      border-color: #fa755a;
      }

      .StripeElement--webkit-autofill {
      background-color: #fefde5 !important;}
  </style>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Charge') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                      <form action="{{ route('charge') }}" class="mx-auto sm:w-1/2" method="post" id="payment-form">
                        @csrf
                        <div>
                          Product Name and Price and description goes here
                        </div>
                        <div class="form-row">
                          <label for="cardholder-name">Cardholder's Name</label>
                          <div>
                              <input type="text" id="cardholder-name" class="px-2 py-2 border">
                          </div>

                          <label for="card-element">
                            Credit or debit card
                          </label>
                          <div id="card-element">
                            <!-- A Stripe Element will be inserted here. -->
                          </div>

                          <!-- Used to display form errors. -->
                          <div id="card-errors" role="alert"></div>
                        </div>

                        <x-button class="flex justify-center mt-3" id="pay-button">
                            {{ __('Pay') }}
                        </x-button>
                      </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
      <script src="https://js.stripe.com/v3/"></script>
      <script>
        // Create a Stripe client.
        // Note: this merchant has been set up for demo purposes.
        var stripe = Stripe('{{ config('services.stripe.key') }}');

        // Create an instance of Elements.
        var elements = stripe.elements();

        // Custom styling can be passed to options when creating an Element.
        // (Note that this demo uses a wider set of styles than the guide below.)
        var style = {
          base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
              color: '#aab7c4'
            }
          },
          invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
          }
        };

        // Create an instance of the card Element.
        var card = elements.create('card', {
          style: style,
          hidePostalCode: true
        });

        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');
        // Handle real-time validation errors from the card Element.
        card.on('change', function(event) {
          var displayError = document.getElementById('card-errors');
          if (event.error) {
            displayError.textContent = event.error.message;
          } else {
            displayError.textContent = '';
          }
        });

        // Handle form submission.
        var form = document.getElementById('payment-form');
        var cardHolderName = document.getElementById('cardholder-name');
        var subscribeButton = document.getElementById('subscribe-button');

        form.addEventListener('submit', async function(event) {
            event.preventDefault();

            // Disable the submit button to prevent repeated clicks
            document.getElementById('pay-button').disabled = true;

            const { paymentMethod, error } = await stripe.createPaymentMethod(
                'card', card, {
                    billing_details: { name: cardHolderName.value }
                }
            );
            if (error) {
                // Inform the user if there was an error.
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = error.message;

                // Enable the submit button
                document.getElementById('pay-button').disabled = false;
            } else {
                // Send the token to your server.
                stripeTokenHandler(paymentMethod);
            }
            // stripe.createToken(card).then(function(result) {
            //     if (result.error) {
            //     // Inform the user if there was an error.
            //     var errorElement = document.getElementById('card-errors');
            //     errorElement.textContent = result.error.message;
            //     } else {
            //     // Send the token to your server.
            //     stripeTokenHandler(result.token);
            //     }
            // });
        });

        // Submit the form with the token ID.
            function stripeTokenHandler(paymentMethod) {
              // Insert the token ID into the form so it gets submitted to the server
              var form = document.getElementById('payment-form');
              var hiddenInput = document.createElement('input');
              hiddenInput.setAttribute('type', 'hidden');
              hiddenInput.setAttribute('name', 'paymentMethod');
              hiddenInput.setAttribute('value', paymentMethod.id);
              form.appendChild(hiddenInput);
              // Submit the form
              form.submit();
        }
      </script>
    @endpush
</x-app-layout>
