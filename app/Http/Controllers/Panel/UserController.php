<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;
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

    public function show(User $user)
    {
        $user->load(['city.province', 'orders', 'addresses.city.province']);
        $wallet = $user->wallet;

        $items = [
            'نام'              => $user->name,
            'موبایل'           => $user->mobile,
            'تاریخ تولد'        => $user->birthday ? gdate($user->birthday) : '—',
            'استان'            => optional(optional($user->city)->province)->name ?? '—',
            'شهر'             => optional($user->city)->name ?? '—',
            'تعداد سفارش‌ها'    => $user->orders->count() . ' سفارش',
            'وضعیت کیف‌پول'     => $wallet->isExpired()
                ? '<span class="badge badge-light-danger">منقضی</span>'
                : '<span style="background:#ecedf7;color:#464387;border-radius:8px;padding:3px 10px;font-weight:600;">معتبر تا ' . gdate($wallet->expires_at) . '</span>',
            'پاداش بعدی کیف‌پول' => number_format($wallet->nextReward()) . ' تومان',
            'تاریخ عضویت'       => gdate($user->created_at),
        ];

        // موجودی کیف‌پول در هدر کارت (سمت چپ)
        $headerExtra = '<span style="background:linear-gradient(135deg,#527aba,#343265);color:#fff;border-radius:8px;padding:8px 16px;font-weight:800;font-size:15px;">کیف‌پول: '
            . number_format($wallet->usableBalance()) . ' تومان</span>';

        foreach ($user->addresses as $i => $address) {
            $items['آدرس ' . ($i + 1)] = sprintf(
                '%s — %s, %s — %s',
                $address->receiver ?? '',
                optional(optional($address->city)->province)->name ?? '',
                optional($address->city)->name ?? '',
                $address->body ?? ''
            );
        }

        return view('panel.shared.show', [
            'title'       => 'جزئیات کاربر: ' . $user->name,
            'items'       => $items,
            'headerExtra' => $headerExtra,
            'editUrl'     => route('admin.users.edit', $user),
            'backUrl'     => route('admin.users.index'),
            'breadcrumb'  => ['داشبورد' => route('admin.dashboard'), 'کاربران' => route('admin.users.index')],
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
        ->customersOnly()
        ->withCount('orders')
        ->withSum('orders as purchases_total', 'total')
        ->when($request->has('trashed'), fn($q) =>  $q->onlyTrashed())
        ->when($request->has('search'), fn($q) => $q->search($request->search))
        ->when($request->filled('city'), fn($q) => $q->where('city_id', $request->city))
        ->when($request->filled('province'), fn($q) => $q->whereHas('province', function ($query) use ($request) {
            $query->where('province_id', $request->input('province'));
        }));
    }
}
