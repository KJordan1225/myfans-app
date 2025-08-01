@extends('layouts.app')
@section('content')
    <div class="row">
    @include('layouts.components.sidebar')
        <div class="col-md-9">
        <h3 class="my-3">All Posts for User ID: {{ auth()->id() }}</h3>
        <hr />
        <div class="row mt-2">
            <div class="col-md-9">


                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle" id="postsTable">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($posts as $post)
                                <tr>
                                    <td>{{ $post->id }}</td>
                                    <td>{{ $post->title }}</td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-sm btn-warning me-1">
                                            Edit
                                        </a>

                                        <form action="#" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger me-1">Delete</button>
                                        </form>

                                        <a href="{{ route('creator.media.list', ['post_id' => $post->id]) }}" class="btn btn-sm btn-info">
                                            Media
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No posts found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
    
    
    
                </div>
            </div>
        </div>
    </div>
@endsection