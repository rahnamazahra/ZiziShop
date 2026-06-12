<?php

namespace App\Http\Controllers;

use App\Events\NewProductOrderNotificationEvent;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Shetabit\Payment\Facade\Payment;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;

class VerifyPaymentController extends Controller
{

    public function __invoke(Request $request)
    {
        try {
            $user = $request->user();
            $cart = $user->cart;

            // اگر سبد خرید دیگر gateway_ref ندارد، سفارش قبلاً پردازش شده (refresh صفحه)
            if (! $cart->gateway_ref) {
                return redirect()->route('account.orders')->with('swal', [
                    'title'   => 'سفارش ثبت شده',
                    'message' => 'سفارش شما قبلاً با موفقیت ثبت شده است.',
                    'icon'    => 'info',
                ]);
            }

            // مبلغ پرداخت‌شده از طریق درگاه = کل منهای اعتبار کیف پول
            $walletUsed = (int) session('checkout_wallet_used', 0);
            $payable    = max(0, (int) $cart->total - $walletUsed);

            $receipt = Payment::amount($payable)
                ->transactionId($cart->gateway_ref)
                ->verify();

            // خرج کیف پول + ثبت سفارش در یک تراکنش (با قفل موجودی)
            $order = DB::transaction(function () use ($user, $cart, $walletUsed, $receipt) {
                $user->wallet->spend($walletUsed);
                return Order::createFromCart(
                    $user,
                    $cart,
                    $walletUsed,
                    $receipt->getDriver(),
                    $receipt->getReferenceId()
                );
            });

            NewProductOrderNotificationEvent::dispatch($order);

            // پاداش کیف پول پس از خرید موفق
            $reward = $user->wallet->reward();
            session()->flash('wallet_reward', $reward);
            session()->forget('checkout_wallet_used');

            $cart->reset();

            return redirect()->route('account.orders')->with('swal', [
                'title'   => 'پرداخت موفق',
                'message' => 'سفارش شما با موفقیت ثبت شد.',
                'icon'    => 'success',
            ]);

        } catch (\RuntimeException $e) {
            return redirect()->route('cart.index')->with('swal', [
                'title'   => 'موجودی ناکافی',
                'message' => $e->getMessage(),
                'icon'    => 'warning',
            ]);
        } catch (InvalidPaymentException $exception) {
            return redirect()->route('cart.index')->with('swal', [
                'title'   => 'خطای پرداخت',
                'message' => $exception->getMessage(),
                'icon'    => 'error',
            ]);
        }
    }
}
