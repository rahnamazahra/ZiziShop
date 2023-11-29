<?php

namespace App\Http\Controllers\site;

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
        $categories = cache()->remember('categories', now()->addMinutes(5), function () {
            return Category::all();
        });

        // if($request->has("search")) {
        //     $search = $request->query('search');
        // }

        // $products = Product::where("name","like","%".$search."%")->get();

        return view('site.home', [
            'categories' => $categories,
            'products'  => Product::get(),
            'bestSellersOfTheWeek' => Product::getBestSellersOfTheWeek(),
        ]);
    }
}
