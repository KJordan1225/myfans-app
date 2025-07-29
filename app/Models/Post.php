<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $fillable = [
			'user_id',
            'title',
            'body',
            'price',
            'is_paid',
            'visibility',
		];

    public function profile(): BelongsTo
    {
        return $this->belongsto(User::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }
}
