@extends('layouts.app')
@section('content')
    <div class="row">
    @include('layouts.components.sidebar')
        <div class="col-md-9">
        <h3 class="my-3">{{ $creator->profile->display_name }}'s Subscription Plans</h3>
        <hr />
        <div class="row mt-2">
            <div class="col-md-9">
 
<div class="max-w-2xl mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">{{ $creator->profile->display_name }}'s Subscription Plans</h2>

	
		<form id="subscription-form" method="POST" action="{{ route('subscription.create') }}">
            @csrf

            <!-- Plan Selector -->
            <div class="mb-4">
                <label for="price_id" class="block font-semibold mb-1">Choose a Plan</label>
                <select name="price_id" id="price_id" 
                    class="w-full p-2 rounded" 
                    style="border: 2px solid #6f42c1;"
                    required>
                    @foreach($plans as $plan)
                        <option value="{{ $plan->stripe_price_id }}">
                            {{ ucfirst($plan->interval) }} - ${{ number_format($plan->amount, 2) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Stripe Card Element -->
            <div class="mb-4">
                <label for="card-element" class="block font-semibold mb-1">Card Details</label>
                <div id="card-element" 
                    class="p-3 rounded"></div>
                <input type="hidden" 
                    name="payment_method" 
                    id="payment-method"
                    value="{{ old('payment_method') }}">
            </div>

            <!-- Confirm Button -->
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
    const stripe = Stripe("{{ $stripeKey }}"); // Set in controller
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');

    document.getElementById('submit-button').addEventListener('click', async function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Confirm Subscription',
            text: "Do you want to proceed with the selected plan?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Subscribe!',
            cancelButtonText: 'Cancel'
        }).then(async (result) => {
            if (result.isConfirmed) {
                const { paymentMethod, error } = await stripe.createPaymentMethod({
                    type: 'card',
                    card: card,
                });

                if (error) {
                    Swal.fire('Payment Error', error.message, 'error');
                } else {
                    document.getElementById('payment-method').value = paymentMethod.id;
                    document.getElementById('subscription-form').submit();
                }
            }
        });
    });
</script>

@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: "{{ session('success') }}",
        toast: true,
        position: 'top-end',
        timer: 3000,
        showConfirmButton: false,
    });
</script>
@endif

@if (session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: "{{ session('error') }}",
        toast: true,
        position: 'top-end',
        timer: 3000,
        showConfirmButton: false,
    });
</script>
@endif
@endpush