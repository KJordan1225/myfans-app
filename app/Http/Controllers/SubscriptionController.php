<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\StripeClient;
use Stripe\Customer;
use Stripe\Subscription;
use Illuminate\Support\Facades\Auth;
use App\Models\Plan;
use Stripe\Stripe;
use Stripe\PaymentMethod;
use App\Models\User;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    public function showPlans(User $creator)
    {
        $plans = Plan::where('user_id', $creator->id)->get();

        return view('subscriptions.choose-plan', [
            'creator' => $creator,
            'plans' => $plans,
            'stripeKey' => config('services.stripe.key'), // public key
        ]);
    }
    
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


    public function subscribe(Request $request)
    {
        $request->validate([
            'price_id' => 'required|string|exists:plans,stripe_price_id',
            'payment_method' => 'required|string',
        ]);


        $plan = Plan::where('stripe_price_id', $request->price_id)->firstOrFail();

        $user = Auth::user();
        $userProfile = $user->profile; // assuming you have a profile with stripe_id

        Stripe::setApiKey(config('services.stripe.secret'));

        // 1. Create or retrieve customer
        if (!$userProfile->stripe_id) {
            
            $customer = Customer::create([
                'email' => $user->email,
                'name' => $user->name,
                'payment_method' => $request->payment_method,
                'invoice_settings' => [
                    'default_payment_method' => $request->payment_method,
                ],
            ]);
            $userProfile->stripe_id = $customer->id;
            $userProfile->save();
        } else {
            
            $customer = Customer::retrieve($userProfile->stripe_id);           

            $paymentMethod = \Stripe\PaymentMethod::retrieve($request->payment_method);

            try {
                // 1. Retrieve the PaymentMethod
                $paymentMethodId = $request->payment_method; 
                $paymentMethod = \Stripe\PaymentMethod::retrieve($paymentMethodId);

                // 2. Attach the PaymentMethod to a Customer
                $customerId = $customer->id; 
                $paymentMethod->attach(['customer' => $customerId]);

            } catch (\Stripe\Exception\ApiErrorException $e) {
                echo "Error attaching PaymentMethod: " . $e->getMessage();
            }

            // 3. Set it as default
            Customer::update($customer->id, [
                'invoice_settings' => [
                    'default_payment_method' => $request->payment_method,
                ],
            ]);
        }

        
        // Create subscription
        $subscription = Subscription::create([
            'customer' => $customer->id,
            'items' => [['price' => $plan->stripe_price_id]],
            'expand' => ['latest_invoice.payment_intent'],
        ]);

        // 3. Optionally store subscription details
        \DB::table('subscriptions')->insert([
            'subscriber_id' => $user->id,
            'creator_id' => $plan->user_id,
            'stripe_customer_id' => $customer->id,
            'stripe_subscription_id' => $subscription->id,
            'stripe_status' => $subscription->status,
            'plan_name' => ucfirst($plan->interval),
            'amount' => $plan->amount,
            'renews_at' => now()->add($plan->interval, 1),
            'interval' => $plan->interval,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Subscription created successfully.');
    }
}
