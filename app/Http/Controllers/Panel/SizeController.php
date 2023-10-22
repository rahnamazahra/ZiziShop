<?php

namespace App\Http\Controllers\panel;

use App\Models\Size;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SizeController extends Controller
{
    public function index(Request $request)
    {
        $sizes = Size::query();

        if ($request->has('search')) {

            $sizes->search($request->query('search'));
        }

        $sizes = $sizes->paginate(15);

        return view('panel.sizes.index', [
            'sizes' => $sizes,
        ]);
    }


    public function create()
    {
        return view('panel.sizes.create');
    }


    public function store(Request $request)
    {
        Size::create($request->all());

        return to_route('admin.sizes.index');
    }

    public function edit(Size $size)
    {
        return view('panel.sizes.edit', [
            'size' => $size
        ]);

    }

    public function update(Request $request, Size $size)
    {
        $size->update($request->all());

        return to_route('admin.sizes.index');
    }


    public function destroy(Size $size)
    {
        //size_id foregn_id is in table stock
        $size->delete();
    }
}
