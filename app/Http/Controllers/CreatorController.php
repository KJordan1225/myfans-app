<?php

namespace App\Http\Controllers;

use Stripe\Price;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Product;
use App\Models\Plan;
use App\Models\Post;
use App\Models\Media;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Media\StoreMediaRequest;


class CreatorController extends Controller
{
    /*************************
	 * Post related functions accessible
	 * by users w/ creator privileges
	 *
	 **************************/
	 
	 /*************************
	 * Display create post blade
	 *
	 **************************/
	
	public function creatorCreatePost()
    {        
        return view('post.create');
    }
	
	/*************************
	 * List all posts owned by
	 * authenticated user
	 **************************/
	 
	public function listAuthUserPosts()
    {
        $posts = Auth::user()->posts()->latest()->get();
        return view('post.list', compact('posts'));        
    }
	
	/*************************
	 * Store input from create posts blade
	 * into database
	 **************************/
	
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
	
	
	/***********************************
     * Show the form for editing the specified post.
     ************************************/
	 
    public function creatorEditPost(Post $post)
    {
        // The $post variable is an instance of the Post model.
        // It has been automatically fetched from the database by Laravel.
        return view('post.edit', compact('post'));
    }
	
	
	
	

	/*************************
	 * Media related functions accessible
	 * by users w/ creator privileges
	 *
	 **************************/
	 
	/*************************
	 * Display create media blade
	 *
	 **************************/

    public function creatorCreateMedia()
    {
        $post_id = request()->query('post_id');
        return view('media.create', compact('post_id'));
    }
	
	/*************************
	 * Display all media associated with
	 * a particular post
	 **************************/

    public function creatorListMedia()
    {
        $post_id = request()->query('post_id');
        $media = Media::where('post_id', $post_id)->latest()->get();
        return view('media.list', compact('post_id', 'media'));
    }

    /*************************
	 * Store input from create media blade
	 * into database
	 **************************/    

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

    // Creator Subscription related functions

    public function creatorCreateSubscription()
    {        
        return view('creator.subscription.create');
    }

    public function creatorStoreSubscription(Request $request)
    {
        
        // $request->creator_id = Auth::id();
        // $request->subscriber_id = 1;

        // $validated = $request->validate([            
        //     'plan_name' => 'nullable|string',
        //     'amount' => 'nullable|numeric|min:1',
        //     'renews_at' => 'nullable|date',
        //     'interval' => 'required|in:day,week,month,year',
        //     'product_id' => 'nullable|string',
        //     'prices' => 'required|array|min:1',
        //     'prices.*.amount' => 'required|numeric|min:1',
        //     'prices.*.interval' => 'required|in:day,week,month,year',
       
        // ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            // 1. Create a single product
            $product = Product::create([
                'name' => $request->plan_name,
            ]);

            // 2. Create multiple prices
            $price_ids = [];

            foreach ($request->prices as $plan) {
                $price = Price::create([
                    'unit_amount' => $plan['amount'] * 100, // cents
                    'currency' => 'usd',
                    'recurring' => [
                        'interval' => $plan['interval']
                    ],
                    'product' => $product->id,
                ]);

                $price_ids[] = [
                    'interval' => $plan['interval'],
                    'price_id' => $price->id,
                ];

                Plan::create([
                    'user_id' => Auth::id(), // creator’s ID
                    'stripe_product_id' => $product->id,
                    'stripe_price_id' => $price->id,
                    'interval' => $plan['interval'],
                    'amount' => $plan['amount'],
                ]);
            }

            // return response()->json([
            //     'message' => 'Product with multiple plans created.',
            //     'product_id' => $product->id,
            //     'price_ids' => $price_ids,
            // ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        $subscription = new Subscription();

        $subscription->subscriber_id = 1;;
        $subscription->creator_id = Auth::id();
        // $subscription->stripe_customer_id = 'cus_ABC123';
        // $subscription->stripe_subscription_id = 'sub_XYZ456';
        // $subscription->stripe_status = 'active';
        $subscription->plan_name = $request->plan_name;
        $subscription->amount = $request->amount;
        $subscription->interval = $request->interval;

        switch ($subscription->interval) {
            case 'day':
                $subscription->renews_at = Carbon::now()->addDays(1);
                break;

            case 'week':
                $subscription->renews_at = Carbon::now()->addDays(7);
                break;

            case 'month':
                $subscription->renews_at = Carbon::now()->addDays(30);
                break;

            case 'year':
                $subscription->renews_at = Carbon::now()->addDays(365);
                break;

            default:
                $subscription->renews_at = Carbon::now()->addDays(0);
                break;
        }

        $subscription->product_id = $product->id;
        $subscription->price_id = $price->id;

        // $subscription->save(); // inserts into the database

        return redirect()->route('creator.subscription.create')->with('success', 'Subscription created.');
    }
   
    
}

 
