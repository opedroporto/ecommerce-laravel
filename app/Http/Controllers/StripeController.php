<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function checkout(Request $request) {

        // set Stripe API key
        \Stripe\Stripe::setApiKey(config("stripe.pk"));

        // get cart items
        $items = \Cart::getContent();

        // generate payment items
        $line_items = [];
        foreach ($items as $item) {
            $item_price = $item->price * 100;

            $line_items[] = [
                "price_data" => [
                    "currency" => "brl",
                    "product_data" => [
                        "name" => $item->name
                    ],
                    "unit_amount" => $item_price
                ],
                "quantity" => $item->quantity
            ];
        }

        // create checkout session
        $session = \Stripe\Checkout\Session::create([
            "line_items" => $line_items,
            "mode" => "payment",
            "success_url" => route("site.success"),
            "cancel_url" => route("site.index")
        ]);

        return redirect()->away($session->url);

    }

    public function success() {
        \Cart::clear();

        return view("site.index");
    }
}
