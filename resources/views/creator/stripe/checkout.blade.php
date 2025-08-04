@extends('layouts.app')
@section('content')
    <div class="row">
    @include('layouts.components.sidebar')
        <div class="col-md-9">
        <h3 class="my-3">Processing Fee Checkout</h3>
        <hr />
        <div class="row mt-2">
            <div class="col-md-9">


<div class="container mt-5">
	<div class="row justify-content-center">		
			<div class="text-black text-center mb-5">
				<p>
					To become a verified creator on our platform, users must pay a 
					one-time $5 processing fee. This small investment helps us 
					confirm the authenticity of each creator and maintain a secure, 
					high-quality environment for both creators and subscribers. Once 
					paid, this fee grants you lifetime access to exclusive creator 
					tools, features, and monetization options—no recurring charges 
					or hidden costs. It’s a simple, affordable way to unlock your 
					earning potential and join our growing community of content 
					creators. By completing this step, you ensure your profile 
					stands out as legitimate and trusted, ready to start building 
					and monetizing your audience.
				</p>
			</div>			
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

