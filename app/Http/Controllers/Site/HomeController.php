<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
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


       // $best_sellers = Product::getBestSellersOfTheWeek();

        return view('site.home', [
            'categories' => $categories,
           // 'best_sellers' => $best_sellers,
        ]);
    }
}
