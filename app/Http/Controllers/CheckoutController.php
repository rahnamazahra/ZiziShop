<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

class CheckoutController extends Controller
{
    public function __invoke(Request $request)
    {
        $cart = $request->user()->cart;

        if (! $cart->address_id) {
            return redirect()->route('cart.index')->with('swal', [
                'title'   => 'آدرس لازم است',
                'message' => 'لطفاً ابتدا اطلاعات و آدرس ارسال را وارد کنید.',
                'icon'    => 'warning',
            ]);
        }

        if ($cart->products->isEmpty()) {
            return redirect()->route('cart.index')->with('swal', [
                'title'   => 'سبد خرید خالی است',
                'message' => 'سبد خرید شما خالی است.',
                'icon'    => 'warning',
            ]);
        }

        // بررسی موجودی پیش از هدایت به درگاه — از ارسال کاربر به بانک با موجودی صفر جلوگیری می‌کند
        foreach ($cart->products as $product) {
            $needed = (int) $product->pivot->count;

            if ((int) $product->inventory < $needed) {
                return redirect()->route('cart.index')->with('swal', [
                    'title'   => 'موجودی ناکافی',
                    'message' => "متأسفانه موجودی محصول «{$product->name}» به پایان رسیده یا کافی نیست. لطفاً سبد خرید را بررسی کنید.",
                    'icon'    => 'warning',
                ]);
            }

            if ($product->pivot->stock_id) {
                $stock = Stock::find($product->pivot->stock_id);
                if ($stock && (int) $stock->count < $needed) {
                    return redirect()->route('cart.index')->with('swal', [
                        'title'   => 'موجودی ناکافی',
                        'message' => "تنوع انتخابی از محصول «{$product->name}» به اتمام رسیده. لطفاً تنوع دیگری انتخاب کنید.",
                        'icon'    => 'warning',
                    ]);
                }
            }
        }

        $user = $request->user();

        // استفاده از اعتبار کیف پول به‌عنوان تخفیف
        $walletUsed = min($user->wallet->usableBalance(), (int) $cart->total);
        $payable    = (int) $cart->total - $walletUsed;
        session(['checkout_wallet_used' => $walletUsed]);

        // اگر کیف پول کل مبلغ را پوشش دهد، بدون درگاه نهایی می‌شود
        if ($payable <= 0) {
            try {
                $order = DB::transaction(function () use ($user, $cart, $walletUsed) {
                    $user->wallet->spend($walletUsed);
                    return Order::createFromCart($user, $cart, $walletUsed, 'wallet', 'WALLET-' . uniqid());
                });
            } catch (\RuntimeException $e) {
                return redirect()->route('cart.index')->with('swal', [
                    'title'   => 'موجودی ناکافی',
                    'message' => $e->getMessage(),
                    'icon'    => 'warning',
                ]);
            }

            \App\Events\NewProductOrderNotificationEvent::dispatch($order);

            $reward = $user->wallet->reward();
            session()->flash('wallet_reward', $reward);
            session()->forget('checkout_wallet_used');
            $cart->reset();

            return redirect()->route('account.orders')->with('swal', [
                'title'   => 'پرداخت موفق',
                'message' => 'سفارش شما به‌طور کامل با اعتبار کیف پول ثبت شد.',
                'icon'    => 'success',
            ]);
        }

        $invoice = (new Invoice)->amount($payable);

        return Payment::callbackUrl(url('verify'))
            ->purchase($invoice, function($driver, $transactionId) use ($request) {
                $request->user()->cart->update(['gateway_ref' => $transactionId]);
            })->pay()->render();

    }
}
