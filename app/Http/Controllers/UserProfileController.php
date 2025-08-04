<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
	/**
	 * User Profile functions.
	 * Accessible by users w/creator privileges
	 */


    /**
     * Display a listing of the profile of authenticated user.
     */
    public function index()
    {
        $user = Auth::user();

        $profile = $user->profile; // assumes hasOne('UserProfile') relationship

        if ($profile) {
            return redirect()->route('user-profiles.edit', $profile->id);
        } else {
            return redirect()->route('user-profiles.create');
        }
    }

    /**
     * Show the form for creating a new user profile.
     */
    public function create()
    {
        return view('user-profile.create');
    }

    /**
     * Store a newly created user profile in database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'display_name' => 'required|string|max:255',
            'bio'          => 'nullable|string',
            'avatar'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'website'      => 'nullable|url|max:255',
            'twitter'      => 'nullable|string|max:255',
            'instagram'    => 'nullable|string|max:255',
            'is_creator'   => 'sometimes|boolean',
        ]);

        $user = Auth::user();

        // Prevent duplicate profiles
        if ($user->userProfile) {
            return redirect()->route('user-profiles.edit', $user->userProfile)
                            ->with('warning', 'You already have a profile.');
        }

        $avatarPath = $request->hasFile('avatar')
            ? $request->file('avatar')->store('avatars', 'public')
            : null;

        $bannerPath = $request->hasFile('banner')
            ? $request->file('banner')->store('banners', 'public')
            : null;

        $profile = UserProfile::create([
            'user_id'      => $user->id,
            'display_name' => $request->input('display_name'),
            'bio'          => $request->input('bio'),
            'avatar'       => $avatarPath,
            'banner'       => $bannerPath,
            'website'      => $request->input('website'),
            'twitter'      => $request->input('twitter'),
            'instagram'    => $request->input('instagram'),
            'is_creator'   => $request->has('is_creator'),
            'stripe_id'    => null,
            'balance'      => 0,
        ]);

        return redirect()->route('dashboard')
			->with('success', 'Profile created successfully!');
        
    }

    /**
     * Display the specified user profile record.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified user profile.
     */
    public function edit(string $id)
    {
        $profile = UserProfile::find($id);

        if (!$profile) {
            return redirect()->route('dashboard')->with('error', 'Profile not found.');
        }

        return view('user-profile.edit', compact('profile'));
    }

    /**
     * Update the specified user profile in the database.
     */
    public function update(Request $request, string $id)
    {
        $userProfile = UserProfile::find($id);

        $validated = $request->validate([
            'display_name' => 'required|string|max:255',
            'bio'          => 'nullable|string',
            'avatar'       => 'sometimes|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner'       => 'sometimes|image|mimes:jpg,jpeg,png,webp|max:4096',
            'website'      => 'nullable|url|max:255',
            'twitter'      => 'nullable|string|max:255',
            'instagram'    => 'nullable|string|max:255',
            'is_creator'   => 'sometimes|boolean',
        ]);

        // Handle avatar replacement
        if ($request->hasFile('avatar')) {
            if ($userProfile->avatar && Storage::disk('public')->exists($userProfile->avatar)) {
                Storage::disk('public')->delete($userProfile->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        // Handle banner replacement
        if ($request->hasFile('banner')) {
            if ($userProfile->banner && Storage::disk('public')->exists($userProfile->banner)) {
                Storage::disk('public')->delete($userProfile->banner);
            }
            $validated['banner'] = $request->file('banner')->store('banners', 'public');
        }

        // Handle checkbox for is_creator
        $validated['is_creator'] = $request->has('is_creator');

        $userProfile->update($validated);

        // check if processing fee has been paid
        if ($userProfile->is_creator && !$userProfile->processing_paid){
            return redirect()
            ->route('creator.stripe.checkout');
        }

        return redirect()
            ->route('user-profiles.edit', $userProfile)
            ->with('success', 'Profile updated successfully.'); 
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Show a public user profile based on their @username.
     */
    public function showByUsername(string $username)
    {
        // Strip the '@' if it exists
        $username = ltrim($username, '@');
        
        // Find the user by username or return 404
        $user = User::where('username', $username)->firstOrFail();

        // Load the related UserProfile (assuming hasOne relationship)
        $profile = $user->userProfile;

        // Optionally load other data: posts, subscriptions, etc.

        return view('profiles.public', [
            'user'    => $user,
            'profile' => $profile,
        ]);
    }
}
