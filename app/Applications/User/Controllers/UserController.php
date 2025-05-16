<?php
namespace App\Applications\User\Controllers;

use App\Applications\User\Requests\UserStoreRequest;
use App\Support\Responses\ApiResponse;
use App\Domains\User\Services\UserService;

class UserController
{
    public function __construct(
        protected UserService $service
    ) {}

    public function index()
    {
        return ApiResponse::success('لیست کاربران', [
            'users' => $this->service->getAll()
        ]);
    }

    public function create(UserStoreRequest $request)
    {
        $user = $this->service->store($request->validated());

        return ApiResponse::success('کاربر ایجاد شد', compact('user'));
    }

    public function update(UserStoreRequest $request, int $id)
    {
        $user = $this->service->update($id, $request->validated());

        return ApiResponse::success('کاربر بروزرسانی شد', compact('user'));
    }

    public function show(int $id)
    {
        $user = $this->service->show($id);

        return ApiResponse::success('جزئیات کاربر', compact('user'));
    }

    public function destroy(int $id)
    {
        $this->service->delete($id);

        return ApiResponse::success('کاربر حذف شد');
    }
}
