@extends('layouts.app')

@section('header')
    <h2 class="font-semibold 
                text-xl
                text-gray-800 
                dark:text-gray-200 
                leading-tight"
    >
        {{ __('Create Post') }}
    </h2>
@endsection

@section('content')
    <div class="py-12" style="margin-left: 250px;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
				
				
					<form action="#" method="POST" enctype="multipart/form-data">
						@csrf

						<div class="mb-4">
                            <label for="title" class="block font-semibold">Title</label>
                            <input type="text" name="title" id="title"
                                class="w-full border rounded p-2 text-black" value="{{ old('title') }}" required>
						</div>

                        <div class="mb-4">
                            <label for="body" class="block font-semibold">Body</label>
                            <textarea name="body" id="body" rows="4"
                                class="w-full border rounded p-2 text-black" required>{{ old('body') }}</textarea>
						</div>

						<div class="mb-4">
                            <label for="visibility" class="block font-semibold">Visibility</label>
                            <select name="visibility" id="visibility" required class="text-black">
                                <option value="public">Public</option>
                                <option value="subscribers">Subscribers</option>
                                <option value="paid">Paid</option>
                            </select>
                        </div>

						<div class="mb-4">
                            <label for="price" class="block font-semibold">Price</label>
                            <input type="number" name="price" id="price" step="0.01" placeholder="Price (optional)"
                                class="w-full border rounded p-2 text-black">
						</div>

                        <div class="mb-4">
                            <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">
                                Post
                            </button>
                        </div>

					</form>
				
				
                </div>
            </div>
        </div>
    </div>
@endsection