@extends('layouts.app')

@section('header')
    <h2 class="font-semibold 
                text-xl
                text-gray-800 
                dark:text-gray-200 
                leading-tight"
    >
        {{ __('Dashboard') }}
    </h2>
@endsection

@section('content')
    <div class="py-12" style="margin-left: 250px;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
				
				
					<form action="#" method="POST" enctype="multipart/form-data">
						@csrf

						<input type="text" name="title" placeholder="Post title" required>
						<textarea name="body" required></textarea>

						<select name="visibility" required>
							<option value="public">Public</option>
							<option value="subscribers">Subscribers Only</option>
						</select>

						<input type="number" name="price" step="0.01" placeholder="Price (optional)">
						<input type="file" name="image" accept="image/*">

						<button type="submit">Post</button>
					</form>
				
				
                </div>
            </div>
        </div>
    </div>
@endsection