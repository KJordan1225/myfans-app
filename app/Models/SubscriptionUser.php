<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionUser extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'subscription_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'subscription_id',
        'subscriber_id',
    ];

    /**
     * Get the subscription that owns the SubscriptionUser.
     */
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    /**
     * Get the subscriber (user) that owns the SubscriptionUser.
     */
    public function subscriber()
    {
        return $this->belongsTo(User::class, 'subscriber_id');
    }
}
