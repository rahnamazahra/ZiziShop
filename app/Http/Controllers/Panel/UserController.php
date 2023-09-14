<?php

namespace App\Http\Controllers\Panel;

use App\Http\Requests\panel\UserCreateRequest;
use App\Http\Requests\panel\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Province;

class UserController extends Controller
{

    public function index()
    {
        $users = User::get();
        return view('panel.users.index', ['users' => $users]);
    }

    public function create()
    {
        $provinces = Province::get();
        return view('panel.users.create', ['provinces' => $provinces]);
    }

    public function store(UserCreateRequest $request)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(UserUpdateRequest $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
