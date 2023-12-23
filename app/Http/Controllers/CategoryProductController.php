<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
    public function index(Request $request, Category $category)
    {
        if(($request->input('filter') and $request->input('filter')!='defualt') or ($request->input('amount'))) {
           $products = $this->getProductsFromRequest($request, $category);
        }
        else {
            $products = $category->getAllProducts();
        }

        return view('site.products', [
            'category' => $category,
            'products'=> $products
        ]);

    }

    public function getProductsFromRequest($request, $category)
    {


        if($request->input('amount'))
        {
            $range = $request->input('amount');

            $amounts = explode('تومان', $range);

            $minAmount = (int) $amounts[0];
            $maxAmount = (int) $amounts[1];

            return $category->getProductsPriceRange($minAmount, $maxAmount);
        }

        $filter = $request->input('filter');

        return match ($filter)
        {
            'relevant' => $category->getAllRelevantProducts(),
            'mostVisited' => $category->getMostVisitedProducts(),
            'bestSelling' => $category->getBestSellingProducts(),
            'latest' => $category->getLatestProducts(),
            'chipset' =>  $category->getChipsetProducts(),
            'expensive' => $category->getExpensiveProducts()
        };

    }

}
