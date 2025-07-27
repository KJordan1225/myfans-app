@extends('layouts.app')

@section('header')
    <h2 class="font-semibold 
                text-xl
                text-gray-800 
                dark:text-gray-200 
                leading-tight"
    >
        {{ __('Edit User Profile') }}
    </h2>
@endsection

@section('content')
    <div class="py-12" style="margin-left: 250px;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div div class="p-6 text-gray-900 dark:text-gray-100">                    
                        
                    <div class="max-w-xl mx-auto p-6 rounded shadow">
                        <h2 class="text-2xl font-bold mb-4 dark:text-gray-100">Edit Your Profile</h2>

                        <form action="{{ route('user-profiles.update', $profile) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Display Name -->
                            <div class="mb-4">
                                <label for="display_name" class="block font-semibold">Display Name</label>
                                <input type="text" name="display_name" id="display_name"
                                    class="text-black w-full border rounded p-2"
                                    value="{{ old('display_name', $profile->display_name) }}" required>
                            </div>

                            <!-- Bio -->
                            <div class="mb-4">
                                <label for="bio" class="block font-semibold">Bio</label>
                                <textarea name="bio" id="bio" class="text-black w-full border rounded p-2" rows="4">{{ old('bio', $profile->bio) }}</textarea>
                            </div>

                            <!-- Avatar Upload -->
                            <div class="mb-4">
                                <label for="avatar" class="block font-semibold">Avatar (optional)</label>
                                <input type="file" name="avatar" id="avatar" class="w-full" accept="image/*" onchange="previewImage(this, 'avatar-preview')">

                                <div class="mt-2">
                                    <img
                                        id="avatar-preview"
                                        src="{{ $profile->avatar ? asset('storage/' . $profile->avatar) : '#' }}"
                                        alt="Avatar Preview"
                                        class="w-32 h-32 object-cover rounded border {{ $profile->avatar ? '' : 'hidden' }}">
                                </div>
                            </div>

                            <!-- Banner Upload -->
                            <div class="mb-4">
                                <label for="banner" class="block font-semibold">Banner (optional)</label>
                                <input type="file" name="banner" id="banner" class="w-full" accept="image/*" onchange="previewImage(this, 'banner-preview')">

                                <div class="mt-2">
                                    <img
                                        id="banner-preview"
                                        src="{{ $profile->banner ? asset('storage/' . $profile->banner) : '#' }}"
                                        alt="Banner Preview"
                                        class="w-full h-32 object-cover rounded border {{ $profile->banner ? '' : 'hidden' }}">
                                </div>
                            </div>

                            <!-- Website -->
                            <div class="mb-4">
                                <label for="website" class="block font-semibold">Website</label>
                                <input type="url" name="website" id="website" class="text-black w-full border rounded p-2"
                                    value="{{ old('website', $profile->website) }}">
                            </div>

                            <!-- Twitter -->
                            <div class="mb-4">
                                <label for="twitter" class="block font-semibold">Twitter</label>
                                <input type="text" name="twitter" id="twitter" class="text-black w-full border rounded p-2"
                                    value="{{ old('twitter', $profile->twitter) }}">
                            </div>

                            <!-- Instagram -->
                            <div class="mb-4">
                                <label for="instagram" class="block font-semibold">Instagram</label>
                                <input type="text" name="instagram" id="instagram" class="text-black w-full border rounded p-2"
                                    value="{{ old('instagram', $profile->instagram) }}">
                            </div>

                            <!-- Is Creator -->
                            <div class="mb-4">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="is_creator" value="1" class="mr-2"
                                        {{ old('is_creator', $profile->is_creator) ? 'checked' : '' }}>
                                    <span>I'm a content creator</span>
                                </label>
                            </div>

                            <!-- Submit -->
                            <div class="mb-4">
                                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">
                                    Update Profile
                                </button>
                            </div>
                        </form>

                        <!-- Delete Button -->
                        <form action="{{ route('user-profiles.destroy', $profile) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your profile?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                Delete Profile
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function previewImage(input, targetId) {
        const file = input.files[0];
        const preview = document.getElementById(targetId);

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


