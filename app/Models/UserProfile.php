<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Enums\Fit; // medialibrary v10+
use Illuminate\Http\Request;

class UserProfile extends Model implements HasMedia
{
    use InteractsWithMedia;

    // Table name is optional if it matches the plural form of the model
    protected $table = 'user_profiles';

    // Mass assignable attributes
    protected $fillable = [
        'user_id',
        'display_name',
        'bio',
        'avatar',
        'banner',
        'website',
        'twitter',
        'instagram',
        'is_creator',
        'processing_paid',
        'stripe_id',
        'balance',
    ];

    // Cast fields to appropriate types
    protected $casts = [
        'is_creator' => 'boolean',
        'balance' => 'decimal:2',
    ];

    /**
     * Get the user that owns this profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    
    // ─────────────────────────────────────────────────────────────
    // Media Collections
    // ─────────────────────────────────────────────────────────────
    public function registerMediaCollections(): void
    {
        // Avatar: single file, on 'public' disk, only images
        $this->addMediaCollection('avatar')
            ->useDisk('public')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
            ->singleFile()
            ->withResponsiveImages();

        // Banner: single file, on 'public' disk, only images
        $this->addMediaCollection('banner')
            ->useDisk('public')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
            ->singleFile()
            ->withResponsiveImages();
    }

}
