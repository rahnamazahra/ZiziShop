<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'receiver'      => ['required', 'string', 'max:255'],
            'mobile'        => ['required', 'string', 'max:11'],
            'national_code' => ['required', 'string', 'size:10'],
            'postal_code'   => ['required', 'string', 'max:10'],
            'city_id'       => ['required', 'exists:cities,id'],
            'body'          => ['required', 'string', 'max:1000'],
            'birthday'      => ['nullable', 'date'],
        ], [], [
            'receiver'      => 'نام گیرنده',
            'mobile'        => 'موبایل',
            'national_code' => 'کد ملی',
            'postal_code'   => 'کد پستی',
            'city_id'       => 'شهر',
            'body'          => 'آدرس',
            'birthday'      => 'تاریخ تولد',
        ]);

        $user = $request->user();

        $address = $user->addresses()->create([
            'receiver'      => $data['receiver'],
            'mobile'        => $data['mobile'],
            'national_code' => $data['national_code'],
            'postal_code'   => $data['postal_code'],
            'city_id'       => $data['city_id'],
            'body'          => $data['body'],
        ]);

        if (! empty($data['birthday'])) {
            $user->update(['birthday' => $data['birthday']]);
        }

        // attach the address to the current cart so checkout can use it
        $user->cart->address()->associate($address)->save();

        return redirect()->route('cart.index')->with('swal', [
            'title'   => 'ثبت شد',
            'message' => 'اطلاعات ارسال با موفقیت ذخیره شد.',
            'icon'    => 'success',
        ]);
    }

    /**
     * انتخاب یک آدرس موجود برای سبد خرید فعلی.
     */
    public function select(Request $request, \App\Models\Address $address)
    {
        abort_unless($address->user_id === $request->user()->id, 403);

        $request->user()->cart->address()->associate($address)->save();

        return redirect()->route('cart.index')->with('swal', [
            'title'   => 'انتخاب شد',
            'message' => 'آدرس ارسال انتخاب شد.',
            'icon'    => 'success',
        ]);
    }
}
