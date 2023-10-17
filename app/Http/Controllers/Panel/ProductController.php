<?php

namespace App\Http\Controllers\Panel;

use App\Models\{Inventory, Product, Color, Size, Tag};
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query();

        if ($request->has('trashed')) {
           $products->onlyTrashed();
        }

        if($request->has('search')){

            $products->search($request->query('search'));
        }

        if($request->has('is_published') && $request->input('is_published') != 'all'){

           $products->publishStatusProducts($request->input('is_published'));

        }

        if($request->has('is_healthy') && $request->input('is_healthy') != 'all'){

            $products->healtystatusProducts($request->input('is_healthy'));
        }

        if($request->has('category') && $request->input('category') != 'all'){
            $products->where('category_id', $request->input('category'));
        }

        $products = $products->paginate(15);

        return view('panel.products.index', [
            'categories' => Category::get(),
            'products' => $products,
        ]);
    }

    public function create()
    {
        return view('panel.products.create', [
            'categories' => Category::get(),
            'colors' => Color::get(),
            'sizes' => Size::get(),
        ]);
    }


    public function store(Request $request)
    {
        $product = Product::make($request->except(['features', 'tags', 'repeater_variety']));

        if (!$request->input('slug')){

            $slug = Str::slug($product->name, language: null);

            $product->slug = $product->generateUniqueSlug($slug);

        }
        else{
            $product->slug = $request->input('slug');
        }

        $product->features = json_encode($request->input('features'));

        $product->save();

        if($request->tags){
            $product->tags()->attach(Tag::findOrCreateFromRequest($request->tags));
        }


        if ($request->input('repeater_variety'))
        {

            foreach ($request->input('repeater_variety') as $variety) {
                $product->stocks()->create([
                    'product_id' => $product->id,
                    'color_id'   => $variety['color'],
                    'size_id'    => $variety['size'],
                    'count'      => $variety['product_inventory']
                ]);
            }
        }

        return to_route('admin.products.index')->with('swal', [
            'title' => 'موفقیت‌آمیز!',
            'message' => 'محصول '.$request->input('name').' باموفقیت ایجاد شد.',
            'icon' => 'success',
        ]);
    }


    public function show($slug)
    {
        $product = Product::where('slug', $slug)->first();

        return view('site.details', compact('product'));
    }


    public function edit(Product $product)
    {
        return view('panel.products.edit',[
            'categories' => Category::get(),
            'sizes' => Size::get(),
            'colors' => Color::get(),
            'product' => $product,
            'varieties' => $product->stocks,
            'tags' => $product->tags,
            'features' => json_decode($product->features),
        ]);
    }


    public function update(Request $request, Product $product)
    {
        $product->fill($request->except(['features', 'tags', 'repeater_variety']));

        if (!$request->input('slug')){

            $slug = Str::slug($product->name, language: null);

            $product->slug = $product->generateUniqueSlug($slug);

        }
        else{
            $product->slug = $request->input('slug');
        }

        $product->features = json_encode($request->input('features'));

        $product->save();

        if($request->tags){
            $product->tags()->sync(Tag::findOrCreateFromRequest($request->tags));
        }


        if ($request->input('repeater_variety'))
        {
            $product->stocks()->delete();

            foreach ($request->input('repeater_variety') as $variety) {
                $product->stocks()->create([
                    'color_id'   => $variety['color'],
                    'size_id'    => $variety['size'],
                    'count'      => $variety['product_inventory']
                ]);
            }
        }

        return to_route('admin.products.index')->with('swal', [
            'title' => 'موفقیت‌آمیز!',
            'message' => 'محصول '.$request->input('name').' باموفقیت ویرایش شد.',
            'icon' => 'success',
        ]);
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
