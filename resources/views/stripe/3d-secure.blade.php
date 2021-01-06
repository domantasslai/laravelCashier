<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                  <div class="card-header">Complete the security steps</div>

                  <div class="card-body">
                      <p>Extra confirmation is needed to process your payment. Please continue to the payment page by clicking on the button below.</p>
                  </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
      <script src="https://js.stripe.com/v3/"></script>
      <script>
      const stripe = Stripe('{{ config('services.stripe.key') }}');
      stripe.confirmCardPayment("{{ $payment->clientSecret() }}")
          .then(function(result) {
            if (result.error) {
              // Show error to your customer
              window.location.replace("{{ route('payment.cancelled') }}");
            } else {
              // The payment succeeded!
              window.location.replace("{{ route('payment.approval') }}");
            }
          });
      </script>
    @endpush
</x-app-layout>
