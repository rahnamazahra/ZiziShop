<?php

namespace App\Http\Controllers\Panel;

use App\Enums\CustomOrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\CustomOrder;
use Cryptommer\Smsir\Smsir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomOrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = CustomOrder::with(['product', 'user'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15);

        return view('panel.custom-orders.index', [
            'orders'   => $orders,
            'statuses' => CustomOrderStatusEnum::cases(),
        ]);
    }

    public function show(CustomOrder $customOrder)
    {
        $customOrder->load(['product.images', 'user.addresses.city.province']);

        return view('panel.custom-orders.show', [
            'order' => $customOrder,
        ]);
    }

    /**
     * تأیید و قیمت‌گذاری سفارش ویژه؛ پس از این، پرداخت برای کاربر فعال می‌شود.
     */
    public function approve(Request $request, CustomOrder $customOrder)
    {
        $data = $request->validate([
            'unit_price' => ['required', 'integer', 'min:1000'],
            'admin_note' => ['nullable', 'string', 'max:1000'],
        ], [], [
            'unit_price' => 'قیمت واحد',
            'admin_note' => 'یادداشت',
        ]);

        $customOrder->update([
            'status'     => CustomOrderStatusEnum::Approved,
            'unit_price' => $data['unit_price'],
            'admin_note' => $data['admin_note'] ?? null,
        ]);

        $this->sendStatusSms(
            $customOrder,
            'سفارش ویژه‌ی شما تأیید شد. مبلغ قابل پرداخت: '
                . number_format($customOrder->total) . ' تومان. برای پرداخت به حساب کاربری خود مراجعه کنید. گالری رهنما'
        );

        return to_route('admin.custom-orders.index')->with('swal', [
            'title'   => 'تأیید شد',
            'message' => 'سفارش ویژه تأیید و قیمت‌گذاری شد و پیامک اطلاع‌رسانی ارسال شد. اکنون کاربر می‌تواند پرداخت را انجام دهد.',
            'icon'    => 'success',
        ]);
    }

    /**
     * رد سفارش ویژه با درج دلیل.
     */
    public function reject(Request $request, CustomOrder $customOrder)
    {
        $data = $request->validate([
            'admin_note' => ['required', 'string', 'max:1000'],
        ], [], [
            'admin_note' => 'دلیل رد سفارش',
        ]);

        $customOrder->update([
            'status'     => CustomOrderStatusEnum::Rejected,
            'admin_note' => $data['admin_note'],
        ]);

        $this->sendStatusSms(
            $customOrder,
            'سفارش ویژه‌ی شما متأسفانه امکان‌پذیر نشد. دلیل: ' . $data['admin_note'] . ' گالری رهنما'
        );

        return to_route('admin.custom-orders.index')->with('swal', [
            'title'   => 'رد شد',
            'message' => 'سفارش ویژه رد شد و پیامک اطلاع‌رسانی ارسال شد.',
            'icon'    => 'info',
        ]);
    }

    /**
     * ارسال پیامک وضعیت سفارش ویژه به شماره‌ی تماس کاربر.
     * در صورت نبود تنظیمات پیامک، خطا فقط لاگ می‌شود و جریان ادامه می‌یابد.
     */
    protected function sendStatusSms(CustomOrder $customOrder, string $message): void
    {
        $mobile = $customOrder->contact_mobile ?: optional($customOrder->user)->mobile;

        if (! $mobile) {
            return;
        }

        try {
            $lineNumber = config('smsir.line-number') ?: 30007732907923;
            Smsir::Send()->bulk($message, [$mobile], null, $lineNumber);
        } catch (\Throwable $e) {
            Log::warning('CustomOrder SMS failed: ' . $e->getMessage());
        }
    }
}
