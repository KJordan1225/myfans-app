@extends('layouts.app')

@section('content')
<div class="row">
        <!-- sidebar here -->
        @include('layouts.components.sidebar')
        <div class="col-md-9">
            <h3 class="my-3">Add Media to Post</h3>
            <hr />
            <div class="row mt-2">
                <div class="col-md-9">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input:
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('creator.media.store') }}" 
                        method="POST" 
                        enctype="multipart/form-data"
                    >
                        @csrf

                        <!-- Hidden Post ID -->
                        <input type="hidden" 
                            name="post_id" 
                            value="{{ old('post_id', $post_id ?? '') }}"
                        >

                        <!-- Media Type -->
                        <div class="mb-3">
                            <label for="media_type" class="form-label">Media Type</label>
                            <select name="media_type" 
                                id="media_type" 
                                class="form-select"
                                style="border: 2px solid #6f42c1;"
                                required
                            >
                                <option value="image" {{ old('media_type') == 'image' ? 'selected' : '' }}>Image</option>
                                <option value="video" {{ old('media_type') == 'video' ? 'selected' : '' }}>Video</option>
                            </select>
                        </div>

                        <!-- Media File Upload -->
                        <div class="mb-3">
                            <label for="path" class="form-label">Upload Media File</label>
                            <input type="file" 
                                name="path" id="path" 
                                class="form-control"
                                style="border: 2px solid #6f42c1;"
                                required 
                                accept="image/*,video/*"
                            >
                            <div id="media-preview" class="mt-3"></div>
                        </div>

                        <!-- Optional Thumbnail -->
                        <div class="mb-3">
                            <label for="thumbnail_path" 
                                class="form-label"
                            >
                                Thumbnail (optional)
                            </label>
                            <input type="file" 
                                name="thumbnail_path" 
                                id="thumbnail_path" 
                                class="form-control" 
                                style="border: 2px solid #6f42c1;"
                                accept="image/*"
                            >
                            <div id="thumbnail-preview" class="mt-3"></div>
                        </div>

                        <!-- Submit -->
                        <div class="mb-3">
                            <button type="submit" 
                                class="btn btn-primary w-100"
                            >
                                Upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>
@endsection

@section('scripts')
<script>
    // Media file preview
    document.getElementById('path').addEventListener('change', function (event) {
        previewMedia(event.target, 'media-preview');
    });

    // Thumbnail preview
    document.getElementById('thumbnail_path').addEventListener('change', function (event) {
        previewMedia(event.target, 'thumbnail-preview');
    });

    function previewMedia(input, previewElementId) {
        const previewEl = document.getElementById(previewElementId);
        previewEl.innerHTML = ''; // Clear previous preview

        const file = input.files[0];
        if (!file) return;

        const url = URL.createObjectURL(file);
        const type = file.type;

        let element;
        if (type.startsWith('image/')) {
            element = document.createElement('img');
            element.src = url;
            element.style.maxWidth = '100%';
            element.className = 'img-fluid rounded border';
        } else if (type.startsWith('video/')) {
            element = document.createElement('video');
            element.src = url;
            element.controls = true;
            element.className = 'w-100 rounded border';
        } else {
            element = document.createElement('p');
            element.textContent = 'Preview not available for this file type.';
        }

        previewEl.appendChild(element);
    }
</script>
@endsection