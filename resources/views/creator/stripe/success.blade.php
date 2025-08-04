@extends('layouts.app')
@section('content')
    <div class="row">
    @include('layouts.components.sidebar')
        <div class="col-md-9">
        <h3 class="my-3">Payment Success!</h3>
        <hr />
        <div class="row mt-2">
            <div class="col-md-9">


<div class="container mt-5">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<div class="card shadow-sm">
				<div class="card-header bg-success text-white text-center">
					<h4>Stripe Checkout SUCCESS</h4>                    
				</div>
                <div class="card-body bg-white text-black text-center">
                    <p>You now have life-time access to all <br>
                        CREATOR functionality</p>
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