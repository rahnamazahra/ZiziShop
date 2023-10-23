<?php

namespace App\Http\Controllers\Panel;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Exports\ExportProducts;
use Maatwebsite\Excel\Excel as Type;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Models\{Inventory, Product, Color, Size, Tag};
use App\Http\Requests\{ProductStoreRequest, ProductUpdateRequest};

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // todo get laracasts video from ostaaaad
        $products = $this->getProductsFromRequest($request);

        return view('panel.products.index', [
            'categories' => Category::get(),
            'products' => $products->paginate(15),
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

    public function store(ProductStoreRequest $request)
    {
        $product = Product::make($request->except(['tags', 'repeater_variety']));

        $product->ensureUniqueSlug($request);

        $product->save();

        if($request->tags) {

            $product->tags()->attach(Tag::findOrCreateFromRequest($request->tags));
        }


        if ($request->input('repeater_variety')) {

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
        return view('panel.products.edit', [
            'categories' => Category::get(),
            'sizes' => Size::get(),
            'colors' => Color::get(),
            'product' => $product,
            'varieties' => $product->stocks,
            'tags' => $product->tags,
        ]);
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        $product->fill($request->except(['tags', 'repeater_variety']));
        $product->ensureUniqueSlug($request);
        $product->save();

        if($request->tags) {
            $product->tags()->sync(Tag::findOrCreateFromRequest($request->tags));
        }

        if ($request->input('repeater_variety')) {
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

        return to_route('admin.products.index');
    }

    public function restore(Product $product)
    {
        $product->restore();

        return to_route('admin.products.index');
    }

    public function forceDelete(Product $product)
    {
        //todo delete images
        $product->tags()->delete();
        $product->stocks()->delete();
        $name = $product->name;
        $product->forceDelete();

        return to_route('admin.products.index')->with('swal', [
            'title' => 'موفقیت‌آمیز!',
            'message' => 'محصول '.$name.' باموفقیت حذف شد.',
            'icon' => 'success',
        ]);
    }

    public function export(Request $request)
    {
        $products = $this->getProductsFromRequest($request);
        $products = $products->get();

        return Excel::download(new ExportProducts($products), 'products.xlsx', Type::XLSX);

    }

    protected function getProductsFromRequest($request)
    {
        return Product::query()
            ->when($request->trashed, fn ($q) => $q->onlyTrashed())
            ->when($request->search, fn ($q) => $q->search($request->search))
            ->when($request->filled('category'), fn ($q) => $q->where('category_id', $request->category))
            ->when($request->filled('is_published'), fn ($q) => $q->publishStatusProducts($request->input('is_published')))
            ->when($request->filled('is_healthy'), fn ($q) => $q->healtystatusProducts($request->input('is_healthy')));
    }

}
