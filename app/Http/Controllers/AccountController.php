<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function orders(Request $request)
    {
        return view('site.account.orders', [
            'orders' => $request->user()->orders()->latest()->get(),
        ]);
    }

    public function orderShow(Request $request, \App\Models\Order $order)
    {
        abort_unless($order->user_id === $request->user()->id, 403);

        $order->load(['products', 'payment', 'user']);

        return view('site.account.order-show', ['order' => $order]);
    }

    public function profile(Request $request)
    {
        $user = $request->user();

        return view('site.account.profile', [
            'user'         => $user,
            'orders'       => $user->orders()->latest()->get(),
            'addresses'    => $user->addresses()->with('city.province')->get(),
            'provinces'    => \App\Models\Province::with('cities')->orderBy('name')->get(),
            'wallet'       => $user->wallet,
            'customOrders' => \App\Models\CustomOrder::with('product')->where('user_id', $user->id)->latest()->get(),
        ]);
    }

    public function addresses(Request $request)
    {
        return view('site.account.addresses', [
            'addresses' => $request->user()->addresses()->with('city.province')->get(),
        ]);
    }

    public function wallet(Request $request)
    {
        return view('site.account.wallet', [
            'wallet' => $request->user()->wallet,
        ]);
    }
}
