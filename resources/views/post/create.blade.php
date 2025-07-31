@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="row">
        <!-- sidebar here -->
        @include('layouts.components.sidebar')
        <div class="col-md-9">
            <h3 class="my-3">Create Post</h3>
            <hr />
            <div class="row mt-2">
                <div class="col-md-4">
                    <form action="#" method="POST">
                        @csrf
                        @if(isset($post))
                            @method('PUT')
                        @endif

                        <!-- Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text"
                                name="title"
                                id="title"
                                class="form-control"
                                value="{{ old('title', $post->title ?? '') }}"
                                required>
                        </div>

                        <!-- Body -->
                        <div class="mb-3">
                            <label for="body" class="form-label">Post Content</label>
                            <textarea name="body"
                                    id="body"
                                    class="form-control"
                                    rows="5"
                                    placeholder="Write your post here...">{{ old('body', $post->body ?? '') }}</textarea>
                        </div>

                        <!-- Price (only shown if paid visibility is selected with JavaScript, but always rendered for now) -->
                        <div class="mb-3">
                            <label for="price" class="form-label">Price (USD)</label>
                            <input type="number"
                                step="0.01"
                                name="price"
                                id="price"
                                class="form-control"
                                value="{{ old('price', $post->price ?? '') }}"
                                placeholder="Optional price if post is paid">
                        </div>

                        <!-- Is Paid -->
                        <div class="mb-3 form-check">
                            <input type="checkbox"
                                name="is_paid"
                                id="is_paid"
                                class="form-check-input"
                                value="1"
                                {{ old('is_paid', $post->is_paid ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_paid">This is a paid post</label>
                        </div>

                        <!-- Visibility -->
                        <div class="mb-3">
                            <label for="visibility" class="form-label">Visibility</label>
                            <select name="visibility" id="visibility" class="form-select" required>
                                <option value="public" {{ old('visibility', $post->visibility ?? 'public') === 'public' ? 'selected' : '' }}>Public</option>
                                <option value="subscribers" {{ old('visibility', $post->visibility ?? '') === 'subscribers' ? 'selected' : '' }}>Subscribers Only</option>
                                <option value="paid" {{ old('visibility', $post->visibility ?? '') === 'paid' ? 'selected' : '' }}>Paid</option>
                            </select>
                        </div>

                        <!-- Submit -->
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100">
                                {{ isset($post) ? 'Update Post' : 'Create Post' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>            
        </div>
    </div>
@endsection