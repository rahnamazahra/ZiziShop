<?php

namespace App\View\Components;

use App\Models\Category;
use App\Models\Voucher;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{

    public function __construct()
    {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.site.header', [
            'categories' => Category::all(),
            'vouchers'  => Voucher::all(),
        ]);
    }
}
