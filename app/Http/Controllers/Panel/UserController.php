<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;

use App\Exports\ExportUsers;

use Maatwebsite\Excel\Facades\Excel;

use App\Models\{City, Role, User, Province};

use App\Http\Requests\panel\{UserStoreRequest, UserUpdateRequest};
use App\Http\Controllers\Controller;


class UserController extends Controller
{

    public function index(Request $request)
    {
        $users = User::query();

        if ($request->has('trashed')) {
            $users->onlyTrashed();
        }

        if ($request->has('search')) {
            $users->search($request->query('search'));
        }

        if ($request->has('city') && $request->input('city') != 'all') {

            $users->where('city_id', $request->input('city'));
        }

        if ($request->has('province') && $request->input('province') != 'all') {

            $users->whereHas('city', function ($query) use ($request) {
                $query->where('province_id', $request->input('province'));
            });
        }

        $users = $users->paginate(15);

        return view('panel.users.index', [
            'users' => $users,
            'provinces' => Province::all(),
            'cities' => City::all(),
        ]);
    }

    public function create()
    {
        return view('panel.users.create', [
            'provinces' => Province::get(),
        ]);
    }

    public function store(UserStoreRequest $request)
    {
        User::create($request->all());

        return to_route('admin.users.index')->with('swal', [
            'title' => 'موفقیت‌آمیز!',
            'message' => 'کاربر '.$request->input('name').' باموفقیت ایجاد شد.',
            'icon' => 'success',
        ]);
    }

    public function edit($id)
    {
        $user = User::find($id);

        return view('panel.users.edit', [
            'user' => $user,
        ]);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update($request->all());

        return to_route('admin.users.index')->with('swal', [
            'title' => 'موفقیت‌آمیز!',
            'message' => 'کاربر '.$request->input('name').' باموفقیت ویرایش شد.',
            'icon' => 'success',
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return to_route('admin.users.index');
    }

    public function restore(User $user)
    {
        $user->restore();

        return to_route('admin.users.index');
    }

    public function forceDelete(User $user)
    {
        $name = $user->name;

        $user->forceDelete();

        return to_route('admin.users.index')->with('swal', [
            'title' => 'موفقیت‌آمیز!',
            'message' => 'کاربر '.$name.' باموفقیت حذف شد.',
            'icon' => 'success',
        ]);
    }

    public function export()
    {
        $previousUrl = URL::previous();

        $queryString = parse_url($previousUrl, PHP_URL_QUERY);

        parse_str($queryString, $queryParams); //output array query


        $users = User::query();

        if(array_key_exists('trashed', $queryParams)) {
            $users->onlyTrashed();
        }

        if(array_key_exists('search', $queryParams)) {
            $users->search($queryParams['search']);
        }

        if(array_key_exists('city', $queryParams) && $queryParams['city'] != 'all') {

            $users->where('city_id', $queryParams['city']);
        }

        $users = $users->get();


        $response = Excel::download(new ExportUsers($users), 'users.xlsx', \Maatwebsite\Excel\Excel::XLSX);

        ob_end_clean();

        return $response;
    }
}
