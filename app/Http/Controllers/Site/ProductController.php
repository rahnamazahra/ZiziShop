<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    public function index()
    {
        $paginator = Product::with('category')
            ->where('is_published', 1)
            ->latest()
            ->paginate(12);

        return view('site.home', [
            'categories' => Category::withCount(['products' => function ($query) {
                $query->where('is_published', 1);
            }])->get(),
            'products'             => $paginator->items(),
            'hasMore'              => $paginator->hasMorePages(),
            'bestSellersOfTheWeek' => Product::getBestSellersOfTheWeek(),
        ]);
    }

    public function loadMore(Request $request)
    {
        $page     = max(1, (int) $request->get('page', 1));
        $category = $request->get('category');
        $perPage  = 12;

        $query = Product::with('category')->where('is_published', 1)->latest();
        if ($category && $category !== 'all') {
            $query->where('category_id', (int) $category);
        }

        $paginator = $query->paginate($perPage, ['*'], 'page', $page);

        $html = view('site._product-cards', [
            'products' => $paginator->items(),
            'offset'   => ($page - 1) * $perPage,
        ])->render();

        return response()->json([
            'html'     => $html,
            'hasMore'  => $paginator->hasMorePages(),
            'nextPage' => $page + 1,
        ]);
    }


    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)->first();

        $relatedProducts = Product::with(['category'])
            ->where('category_id', $product->category->id)
            ->take(15)
            ->get();

        return view('site.product-details', ['product' => $product, 'relatedProducts' => $relatedProducts]);
    }

    /**
     * صفحه‌ی محصولات تخفیف‌دار — همه محصولاتی که الان تخفیف فعال دارند.
     */
    public function discounts()
    {
        $products = Product::with('category')
            ->where('is_published', 1)
            ->onSale()
            ->latest('id')
            ->paginate(12);

        return view('site.discounts', [
            'products' => $products->items(),
            'paginator' => $products,
        ]);
    }

    public function addComment(Request $request, Product $product)
    {
        $user = auth()->user();
        $user->ratings()->create([
            'rating' => 5,
            'comment' => $request['comment'],
            'product_id' => $product->id
        ]);

        return redirect()->back()->with('success');
    }
}
