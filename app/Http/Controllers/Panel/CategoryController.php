<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;

use App\Http\Requests\{CategoryStoreRequest, CategoryUpdateRequest};

use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query();

        if ($request->has('search')){
            $categories->search($request->quesry('search'));
        }

         $categories = $categories->paginate(1);

        return view('panel.categories.index', [
            'categories' => $categories
        ]);
    }

    public function create()
    {
        return view('panel.categories.create');
    }

    public function store(CategoryStoreRequest $request)
    {

        $category = Category::make($request->except(['slug', 'image']));

        if (!$request->input('slug')){
            $slug = Str::slug($category->name);
            $category->slug = $category->generateUniqueSlug($slug);

        }

        $category->save();

        $category->uploadImage($request->file('image'));

        return to_route('admin.categories.index');
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
