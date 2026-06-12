<?php

namespace App\Http\Controllers;

use App\Enums\CustomOrderStatusEnum;
use App\Models\CustomOrder;
use App\Models\Product;
use Cryptommer\Smsir\Smsir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;

class CustomOrderController extends Controller
{
    /**
     * ثبت سفارش ویژه برای محصول ناموجود (توسط کاربر).
     */
    public function store(Request $request, Product $product)
    {
        $isGuest = ! auth('web')->check();

        $data = $request->validate([
            'description'    => ['required', 'string', 'max:1000'],
            'quantity'       => ['required', 'integer', 'min:1', 'max:1000'],
            'contact_mobile' => ['required', 'string', 'regex:/^09\d{9}$/'],
            // نام برای مهمان الزامی است تا بتوانیم تماس بگیریم
            'contact_name'   => [$isGuest ? 'required' : 'nullable', 'string', 'max:100'],
        ], [], [
            'description'    => 'توضیحات سفارش',
            'quantity'       => 'تعداد',
            'contact_mobile' => 'شماره تماس',
            'contact_name'   => 'نام و نام خانوادگی',
        ]);

        $customOrder = CustomOrder::create([
            'user_id'        => auth('web')->id(),
            'contact_name'   => $data['contact_name'] ?? auth('web')->user()?->name,
            'product_id'     => $product->id,
            'description'    => $data['description'],
            'quantity'       => $data['quantity'],
            'contact_mobile' => $data['contact_mobile'],
            'status'         => CustomOrderStatusEnum::Pending,
        ]);

        $this->notifyAdmin($product, $customOrder);

        $message = $isGuest
            ? 'سفارش ویژه‌ی شما ثبت شد؛ کارشناسان ما برای اعلام قیمت و هماهنگی با شماره‌ی واردشده تماس می‌گیرند.'
            : 'سفارش ویژه‌ی شما ثبت شد؛ پس از بررسی و قیمت‌گذاری توسط کارشناسان ما، امکان پرداخت برای شما فعال می‌شود.';

        $redirect = $isGuest ? redirect()->back() : redirect()->route('account.custom-orders');

        return $redirect->with('swal', [
            'title'   => 'ثبت شد',
            'message' => $message,
            'icon'    => 'success',
        ]);
    }

    /**
     * ارسال پیامک اطلاع‌رسانی سفارش ویژه‌ی جدید به ادمین.
     * شماره از ADMIN_MOBILE در .env خوانده می‌شود؛ در نبود آن، بی‌صدا رد می‌شود.
     */
    private function notifyAdmin(Product $product, CustomOrder $customOrder): void
    {
        $adminMobile = env('ADMIN_MOBILE');
        if (! $adminMobile) {
            return;
        }

        $name = $customOrder->contact_name ?: 'کاربر';
        $message = sprintf(
            'سفارش ویژه جدید — محصول: %s — تعداد: %d — از: %s — شماره: %s. پنل گالری رهنما را بررسی کنید.',
            $product->name,
            $customOrder->quantity,
            $name,
            $customOrder->contact_mobile
        );

        try {
            $lineNumber = config('smsir.line-number') ?: 30007732907923;
            Smsir::Send()->bulk($message, [$adminMobile], null, $lineNumber);
        } catch (\Throwable $e) {
            Log::warning('Admin CustomOrder SMS failed: ' . $e->getMessage());
        }
    }

    /**
     * فهرست سفارش‌های ویژه‌ی کاربر.
     */
    public function index(Request $request)
    {
        return view('site.account.custom-orders', [
            'orders' => CustomOrder::with('product')
                ->where('user_id', $request->user()->id)
                ->latest()
                ->paginate(10),
        ]);
    }

    /**
     * شروع پرداخت سفارش ویژه‌ی تأییدشده.
     */
    public function pay(Request $request, CustomOrder $customOrder)
    {
        abort_unless($customOrder->user_id === $request->user()->id, 403);

        if (! $customOrder->isPayable()) {
            return redirect()->route('account.custom-orders')->with('swal', [
                'title'   => 'قابل پرداخت نیست',
                'message' => 'این سفارش هنوز تأیید و قیمت‌گذاری نشده است.',
                'icon'    => 'warning',
            ]);
        }

        $invoice = (new Invoice)->amount($customOrder->total);

        session(['paying_custom_order' => $customOrder->id]);

        return Payment::callbackUrl(url('custom-order/verify'))
            ->purchase($invoice, function ($driver, $transactionId) use ($customOrder) {
                $customOrder->update(['gateway_ref' => $transactionId]);
            })->pay()->render();
    }

    /**
     * بازگشت از درگاه و نهایی‌سازی سفارش ویژه.
     */
    public function verify(Request $request)
    {
        $customOrder = CustomOrder::find(session('paying_custom_order'));

        if (! $customOrder) {
            return redirect()->route('account.custom-orders')->with('swal', [
                'title'   => 'خطا',
                'message' => 'سفارش مورد نظر یافت نشد.',
                'icon'    => 'error',
            ]);
        }

        try {
            $receipt = Payment::amount($customOrder->total)
                ->transactionId($customOrder->gateway_ref)
                ->verify();

            // جلوگیری از پردازش دوباره‌ی یک پرداخت
            if ($customOrder->isPaid()) {
                session()->forget('paying_custom_order');
                return redirect()->route('account.custom-orders');
            }

            // ساخت سفارش نهایی از روی سفارش ویژه (مستقل از session احراز هویت)
            $order = $customOrder->user->orders()->create([
                'shipping_fee' => 0,
                'total'        => $customOrder->total,
                'address_text' => 'سفارش ویژه (تولید مجدد) - ' . $customOrder->description,
            ]);

            $order->products()->attach($customOrder->product_id, [
                'count' => $customOrder->quantity,
                'price' => $customOrder->unit_price,
            ]);

            $order->payment()->create([
                'user_id'       => $customOrder->user_id,
                'total'         => $customOrder->total,
                'gateway'       => $receipt->getDriver(),
                'tracking_code' => $receipt->getReferenceId(),
            ]);

            $customOrder->update([
                'status'   => CustomOrderStatusEnum::Paid,
                'paid_at'  => now(),
                'order_id' => $order->id,
            ]);

            // پیامک تأیید پرداخت به مشتری
            $mobile = $customOrder->contact_mobile ?: optional($customOrder->user)->mobile;
            if ($mobile) {
                try {
                    $msg = sprintf(
                        'پرداخت سفارش ویژه‌ی شما با موفقیت انجام شد. شماره سفارش: #%d. گالری رهنما در حال آماده‌سازی سفارش شماست.',
                        $order->id
                    );
                    $lineNumber = config('smsir.line-number') ?: 30007732907923;
                    Smsir::Send()->bulk($msg, [$mobile], null, $lineNumber);
                } catch (\Throwable $e) {
                    Log::warning('CustomOrder paid SMS failed: ' . $e->getMessage());
                }
            }

            session()->forget('paying_custom_order');

            return redirect()->route('account.custom-orders')->with('swal', [
                'title'   => 'پرداخت موفق',
                'message' => 'پرداخت شما با موفقیت انجام شد و سفارش ویژه‌ی شما در حال تولید است.',
                'icon'    => 'success',
            ]);

        } catch (InvalidPaymentException $exception) {
            return redirect()->route('account.custom-orders')->with('swal', [
                'title'   => 'پرداخت ناموفق',
                'message' => $exception->getMessage(),
                'icon'    => 'error',
            ]);
        }
    }
}
