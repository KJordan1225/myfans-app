<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Media_1 extends Model
{
    protected $fillable = [
        'post_id',
        'media_type', 
        'path',
        'thumbnail_path',
    ];


    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
