<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function checkout()
    {
        // Cart::content()
        $cardContent = [
            [
                'id' => 1,
                'name' => 'Demo Product 1',
                'qty' => 1,
                'price' => 4,
            ],
            [
                'id' => 2,
                'name' => 'Demo Product 2',
                'qty' => 1,
                'price' => 7,
            ],
        ];

        $items= [];
        foreach ($cardContent as $item) {
            $items[] = [
                'price_data' => [
                    'currency' => config('stripe.currency'),
                    'product_data' => [
                        'name' => $item['name']
                    ],
                    'unit_amount' => $item['price'] * 100,
                ],
                'quantity' => $item['qty'],
            ];
        }

        \Stripe\Stripe::setApiKey(config('stripe.secret'));

        $session = \Stripe\Checkout\Session::create([
            'locale' => config('stripe.locale'),
            'payment_method_types' => ['card'],
            'line_items' => $items,
            'mode' => 'payment',
            'success_url' => route('stripe.success'),
            'cancel_url' => route('stripe.cancel'),
        ]);

        return redirect()->away($session->url);
    }

    public function success()
    {
        return view('success');
    }

    public function cancel()
    {
        return view('index');
    }
}
