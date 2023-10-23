<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Excel as Type;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportUsers;
use App\Http\Controllers\Controller;
use App\Models\{City, Role, User, Province};
use App\Http\Requests\panel\{UserStoreRequest, UserUpdateRequest};


class UserController extends Controller
{

    public function index(Request $request)
    {
        $users = $this->getUsersFromRequest($request);

        return view('panel.users.index', [
            'users' => $users->paginate(15),
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

    public function export(Request $request)
    {
        $users = $this->getUsersFromRequest($request);

        return Excel::download(new ExportUsers($users->get()), 'users.xlsx', Type::XLSX);

    }

    protected function getUsersFromRequest($request)
    {
        return User::query()
        ->when($request->has('trashed'), fn($q) =>  $q->onlyTrashed())
        ->when($request->has('search'), fn($q) => $q->search($request->search))
        ->when($request->filled('city'), fn($q) => $q->where('city_id', $request->city))
        ->when($request->filled('province'), fn($q) => $q->whereHas('province', function ($query) use ($request) {
            $query->where('province_id', $request->input('province'));
        }));
    }
}
