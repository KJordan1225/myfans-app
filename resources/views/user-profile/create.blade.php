@extends('layouts.app')

@section('header')
    <h2 class="font-semibold 
                text-xl
                text-gray-800 
                dark:text-gray-200 
                leading-tight"
    >
        {{ __('Create User Profile') }}
    </h2>
@endsection

@section('content')
    <div class="py-12" style="margin-left: 250px;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="max-w-xl mx-auto p-6 rounded shadow">
                        <h2 class="text-2xl font-bold mb-4 text-gray-100">Create Your Profile</h2>

                        <form action="{{ route('user-profiles.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Display Name -->
                            <div class="mb-4">
                                <label for="display_name" class="block font-semibold">Display Name</label>
                                <input type="text" name="display_name" id="display_name"
                                    class="w-full border rounded p-2 text-black" value="{{ old('display_name') }}" required>
                            </div>

                            <!-- Bio -->
                            <div class="mb-4">
                                <label for="bio" class="block font-semibold">Bio</label>
                                <textarea name="bio" id="bio" class="w-full border rounded p-2 text-black" rows="4">{{ old('bio') }}</textarea>
                            </div>

                            <!-- Avatar Upload -->
                            <div class="mb-4">
                                <label for="avatar" class="block font-semibold">Avatar (optional)</label>
                                <input type="file" name="avatar" id="avatar" class="w-full" accept="image/*" onchange="previewImage(this, 'avatar-preview')">
                                <div class="mt-2">
                                    <img id="avatar-preview" src="#" alt="Avatar Preview" class="hidden w-24 h-24 rounded object-cover border">
                                </div>
                            </div>
                            

                            <!-- Banner Upload -->
                            <div class="mb-4">
                                <label for="banner" class="block font-semibold">Banner (optional)</label>
                                <input type="file" name="banner" id="banner" class="w-full" accept="image/*" onchange="previewImage(this, 'banner-preview')">
                                <div class="mt-2">
                                    <img id="banner-preview" src="#" alt="Banner Preview" class="hidden w-full h-32 rounded object-cover border">
                                </div>
                            </div>

                            <!-- Website -->
                            <div class="mb-4">
                                <label for="website" class="block font-semibold">Website</label>
                                <input type="url" name="website" id="website" class="w-full border rounded p-2 text-black" value="{{ old('website') }}">
                            </div>

                            <!-- Twitter -->
                            <div class="mb-4">
                                <label for="twitter" class="block font-semibold">Twitter</label>
                                <input type="text" name="twitter" id="twitter" class="w-full border rounded p-2 text-black" value="{{ old('twitter') }}">
                            </div>

                            <!-- Instagram -->
                            <div class="mb-4">
                                <label for="instagram" class="block font-semibold">Instagram</label>
                                <input type="text" name="instagram" id="instagram" class="w-full border rounded p-2 text-black" value="{{ old('instagram') }}">
                            </div>

                            <!-- Is Creator -->
                            <div class="mb-4">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="is_creator" value="1" class="mr-2" {{ old('is_creator') ? 'checked' : '' }}>
                                    <span>I'm a content creator</span>
                                </label>
                            </div>

                            <!-- Submit -->
                            <div class="mb-4">
                                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">
                                    Save Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Preview -->
    <script>
        function previewImage(input, previewId) {
            const file = input.files[0];
            const preview = document.getElementById(previewId);

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = "#";
                preview.classList.add('hidden');
            }
        }
    </script>
@endsection