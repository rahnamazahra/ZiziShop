<?php

namespace App\Http\Controllers\Panel;

use Exception;
use Illuminate\Http\Request;
use App\Exports\ExportUsers;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Builder;
use App\Models\{City, Role, User, Province};
use App\Http\Requests\panel\{UserCreateRequest, UserUpdateRequest};
class UserController extends Controller
{
    public function index()
    {
        //TODO DRY

        $users = User::select(['id', 'name', 'mobile', 'birthday', 'province_id', 'city_id'])->latest()->paginate(1);
        $provinces = getProvinces();
        $cities = getCities();
        return view('panel.users.index', ['users' => $users, 'provinces' => $provinces, 'cities' => $cities]);
    }

    public function create()
    {
        $provinces = Province::get();
        return view('panel.users.create', ['provinces' => $provinces]);
    }

    public function store(UserCreateRequest $request)
    {
        User::create($request->all());
        return to_route('admin.users.index');
    }

    public function edit($id)
    {
        $user = USer::find($id);

        return view('panel.users.edit', ['user' => $user]);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $user = USer::find($id);

        $user->update($request->all());

        return to_route('admin.users.index');
    }

    public function trash()
    {
        $users = User::onlyTrashed()->latest()->paginate(1);
        return view('panel.users.trash', ['users' => $users]);

    }

    public function delete($id)
    {
        $user = User::find($id);
        if($user)
        {
            $user->delete();
        }

        return to_route('admin.users.index');
    }

    public function restore($id)
    {
        $user = User::withTrashed()->find($id);
        $user->restore();
        return to_route('admin.users.trash');
    }

    public function deleteForce($id)
    {
        $user = User::withTrashed()->find($id);
        $user->forceDelete();
    }

    public function search(Request $request)
    {
        $query = $request->query('search');
        $users = User::search($query);
        $provinces = Province::all();
        $cities = City::all();
        return view('panel.users.index',  ['users' => $users, 'provinces' => $provinces, 'cities' => $cities]);
    }

    public function exportUsers()
    {
       $previousUrl = URL::previous();

       $queryString = parse_url($previousUrl, PHP_URL_QUERY);

       parse_str($queryString, $queryParams);

       $users = User::select('name', 'mobile', 'city_id', 'province_id', 'birthday')->with(['city.province']);

        if (array_key_exists('search', $queryParams))
        {
            $search_item = $queryParams['search'];
            $users->when($search_item, function ($query) use ($search_item) {
                $query->where('name', 'LIKE', "%{$search_item}%")
                        ->orWhere('mobile', 'LIKE', "%{$search_item}%");
            });
        }


        $users = $users->get();

        $response = Excel::download(new ExportUsers($users), 'users.xlsx', \Maatwebsite\Excel\Excel::XLSX);

        ob_end_clean();

        return $response;
    }
}
