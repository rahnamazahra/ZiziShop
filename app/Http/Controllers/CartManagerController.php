<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Province;
use App\Models\Stock;
use Illuminate\Http\Request;

class CartManagerController extends Controller
{

    public function index()
    {
        return view('site.cart', [
            'cart'      => Cart::current(),
            'addresses' => auth('web')->check() ? auth('web')->user()->addresses : collect(),
            'provinces' => Province::with('cities')->orderBy('name')->get(),
        ]);
    }

    public function addToCart(Request $request, Product $product)
    {
        $stockId = $request->integer('stock') ?: null;
        $qty     = max(1, (int) $request->integer('qty') ?: 1);

        // بررسی موجودیِ تنوع انتخاب‌شده (سایز/رنگ)
        if ($stockId) {
            $stock = Stock::where('product_id', $product->id)->find($stockId);
            if (! $stock || (int) $stock->count < $qty) {
                return $this->fail('این سایز/رنگ به تعداد درخواستی موجود نیست.', $request);
            }
            Cart::current()->addVariant($product, $stock->id, $qty);
        } else {
            if ((int) $product->inventory < $qty) {
                return $this->fail('موجودی کافی نیست.', $request);
            }
            Cart::current()->addVariant($product, null, $qty);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return $this->cartJson();
        }

        return redirect()->back()->with('success', 'محصول به سبد خرید اضافه شد');
    }

    private function fail(string $message, Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['error' => $message], 422);
        }

        return redirect()->back()->with('swal', [
            'title' => 'ناموجود', 'message' => $message, 'icon' => 'warning',
        ]);
    }

    public function increase(Request $request, Product $product)
    {
        Cart::current()->increase($product);

        return $this->cartJson();
    }

    public function decrease(Request $request, Product $product)
    {
        Cart::current()->decrease($product);

        return $this->cartJson();
    }

    public function vouch(Request $request)
    {
        return Cart::current()->vouch($request->voucher);
    }

    public function destroy(Request $request, Product $product)
    {
        Cart::current()->remove($product);

        if ($request->ajax() || $request->wantsJson()) {
            return $this->cartJson();
        }

        return redirect()->back();
    }

    /**
     * JSON snapshot of the cart for AJAX (mini-cart + badge).
     */
    private function cartJson()
    {
        $cart = Cart::current()->fresh('products');

        return response()->json([
            'count'    => $cart->count,
            'subtotal' => $cart->raw_total,
            'total'    => $cart->total,
            'html'     => view('layouts.site.cartmini-content', ['cart' => $cart])->render(),
        ]);
    }
}
