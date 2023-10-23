<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\VoucherStoreRequest;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{

    public function index()
    {
        return view('panel.vouchers.index', [
            'vouchers' => Voucher::paginate(10),
        ]);
    }


    public function create()
    {
        return view('panel.vouchers.create');
    }


    public function store(Request $request)
    {
        Voucher::create($request->all());
        return to_route('admin.vouchers.index');
    }

    public function edit(Voucher $voucher)
    {
       return view('panel.vouchers.edit',[
        'voucher' => $voucher,
       ]);
    }

    public function update(Request $request,Voucher $voucher)
    {
        $voucher->update($request->all());
        return to_route('admin.vouchers.index');
    }

    public function destroy(Voucher $voucher)
    {
       $voucher->delete();
       return to_route('admin.vouchers.index');
    }
}
