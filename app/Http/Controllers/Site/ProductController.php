<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    public function index()
    {
        return view('site.home');
    }


    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)->first();

        $relatedProducts = Product::with(['category'])
            ->where('category_id', $product->category->id)
            ->take(15)
            ->get();

        return view('site.product-details', ['product' => $product, 'relatedProducts' => $relatedProducts]);
    }

    public function addComment(Request $request, Product $product)
    {
        $user = auth()->user();
        $user->ratings()->create([
            'rating' => 5,
            'comment' => $request['comment'],
            'product_id' => $product->id
        ]);

        return redirect()->back()->with('success');
    }
}
