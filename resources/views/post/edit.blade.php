@extends('layouts.app')
@section('content')
    <div class="row">
    @include('layouts.components.sidebar')
        <div class="col-md-9">
        <h3 class="my-3">Edit Post</h3>
        <hr />
        <div class="row mt-2">
            <div class="col-md-9">
 
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Post</h4>
                </div>
                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="#" method="POST">
                        @csrf
                        @method('PATCH')

                        {{-- Title --}}
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $post->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Body --}}
                        <div class="mb-3">
                            <label for="body" class="form-label">Body</label>
                            <textarea class="form-control @error('body') is-invalid @enderror" id="body" name="body" rows="5">{{ old('body', $post->body) }}</textarea>
                            @error('body')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Price --}}
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $post->price) }}">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Is Paid --}}
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_paid" name="is_paid" value="1" @checked(old('is_paid', $post->is_paid))>
                            <label class="form-check-label" for="is_paid">This is a paid post</label>
                            @error('is_paid')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Visibility --}}
                        <div class="mb-3">
                            <label for="visibility" class="form-label">Visibility</label>
                            <select class="form-select @error('visibility') is-invalid @enderror" id="visibility" name="visibility" required>
                                <option value="public" @selected(old('visibility', $post->visibility) === 'public')>Public</option>
                                <option value="subscribers" @selected(old('visibility', $post->visibility) === 'subscribers')>Subscribers Only</option>
                                <option value="paid" @selected(old('visibility', $post->visibility) === 'paid')>Paid Only</option>
                            </select>
                            @error('visibility')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Update Post</button>
                            <a href="#" class="btn btn-secondary">Cancel</a>
                        </div>
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