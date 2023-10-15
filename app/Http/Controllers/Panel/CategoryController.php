<?php

namespace App\Http\Controllers\panel;

use App\Exports\ExportCategories;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Requests\{CategoryStoreRequest, CategoryUpdateRequest};

use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query();

        if ($request->has('trashed')) {
            $categories->onlyTrashed();
        }

        if ($request->has('search')){
            $categories->search($request->query('search'));
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

            $slug = Str::slug($category->name, language: null);

            $category->slug = $category->generateUniqueSlug($slug);

        }
        else{
            $category->slug = $request->input('slug');
        }

        $category->save();

        if($request->file('image'))
        {
            $image_url = $request->file('image')->store('images/category', 'public');

            $category->image()->create([
                'path' => $image_url,
            ]);

        }

        return to_route('admin.categories.index');
    }


    public function edit($id)
    {
        $category = Category::find($id);

        $image = $category->image->pluck('path')->first();

        return view('panel.categories.edit', ['category' => $category, 'image' => $image]);
    }

    public function update(Request $request, Category $category)
    {

        $category->fill($request->except(['slug', 'image']));

        if (!$request->input('slug')){

            $slug = Str::slug($category->name, language: null);

            $category->slug = $category->generateUniqueSlug($slug);

        }
        else{
            $category->slug = $request->input('slug');
        }

        $category->update();

        if($request->hasFile('image'))
        {
            if($category->image_url){
                Storage::disc('public')->delete($category->image_url);
            }

            $image_url = $request->file('image')->store('images/category', 'public');

            $category->image()->create([
                'path' => $image_url,
            ]);

        }

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

    public function export()
    {
        $previousUrl = URL::previous();

        $queryString = parse_url($previousUrl, PHP_URL_QUERY);

        parse_str($queryString, $queryParams); //output array query


        $categories= Category::query();

        if(array_key_exists('trashed', $queryParams)) {
            $categories->onlyTrashed();
        }

        if(array_key_exists('search', $queryParams)) {
            $categories->search($queryParams['search']);
        }


        $categories = $categories->get();


        $response = Excel::download(new ExportCategories($categories), 'categories.xlsx', \Maatwebsite\Excel\Excel::XLSX);

        ob_end_clean();

        return $response;

    }
}
