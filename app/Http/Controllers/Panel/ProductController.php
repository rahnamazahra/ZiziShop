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

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $product = Product::create($request->all());
        $slug = Str::slug($request->input('title'));
        $product->slug = $slug;
        $product->save();
    }


    public function show($slug)
    {
        $product = Product::where('slug', $slug)->first();

        return view('site.details', compact('product'));
    }


    public function edit(Product $product)
    {
        //
    }


    public function update(Request $request, Product $product)
    {
        $product->update($request->all());
        $slug = Str::slug($request->input('title'));
        $product->slug = $slug;
        $product->save();
    }


    public function destroy(Product $product)
    {
        $product->delete();
    }
}
