<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'receiver'      => ['required', 'string', 'max:255'],
            'mobile'        => ['required', 'string', 'max:11'],
            'national_code' => [
                'required', 'string', 'size:10',
                // هر کد ملی فقط متعلق به یک حساب است
                function ($attribute, $value, $fail) use ($user) {
                    if (\App\Models\Address::where('national_code', $value)->where('user_id', '!=', $user->id)->exists()) {
                        $fail('این کد ملی قبلاً برای حساب دیگری ثبت شده است. در صورت مغایرت با پشتیبانی تماس بگیرید.');
                    }
                },
            ],
            'postal_code'   => [
                'required', 'string', 'max:10',
                // هر کد پستی فقط متعلق به یک حساب است
                function ($attribute, $value, $fail) use ($user) {
                    if (\App\Models\Address::where('postal_code', $value)->where('user_id', '!=', $user->id)->exists()) {
                        $fail('این کد پستی قبلاً برای حساب دیگری ثبت شده است. در صورت مغایرت با پشتیبانی تماس بگیرید.');
                    }
                },
            ],
            'city_id'       => ['required', 'exists:cities,id'],
            'body'          => ['required', 'string', 'max:1000'],
            'birthday'      => ['nullable', 'date', 'before:today'],
        ], [], [
            'receiver'      => 'نام گیرنده',
            'mobile'        => 'موبایل',
            'national_code' => 'کد ملی',
            'postal_code'   => 'کد پستی',
            'city_id'       => 'شهر',
            'body'          => 'آدرس',
            'birthday'      => 'تاریخ تولد',
        ]);

        $address = $user->addresses()->create([
            'receiver'      => $data['receiver'],
            'mobile'        => $data['mobile'],
            'national_code' => $data['national_code'],
            'postal_code'   => $data['postal_code'],
            'city_id'       => $data['city_id'],
            'body'          => $data['body'],
        ]);

        // تاریخ تولد فقط یک‌بار ثبت می‌شود و دیگر قابل ویرایش نیست (تغییر فقط از طریق پشتیبانی)
        if (! empty($data['birthday']) && is_null($user->birthday)) {
            $user->update([
                'birthday'        => $data['birthday'],
                'birthday_set_at' => now(),
            ]);
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
