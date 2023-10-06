<?php

namespace App\Http\Controllers\Panel;

use App\Models\{Inventory, Product, Color, Size, Tag};
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);

        return view('panel.products.index', ['products' => $products]);
    }

    public function create()
    {
       $categories = Category::get();
       $colors     = Color::get();
       $sizes      = Size::get();

        return view('panel.products.create', ['categories' => $categories, 'colors' => $colors, 'sizes' => $sizes]);
    }


    public function store(Request $request)
    {

        $product = Product::create($request->except(['tags', 'repeater_variety']));

        $slug = Str::slug($request->input('name'));
        $product->slug = $slug;
        $product->save();


        $tags = explode('،', $request->input('tags'));

        foreach ($tags as $tag) {
           Tag::firstOrCreate(['title' => trim($tag)]);
        }

        // $product->tags()->attach($tags);


        if ($request->input('repeater_variety'))
        {
            // foreach ($request->input('repeater_variety') as $variety) {
            //     $product->inventory->create([
            //         'product_id' => $product->id,
            //         'color_id'   => $variety['product_color'],
            //         'size_id'    => $variety['product_size'],
            //         'count'      => $variety['product_inventory']
            //     ]);
            // }
        }

        return to_route('admin.products.index');
    }


    public function show($slug)
    {
        $product = Product::where('slug', $slug)->first();

        return view('site.details', compact('product'));
    }


    public function edit(Product $product)
    {
        return view('panel.products.edit');
    }


    public function update(Request $request, Product $product)
    {
        //
    }

    public function destroy(Product $product)
    {
        $product->delete();
    }

    public function uploads(Request $request)
    {
        //  $product->uploadImage($request->file('images'));
        return response()->json(['response' => 'success']);
    }
}
