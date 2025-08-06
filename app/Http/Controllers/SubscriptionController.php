<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\StripeClient;
use Stripe\Customer;
use Stripe\Subscription;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function create()
    {
        // This view would contain the form from Step 2
        return view('subscriptions.payment-form');
    }

    public function store(Request $request)
    {
        $user_profile = Auth::user()->profile;
        $user = Auth::user();        
        $stripe = new StripeClient(config('services.stripe.secret'));
        $paymentMethodId = $request->input('payment_method');

        // Step 1: Create or Retrieve Stripe Customer
        if (!$user_profile->stripe_id) {
            $customer = $stripe->customers->create([
                'email' => $user->email,
                'name' => $user->name,
                'payment_method' => $paymentMethodId,
                'invoice_settings' => ['default_payment_method' => $paymentMethodId],
            ]);
            $user_profile->stripe_id = $customer->id;
            $user_profile->save();
        } else {
            // Retrieve an existing customer
            $customer = $stripe->customers->retrieve($user_profile->stripe_id);
            // Attach the new payment method if it's different
            $stripe->paymentMethods->attach($paymentMethodId, ['customer' => $customer->id]);
            $stripe->customers->update($customer->id, ['invoice_settings' => ['default_payment_method' => $paymentMethodId]]);
        }
        
        // Step 2: Create the Subscription
        // You would get the price ID from your Stripe Dashboard
        $priceId = 'price_1RstRpQZCbgkEnB4F3fC5n6v';

        try {
            $stripe->subscriptions->create([
                'customer' => $user_profile->stripe_id,
                'items' => [['price' => $priceId]],
                'expand' => ['latest_invoice.payment_intent'],
            ]);

            // Update your user's subscription status in your database
            // (e.g., User->is_subscribed = true)

            return redirect()->route('dashboard')->with('success', 'Subscription created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Subscription failed: ' . $e->getMessage());
        }
    }
}
