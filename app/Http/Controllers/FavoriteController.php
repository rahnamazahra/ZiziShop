<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        return view('site.favorites', [
            'products'=> $request->user()->favoriteProducts,
        ]);
    }

    public function store(Product $product)  //TODO Check is favorite, if false create. else remove
    {
        auth()->user()->favoriteProducts()->attach($product->id);
    }

    public function destroy(Product $product)
    {
       auth()->user()->favoriteProducts()->detach($product->id);

      return redirect()->back()->with('success', 'Item removed from favorites.');

    }
}
