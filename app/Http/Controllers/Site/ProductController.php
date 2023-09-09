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
        //$product = Product::where('slug', $slug)->first();
        //return view('site.details', compact('product'));
         return view('site.details');
    }


}
