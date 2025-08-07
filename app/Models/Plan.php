<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'stripe_product_id',
        'stripe_price_id',
        'interval',
        'amount',
    ];

    /**
     * Get the user (creator) that owns the plan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
