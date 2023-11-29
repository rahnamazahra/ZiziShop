<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Http\Request;

class CartManagerController extends Controller
{

    public function index()
    {
        return view('site.cart',[
            'cart'  => auth()->user()->cart,
            'addresses' => auth()->user()->addresses,
        ]);

    }

    public function addToCart(Product $product)
    {
        auth()->user()->cart->add($product);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }


    public function updatedAddress(Address $address)
    {
        auth()->user()->cart->address()->associate($address)->push();
    }

    public function vouch(Request $request)
    {
        return auth()->user()->cart->vouch($request->voucher);
    }

    public function destroy(Product $product)
    {
        return auth()->user()->cart->remove($product);
    }

}
