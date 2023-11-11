<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
    public function __invoke(string $slug)
    {
        $products = Product::query()
            ->whereHas('category', fn ($q) => $q->where('slug', $slug))
            ->where('is_published', 1)
            ->orderBy('id','desc')
            ->get();

        return view('site.products', [
            'products'=> $products,
        ]);
    }
}
