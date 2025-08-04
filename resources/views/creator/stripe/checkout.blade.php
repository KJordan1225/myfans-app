@extends('layouts.app')
@section('content')
    <div class="row">
    @include('layouts.components.sidebar')
        <div class="col-md-9">
        <h3 class="my-3">Edit Post</h3>
        <hr />
        <div class="row mt-2">
            <div class="col-md-9">


<div class="container mt-5">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<div class="card shadow-sm">
				<div class="card-header bg-primary text-white text-center">
					<h4>Stripe Checkout</h4>
				</div>
				<div class="card-body text-center">
					<h5 class="card-title">Creator Processing Fee</h5>
					<p class="card-text">Price: $5.00</p>

					<form action="{{ route('creator.stripe.process') }}" method="POST">
						@csrf
						<button type="submit" class="btn btn-primary btn-lg mt-3">Pay with Stripe</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>



            </div>
        </div>
      </div>
    </div>
@endsection