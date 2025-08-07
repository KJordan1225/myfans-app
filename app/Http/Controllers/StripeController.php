<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\StripeClient;
use Stripe\PaymentIntent;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Auth;
use SweetAlert2\Laravel\Swal;

class StripeController extends Controller
{
    public function showCheckoutForm()
    {
        if (auth()->check() 
		&& auth()->user()->profile->is_creator
		&& !auth()->user()->profile->processing_paid) {

            Swal::warning([
                'title' => 'Alert!!',
                'html' => 'You have not paid your processing fee<br>' .
                            '<strong>Please do so now!</strong>',
                'icon' => 'warning',
                'confirmButtonText' => 'Thank You.'
            ]);
        } 

        if (auth()->check() 
		    && auth()->user()->profile->is_creator
		    && auth()->user()->profile->processing_paid) {  

                Swal::warning([
                    'title' => 'Warning!',
                    'html' => 'You have already paid your life-time processing fee.<br>'.
                            'Please do nothing further AND leave this page<br>'.
                            'before you are charged again!',
                    'showConfirmButton' => true,
                    'icon' => 'warning',
                    'confirmButtonText' => 'Continue',
                ]);
        }
        return view('creator.stripe.checkout');
    }

    public function processCheckout(Request $request)
    {
        $stripe = new StripeClient(config('services.stripe.secret'));

        // For this example, we'll use a fixed price and product.
        // In a real application, this would come from your database.
        $productName = 'Creator Processing Fee';
        $productPrice = 500; // $5.00 in cents

        try {
            $session = $stripe->checkout->sessions->create([
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $productName,
                        ],
                        'unit_amount' => $productPrice,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('creator.stripe.success'),
                'cancel_url' => route('creator.stripe.cancel'),
            ]);

            return redirect()->away($session->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }
    
    public function success()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $userProfile = UserProfile::where('user_id', $user_id)->first();
        $userProfile->processing_paid = true;
        $userProfile->save();

        $user->assignRole('creator');

        return view('creator.stripe.success');
    }
    
    public function cancel()
    {
        return view('creator.stripe.cancel');
    }
}
