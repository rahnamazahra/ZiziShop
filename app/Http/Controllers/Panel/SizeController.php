<?php

namespace App\Http\Controllers\Panel;

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

    public function show(Size $size)
    {
        return view('panel.shared.show', [
            'title'      => 'جزئیات سایز: ' . $size->name,
            'items'      => ['نام' => $size->name],
            'editUrl'    => route('admin.sizes.edit', $size),
            'backUrl'    => route('admin.sizes.index'),
            'breadcrumb' => ['داشبورد' => route('admin.dashboard'), 'سایزها' => route('admin.sizes.index')],
        ]);
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
