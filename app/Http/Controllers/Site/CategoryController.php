<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    public function index(Category $category)
    {
        dd($category->ExpensiveProducts());

        return view('site.home');
    }


}
