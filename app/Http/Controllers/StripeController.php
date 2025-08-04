<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Stripe\Stripe;
use Stripe\StripeClient;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;

class StripeController extends Controller
{
    public function showCheckoutForm()
    {
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
        return view('creator.stripe.success');
    }
    
    public function cancel()
    {
        return view('creator.stripe.cancel');
    }
}
