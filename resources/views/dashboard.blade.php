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
				
<div class="py-12" style="margin-left: 250px;">
	<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
		<div class=" dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
			<div class="p-6 text-gray-900 dark:text-gray-100">
				{{ __("You're logged in!") }}
			</div>

			<br>
			<br>
			<br>
			<div>
				<a href="{{ route('logout') }}" 
					onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
						Logout
				</a>

				<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
					@csrf
				</form>
			</div>
		</div>
	</div>
</div>

				</div>
			</div>
		</div>
	</div>
@endsection