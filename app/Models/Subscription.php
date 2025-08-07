<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subscription extends Model
{
    protected $fillable = [
        'subscriber_id',
        'creator_id',
        'stripe_customer_id'.
        'stripe_subscription_id',
        'stripe_status',
        'plan_name',
        'amount',
        'renews_at',
        'interval',
        'product_id',
        'price_id', 
    ];

    public function creator() : BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }    
 
}
