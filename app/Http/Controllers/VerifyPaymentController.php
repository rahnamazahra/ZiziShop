<?php

namespace App\Http\Controllers;

use App\Events\NewProductOrderNotificationEvent;
use Illuminate\Http\Request;
use Shetabit\Payment\Facade\Payment;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;

class VerifyPaymentController extends Controller
{

    public function __invoke(Request $request)
    {
        try {
            $cart = $request->user()->cart;

            // مبلغ پرداخت‌شده از طریق درگاه = کل منهای اعتبار کیف پول
            $walletUsed = (int) session('checkout_wallet_used', 0);
            $payable    = max(0, (int) $cart->total - $walletUsed);

            $receipt = Payment::amount($payable)
                ->transactionId($cart->gateway_ref)
                ->verify();

            // خرج‌کردن اعتبار کیف پول استفاده‌شده در این خرید
            $request->user()->wallet->spend($walletUsed);

            $order = \App\Models\Order::createFromCart(
                $request->user(),
                $cart,
                $walletUsed,
                $receipt->getDriver(),
                $receipt->getReferenceId()
            );

            NewProductOrderNotificationEvent::dispatch($order);

            // پاداش کیف پول پس از خرید موفق
            $reward = $request->user()->wallet->reward();
            session()->flash('wallet_reward', $reward);
            session()->forget('checkout_wallet_used');

            $cart->reset();

        } catch (InvalidPaymentException $exception) {
            // return error view
            echo $exception->getMessage();
        }
    }
}
