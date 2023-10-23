<?php

namespace App\Http\Controllers\panel;

use App\Exports\ExportCategories;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as Types;
use App\Http\Requests\{CategoryStoreRequest, CategoryUpdateRequest};
use App\Models\Category;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = $this->getCategoriesFromRequest($request);

        return view('panel.categories.index', [
            'categories' => $categories->paginate(15)
        ]);
    }

    public function create()
    {
        return view('panel.categories.create');
    }

    public function store(CategoryStoreRequest $request)
    {
        $category = Category::make($request->except(['image']));
        $category->ensureUniqueSlug($request);
        $category->save();
        $category->uploadImage($request);

        return to_route('admin.categories.index');
    }


    public function edit(Category $category)
    {
        return view('panel.categories.edit', ['category' => $category]);
    }

    public function update(Request $request, Category $category)
    {
        $category->fill($request->except(['image']));
        $category->ensureUniqueSlug($request);
        $category->save();
        $category->uploadImage($request);

        return to_route('admin.categories.index');
    }


    public function destroy(Category $category)
    {
        $category->delete();

        return to_route('admin.categories.index');
    }

    public function restore(Category $category)
    {
        $category->restore();

        return to_route('admin.categories.index');
    }

    public function forceDelete(Category $category)
    {
        $name = $category->name;
        $category->forceDelete();

        return to_route('admin.categories.index')->with('swal', [
            'title' => 'موفقیت‌آمیز!',
            'message' => 'دسته‌بندی '.$name.' باموفقیت حذف شد.',
            'icon' => 'success',
        ]);
    }

    public function export(Request $request)
    {
        $categories = $this->getCategoriesFromRequest($request);

        return Excel::download(new ExportCategories($categories->get()), 'categories.xlsx', Types::XLSX);

    }

    protected function getCategoriesFromRequest($request)
    {
        return Category::query()
        ->when($request->search, fn ($q) => $q->search($request->search));
    }
}
