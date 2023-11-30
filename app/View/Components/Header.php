<?php

namespace App\View\Components;

use App\Models\Category;
use App\Models\Voucher;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{

    public function render(): View|Closure|string
    {
        $categories = cache()->remember('categories', now()->addMonths(1), function () {
            return Category::all();
        });

        return view('components.site.header', [
            'categories' => $categories, //how using method in model => Category::getAllCategories
            'vouchers'  => Voucher::all(),
            'total_count_cart' => auth()->user()?->cart->count ?? 0,
            'total_count_favorite' => auth()->user()?->favorites->count() ?? 0,
        ]);
    }
}
