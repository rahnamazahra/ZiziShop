<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        return view("panel.orders.index",[
            'orders' => Order::orderByDesc('created_at')->paginate(15),
        ]);
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
        $notification = auth()->user()->notifications
            ->first(function ($item) use ($id) {
                return $item->data['order_id'] == $id;
            });


        if ($notification && !$notification->read_at) {
            $notification->markAsRead();
        }

        return to_route('admin.orders.index');
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
