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

    public function show(Color $color)
    {
        return view('panel.shared.show', [
            'title'      => 'جزئیات رنگ: ' . $color->name,
            'items'      => [
                'نام'   => $color->name,
                'کد رنگ' => $color->code
                    ? '<span style="display:inline-block;width:18px;height:18px;border-radius:4px;vertical-align:middle;background:' . e($color->code) . ';border:1px solid #ddd;"></span> ' . e($color->code)
                    : '—',
            ],
            'editUrl'    => route('admin.colors.edit', $color),
            'backUrl'    => route('admin.colors.index'),
            'breadcrumb' => ['داشبورد' => route('admin.dashboard'), 'رنگ‌ها' => route('admin.colors.index')],
        ]);
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
        // حذف تنوع‌های (stock) وابسته به این رنگ و سپس حذف رنگ
        Stock::where('color_id', $color->id)->delete();
        $color->delete();

        return to_route('admin.colors.index')->with('swal', [
            'title'   => 'حذف شد',
            'message' => 'رنگ «' . $color->name . '» حذف شد.',
            'icon'    => 'success',
        ]);
    }
}
