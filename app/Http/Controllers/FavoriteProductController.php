<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteProductController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('site.favorites', [
            'favorites'=> $request->user()->favorites,
        ]);
    }
}
