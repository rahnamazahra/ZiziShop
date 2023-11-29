<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Payment\Facade\Payment;

class VerifyPaymentController extends Controller
{

    public function __invoke(Request $request)
    {
        try {
            $cart = $request->user()->cart;
            $receipt = Payment::amount($cart->total)
                ->transactionId($cart->gateway_ref)
                ->verify();

            $order = $request->user()->orders()->create([
                'voucher_id' => $cart->voucher_id,
                'shipping_fee' => 3500,
                'total' => $cart->total,
                'address_text' => 'sss'
            ]);

            $cart->products->each(function ($product) use ($order) {
                $order->products()->attach($product, [
                    'count' => $product->pivot->count,
                    'price' => $product->price,
                ]);
            });

            $order->payment()->create([
                'user_id' => $request->user()->id,
                'total' => $cart->total,
                'gateway' => $receipt->getDriver(),
                'tracking_code' => $receipt->getReferenceId(),
            ]);

            $cart->reset();

        } catch (InvalidPaymentException $exception) {
            // return error view
            echo $exception->getMessage();
        }
    }
}
