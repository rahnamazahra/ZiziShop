<?php

namespace App\Http\Controllers\Panel;
use App\Models\Color;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Stock;

class ColorController extends Controller
{

    public function index(Request $request)
    {
        return view('panel.colors.index', [
            'colors' => Color::paginate(15),
        ]);
    }


    public function create()
    {
        return view('panel.colors.create');
    }


    public function store(Request $request)
    {
        Color::create($request->all());

        return to_route('admin.colors.index');
    }

    public function edit(Color $color)
    {
        return view('panel.colors.edit', [
            'color' => $color
        ]);

    }


    public function update(Request $request, Color $color)
    {
        $color->update($request->all());

        return to_route('admin.colors.index');
    }


    public function destroy(Color $color)
    {

       //
    }
}
