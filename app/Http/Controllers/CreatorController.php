<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Media\StoreMediaRequest;

class CreatorController extends Controller
{
    public function creatorCreatePost()
    {        
        return view('post.create');
    }

    public function creatorCreateMedia()
    {
        $post_id = request()->query('post_id');
        return view('media.create', compact('post_id'));
    }

    public function creatorListMedia()
    {
        $post_id = request()->query('post_id');
        $media = Media::where('post_id', $post_id)->latest()->get();
        return view('media.list', compact('post_id', 'media'));
    }

    public function listAuthUserPosts()
    {
        $posts = Auth::user()->posts()->latest()->get();
        return view('post.list', compact('posts'));        
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

    public function creatorStoreMedia(StoreMediaRequest $request)
    {
       
        // Determine correct folder based on type
        $folder = $request->media_type === 'video' ? 'media/videos' : 'media/images';

        // Store the main media file
        $mediaPath = $request->file('path')->store($folder, 'public');

        // Optional thumbnail for videos or preview image
        $thumbnailPath = $request->hasFile('thumbnail_path')
            ? $request->file('thumbnail_path')->store('media/thumbnails', 'public')
            : null;

        // ✅ Create database record
        Media::create([
            'post_id'        => $request->post_id,
            'media_type'     => $request->media_type,
            'path'           => $mediaPath,
            'thumbnail_path' => $thumbnailPath,
        ]);

        // ✅ Redirect to media listing page
        return redirect()->route('creator.media.list', ['post_id' => $request->post_id])
                        ->with('success', 'Media uploaded successfully!');
    }
}

 
