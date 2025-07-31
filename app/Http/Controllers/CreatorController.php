<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Post\StorePostRequest;

class CreatorController extends Controller
{
    public function creatorCreatePost()
    {        
        return view('post.create');
    }

    public function creatorCreateMedia()
    {        
        return view('media.create');
    }

    public function creatorStorePost(StorePostRequest $request)
    {
        $post = Post::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'body' => $request->body,
            'price' => $request->price,
            'is_paid' => $request->boolean('is_paid'),
            'visibility' => $request->visibility,
        ]);

        return redirect()->route('creator.media.create', ['post_id' => $post->id])
                     ->with('success', 'Post created! Now upload media.');
    }
}
