@extends('layouts.app')
@section('content')
    <div class="row">
    @include('layouts.components.sidebar')
        <div class="col-md-9">
        <h3 class="my-3">Test Subscription Form</h3>
        <hr />
        <div class="row mt-2">
            <div class="col-md-9">
			
			
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4 text-center">Subscribe Now</h2>

    <form id="subscription-form" method="POST" action="{{ route('subscription.store') }}">
        @csrf

        <!-- Stripe Card Element -->
        <div class="mb-4">
            <label for="card-element" class="block font-semibold">Credit or Debit Card</label>
            <div id="card-element" class="p-3 border rounded mt-2"></div>
            <div id="card-errors" class="text-red-600 mt-2 text-sm" role="alert"></div>
        </div>

        <!-- Hidden Payment Method Input -->
        <input type="hidden" name="payment_method" id="payment_method">

        <!-- Submit Button -->
        <!-- <button type="submit" id="submit-button"
            class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded">
            Confirm Subscription
        </button> -->
        <button type="submit" id="submit-button"
            class="btn text-white w-15 fw-semibold py-2 px-4 rounded"
            style="background-color: #6f42c1; border-color: #6f42c1;">
            Confirm Subscription
        </button>
    </form>
</div>



            </div>
        </div>
      </div>
    </div>
@endsection

@push('scripts')
<!-- Stripe.js -->
<script src="https://js.stripe.com/v3/"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const stripe = Stripe("{{ config('services.stripe.key') }}");
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');

    const form = document.getElementById('subscription-form');
    const cardErrors = document.getElementById('card-errors');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Subscribe?',
            text: 'Do you want to confirm your subscription?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, confirm it!',
            cancelButtonText: 'No, cancel',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then(async (result) => {
            if (result.isConfirmed) {
                const {error, paymentMethod} = await stripe.createPaymentMethod({
                    type: 'card',
                    card: card,
                });

                if (error) {
                    cardErrors.textContent = error.message;

                    Swal.fire({
                        icon: 'error',
                        title: 'Payment Error',
                        text: error.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000,
                    });

                    return;
                }

                document.getElementById('payment_method').value = paymentMethod.id;
                form.submit();
            }
        });
    });

    // SweetAlert2 Toasts for flash messages
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: '{{ session('success') }}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true
        });
    @endif

    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: '{{ session('error') }}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    @endif
});
</script>
@endpush


