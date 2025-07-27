<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
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
}
