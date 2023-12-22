<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
    public function index(Category $category)
    {
        return view('site.products', [
            'category' => $category,
            'products'=> $category->getAllProducts()
        ]);
    }

    public function filetrProduct(Request $request, Category $category)
    {
        $filter = $request->input('filter');

        dd(match ($filter)
        {
            'MostVisited' => $category->getMostVisitedProducts(),
            'BestSelling' => $category->getBestSellingProducts(),
            'Latest' => $category->getLatestProducts(),
            'Chipset' =>  $category->getChipsetProducts(),
            'Expensive' => $category->getExpensiveProducts()
        });

    }


}
