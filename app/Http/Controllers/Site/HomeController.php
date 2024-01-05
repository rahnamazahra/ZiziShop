<?php

namespace App\Http\Controllers\Site;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $categories = cache()->remember('categories', now()->addSeconds(1), function () {
            return Category::withCount(['products' => function($query) {
                $query->where('is_published', 1);
            }])->get();
        });

        return view('site.home', [
            'categories' => $categories,
            'products'  => Product::where('is_published', 1)->take(8)->get(),
            'bestSellersOfTheWeek' => Product::getBestSellersOfTheWeek(),
        ]);
    }
}


