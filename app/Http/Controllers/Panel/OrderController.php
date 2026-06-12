<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\SmsService;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        $orders = Order::with(['user', 'products'])
            ->when($request->filled('search'), function ($q) use ($request) {
                $s = trim($request->search);
                $q->where(function ($w) use ($s) {
                    $w->where('id', $s)
                      ->orWhere('postal_tracking', 'like', "%$s%")
                      ->orWhereHas('user', function ($u) use ($s) {
                          $u->where('name', 'like', "%$s%")->orWhere('mobile', 'like', "%$s%");
                      });
                });
            })
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('panel.orders.index', ['orders' => $orders]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        $order = Order::with(['user', 'products', 'payment'])->findOrFail($id);

        // اگر این سفارش نوتیفیکیشن خوانده‌نشده دارد، خوانده‌شده علامت بزن
        $notification = auth()->user()->notifications
            ->first(fn ($item) => ($item->data['order_id'] ?? null) == $id);

        if ($notification && ! $notification->read_at) {
            $notification->markAsRead();
        }

        return view('panel.orders.show', ['order' => $order]);
    }

    public function edit(string $id)
    {
        return to_route('admin.orders.show', $id);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'postal_tracking' => ['nullable', 'string', 'max:50'],
        ]);

        $order = Order::with('user')->findOrFail($id);
        $order->update(['postal_tracking' => $data['postal_tracking'] ?? null]);

        if (! empty($data['postal_tracking']) && optional($order->user)->mobile) {
            (new SmsService)->orderShipped($order->user->mobile, $order->id, $data['postal_tracking']);
        }

        return to_route('admin.orders.show', $id)->with('swal', [
            'title'   => 'ثبت شد',
            'message' => 'کد رهگیری ثبت و پیامک به مشتری ارسال شد.',
            'icon'    => 'success',
        ]);
    }

    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        $order->products()->detach();
        $order->payment()?->delete();
        $order->delete();

        return to_route('admin.orders.index')->with('swal', [
            'title'   => 'حذف شد',
            'message' => 'سفارش #' . $id . ' حذف شد.',
            'icon'    => 'success',
        ]);
    }
}
