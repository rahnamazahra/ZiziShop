<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::select(['id', 'name'])->paginate(1);
        return view('panel.categories.index', ['categories' => $categories]);
    }

    public function create()
    {
        return view('panel.categories.create');
    }

    public function store(Request $request)
    {
        $category = Category::create($request->except(['image']));
        $slug = Str::slug($request->input('name'));
        $category->slug = $slug;
        $category->save();

        $category->uploadImage($request->file('image'));

        return to_route('admin.categories.index');
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $category = Category::find($id);

        $image = $category->files->pluck('path')->first();

        return view('panel.categories.edit', ['category' => $category, 'image' => $image]);
    }

    public function update(Request $request, $id)
    {

        $category = Category::find($id);

        $category->update($request->except(['image']));

        $category->deleteImage($request->file('image'));

        $category->uploadImage($request->file('image'));

        return to_route('admin.categories.index');
    }

    public function trash()
    {

    }

      public function delete($id)
    {
        $category = Category::find($id);
        if($category)
        {
            $category->delete();
        }

        return to_route('admin.categories.index');
    }

    public function restore($id)
    {

    }

    public function deleteForce($id)
    {

    }

    public function search(Request $request)
    {

    }

    public function export()
    {

    }
}
