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
           
    <div class="row">
        <!-- sidebar here -->
        @include('layouts.components.sidebar')
        <div class="col-md-9">
            <h3 class="my-3">Edit User Profile
            </h3>
            <hr />
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="max-w-xl mx-auto p-6 rounded shadow">
                        <h2 class="text-2xl font-bold mb-4 dark:text-gray-100">Edit Your Profile</h2>

                            <form action="{{ route('user-profiles.update', $profile) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                                @csrf
                                @method('PUT')

                                <!-- Display Name -->
                                <div class="mb-3">
                                    <label for="display_name" class="form-label">Display Name</label>
                                    <input type="text" name="display_name" id="display_name" class="form-control" style="border: 2px solid #6f42c1;"
                                        value="{{ old('display_name', $profile->display_name) }}" required>
                                </div>

                                <!-- Bio -->
                                <div class="mb-3">
                                    <label for="bio" class="form-label">Bio</label>
                                    <textarea name="bio" id="bio" class="form-control" style="border: 2px solid #6f42c1;" rows="4">{{ old('bio', $profile->bio) }}</textarea>
                                </div>

                                <!-- Avatar Upload -->
                                <div class="mb-3">
                                    <label for="avatar" class="form-label">Avatar</label>
                                    <input type="file" name="avatar" id="avatar" accept="image/*"
                                        class="form-control @error('avatar') is-invalid @enderror"
                                        onchange="previewImage(this, 'avatar-preview')">
                                    @error('avatar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="mt-2">
                                        <img id="avatar-preview" src="#" alt="Avatar Preview"
                                            class="d-none border rounded" style="width: 100px; height: 100px; object-fit: cover;">
                                    </div>
                                </div>


                                <!-- Banner Upload -->
                                <div class="mb-3">
                                    <label for="banner" class="form-label">Banner</label>
                                    <input type="file" name="banner" id="banner" accept="image/*"
                                        class="form-control @error('banner') is-invalid @enderror"
                                        onchange="previewImage(this, 'banner-preview')">
                                    @error('banner')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="mt-2">
                                        <img id="banner-preview" src="#" alt="Banner Preview"
                                            class="d-none border rounded" style="width: 100%; max-height: 200px; object-fit: cover;">
                                    </div>
                                </div>


                                <!-- Website -->
                                <div class="mb-3">
                                    <label for="website" class="form-label">Website</label>
                                    <input type="url" name="website" id="website" class="form-control" style="border: 2px solid #6f42c1;"
                                        value="{{ old('website', $profile->website) }}">
                                </div>

                                <!-- Twitter -->
                                <div class="mb-3">
                                    <label for="twitter" class="form-label">Twitter</label>
                                    <input type="text" name="twitter" id="twitter" class="form-control" style="border: 2px solid #6f42c1;"
                                        value="{{ old('twitter', $profile->twitter) }}">
                                </div>

                                <!-- Instagram -->
                                <div class="mb-3">
                                    <label for="instagram" class="form-label">Instagram</label>
                                    <input type="text" name="instagram" id="instagram" class="form-control" style="border: 2px solid #6f42c1;"
                                        value="{{ old('instagram', $profile->instagram) }}">
                                </div>

                                <!-- Is Creator -->
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" name="is_creator" id="is_creator" value="1"
                                        {{ old('is_creator', $profile->is_creator) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_creator">I'm a content creator</label>
                                </div>

                                <!-- Submit -->
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary w-10">
                                        Update Profile
                                    </button>
                                </div>
                            </form>

                        <!-- Delete Button -->
                        <form action="{{ route('user-profiles.destroy', $profile) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete your profile?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-10">
                                Delete Profile
                            </button>
                        </form>              
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS for Preview -->
    <script>
        function previewImage(input, previewId) {
            const file = input.files[0];
            const preview = document.getElementById(previewId);

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = "#";
                preview.classList.add('d-none');
            }
        }
    </script>

@endsection







