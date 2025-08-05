@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="row">
        <!-- sidebar here -->
        @include('layouts.components.sidebar')
        <div class="col-md-9">
            <h3 class="my-3">Dashboard</h3>
            <hr />
            <div class="row mt-2">
                <div class="col-md-9">

                    <form id="payment-form">
                        @csrf
                        <div id="card-element" class="form-control"></div>
                        <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                        <input type="hidden" id="payment_method" name="payment_method">
                        <button id="card-button" class="btn btn-primary mt-3">Subscribe</button>
                    </form>`

				</div>
			</div>
		</div>
	</div>
@endsection


@push('scripts')
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe("{{ config('services.stripe.key') }}");
    const elements = stripe.elements();
    const cardElement = elements.create('card');
    cardElement.mount('#card-element');

    const form = document.getElementById('payment-form');
    const cardButton = document.getElementById('card-button');
    const paymentMethodInput = document.getElementById('payment_method');
    const cardErrors = document.getElementById('card-errors');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        cardButton.disabled = true;

        const { error, paymentMethod } = await stripe.createPaymentMethod({
            type: 'card',
            card: cardElement,
        });

        if (error) {
            cardErrors.textContent = error.message;
            cardButton.disabled = false;
        } else {
            paymentMethodInput.value = paymentMethod.id;
            // Now submit the form with the payment method ID to your backend
            form.submit();
        }
    });
</script>
@endpush