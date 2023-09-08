<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Pedido;

use Illuminate\Http\Request;

use App\CarrinhoCompras;


class StripeController extends Controller
{
    public function checkout(Request $request) {

        // set Stripe API key
        \Stripe\Stripe::setApiKey(config("stripe.pk"));

        // get items
        $items = Item::with("produto")->where("id_pedido", $request->id)->get()->all();

        // generate payment items
        $line_items = [];

        foreach ($items as $item) {
            $item_price = $item->price * 100;

            $line_items[] = [
                "price_data" => [
                    "currency" => "brl",
                    "product_data" => [
                        "name" => $item->nome
                    ],
                    "unit_amount" => $item->produto->valor * 100    
                ],
                "quantity" => $item->quantidade
            ];
        }

        $pedido = Pedido::whereId($request->id)->get()->first();
        if ($pedido['entrega']) {
            $line_items[] = [
                "price_data" => [
                    "currency" => "brl",
                    "product_data" => [
                        "name" => "Adicional de montagem"
                    ],
                    "unit_amount" => CarrinhoCompras::getAdditional() * 100
                ],
                "quantity" => 1
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

    public function webhook() {
        // require_once '../vendor/autoload.php';
        // require_once '../secrets.php';

        // \Stripe\Stripe::setApiKey($stripeSecretKey);
        // // Replace this endpoint secret with your endpoint's unique secret
        // // If you are testing with the CLI, find the secret by running 'stripe listen'
        // // If you are using an endpoint defined with the API or dashboard, look in your webhook settings
        // // at https://dashboard.stripe.com/webhooks
        // $endpoint_secret = 'whsec_...';

        // $payload = @file_get_contents('php://input');
        // $event = null;

        // try {
        // $event = \Stripe\Event::constructFrom(
        //     json_decode($payload, true)
        // );
        // } catch(\UnexpectedValueException $e) {
        // // Invalid payload
        // echo '⚠️  Webhook error while parsing basic request.';
        // http_response_code(400);
        // exit();
        // }
        // if ($endpoint_secret) {
        // // Only verify the event if there is an endpoint secret defined
        // // Otherwise use the basic decoded event
        // $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        // try {
        //     $event = \Stripe\Webhook::constructEvent(
        //     $payload, $sig_header, $endpoint_secret
        //     );
        // } catch(\Stripe\Exception\SignatureVerificationException $e) {
        //     // Invalid signature
        //     echo '⚠️  Webhook error while validating signature.';
        //     http_response_code(400);
        //     exit();
        // }
        // }

        // // Handle the event
        // switch ($event->type) {
        // case 'payment_intent.succeeded':
        //     $paymentIntent = $event->data->object; // contains a \Stripe\PaymentIntent
        //     // Then define and call a method to handle the successful payment intent.
        //     // handlePaymentIntentSucceeded($paymentIntent);
        //     break;
        // case 'payment_method.attached':
        //     $paymentMethod = $event->data->object; // contains a \Stripe\PaymentMethod
        //     // Then define and call a method to handle the successful attachment of a PaymentMethod.
        //     // handlePaymentMethodAttached($paymentMethod);
        //     break;
        // default:
        //     // Unexpected event type
        //     error_log('Received unknown event type');
        // }

        // http_response_code(200);
    }
}
