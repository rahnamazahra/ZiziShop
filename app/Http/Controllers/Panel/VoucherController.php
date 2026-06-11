<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Jobs\SendVoucherSms;
use App\Models\Product;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VoucherController extends Controller
{
    public function index()
    {
        return view('panel.vouchers.index', [
            'vouchers' => Voucher::with(['user', 'product'])->latest('id')->paginate(10),
        ]);
    }

    public function create()
    {
        return view('panel.vouchers.create', [
            'products' => Product::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        $voucher = Voucher::create($data['attributes']);

        $this->sendCouponSms($voucher, $data['audience']);

        return to_route('admin.vouchers.index')->with('swal', [
            'title'   => 'ثبت شد',
            'message' => 'کوپن ساخته شد' . ($data['audience'] === 'all' ? ' و پیامک برای همه‌ی کاربران در صف ارسال قرار گرفت.' : ' و پیامک برای کاربر ارسال شد.'),
            'icon'    => 'success',
        ]);
    }

    public function show(Voucher $voucher)
    {
        return view('panel.shared.show', [
            'title' => 'جزئیات کوپن: ' . $voucher->code,
            'items' => [
                'کد'             => $voucher->code,
                'نوع تخفیف'       => $voucher->amount ? 'مبلغی' : 'درصدی',
                'مقدار'          => $voucher->amount ? toman($voucher->amount) : $voucher->discount_percent . '%',
                'دامنه‌ی کاربر'    => $voucher->user_id ? ('کاربر: ' . optional($voucher->user)->name . ' (' . optional($voucher->user)->mobile . ')') : 'همه‌ی کاربران',
                'دامنه‌ی محصول'    => $voucher->product_id ? ('محصول: ' . optional($voucher->product)->name) : 'همه‌ی محصولات',
                'تاریخ شروع'      => $voucher->start_date ?: '—',
                'تاریخ پایان'     => $voucher->end_date ?: '—',
                'باقی‌مانده'      => $voucher->remaining,
                'وضعیت پیامک'     => $voucher->sms_sent ? ('ارسال شد — ' . gdate($voucher->sms_sent_at)) : 'ارسال نشده',
                'توضیحات'        => $voucher->comment ?: '—',
            ],
            'editUrl'    => route('admin.vouchers.edit', $voucher),
            'backUrl'    => route('admin.vouchers.index'),
            'breadcrumb' => ['داشبورد' => route('admin.dashboard'), 'کوپن‌ها' => route('admin.vouchers.index')],
        ]);
    }

    public function edit(Voucher $voucher)
    {
        return view('panel.vouchers.edit', [
            'voucher'  => $voucher,
            'products' => Product::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function update(Request $request, Voucher $voucher)
    {
        $data = $this->validatedData($request, $voucher);
        $voucher->update($data['attributes']);

        return to_route('admin.vouchers.index')->with('swal', [
            'title' => 'ویرایش شد', 'message' => 'کوپن به‌روزرسانی شد.', 'icon' => 'success',
        ]);
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();

        return to_route('admin.vouchers.index')->with('swal', [
            'title' => 'حذف شد', 'message' => 'کوپن حذف شد.', 'icon' => 'success',
        ]);
    }

    /**
     * اعتبارسنجی و آماده‌سازی داده‌های کوپن بر اساس دامنه‌ی کاربر و محصول.
     */
    protected function validatedData(Request $request, ?Voucher $voucher = null): array
    {
        $data = $request->validate([
            'code'           => ['required', 'string', 'max:100'],
            'discount_type'  => ['required', 'in:percent,amount'],
            'value'          => ['required', 'integer', 'min:1'],
            'audience'       => ['required', 'in:all,user'],
            'mobile'         => ['required_if:audience,user', 'nullable', 'regex:/^09\d{9}$/'],
            'product_scope'  => ['required', 'in:all,product'],
            'product_id'     => ['required_if:product_scope,product', 'nullable', 'exists:products,id'],
            'start_date'     => ['nullable', 'string'],
            'end_date'       => ['nullable', 'string'],
            'remaining'      => ['required', 'integer', 'min:1'],
            'comment'        => ['nullable', 'string', 'max:255'],
        ]);

        // دامنه‌ی کاربر: تبدیل موبایل به کاربر
        $userId = null;
        if ($data['audience'] === 'user') {
            $user = User::where('mobile', $data['mobile'])->first();
            if (! $user) {
                throw ValidationException::withMessages(['mobile' => 'کاربری با این شماره موبایل یافت نشد.']);
            }
            $userId = $user->id;
        }

        return [
            'audience' => $data['audience'],
            'attributes' => [
                'code'             => $data['code'],
                'discount_percent' => $data['discount_type'] === 'percent' ? $data['value'] : 0,
                'amount'           => $data['discount_type'] === 'amount' ? $data['value'] : null,
                'user_id'          => $userId,
                'product_id'       => $data['product_scope'] === 'product' ? $data['product_id'] : null,
                'start_date'       => $data['start_date'] ?: null,
                'end_date'         => $data['end_date'] ?: null,
                'remaining'        => $data['remaining'],
                'comment'          => $data['comment'] ?? null,
            ],
        ];
    }

    /**
     * ارسال پیامک کد تخفیف (تکی برای کاربر خاص، یا صف‌بندی برای همه‌ی کاربران).
     */
    protected function sendCouponSms(Voucher $voucher, string $audience): void
    {
        $valueText = $voucher->amount ? (number_format($voucher->amount) . ' تومان') : ($voucher->discount_percent . ' درصد');
        $message   = sprintf('کد تخفیف گالری رهنما: %s (%s). همین حالا خرید کنید!', $voucher->code, $valueText);

        if ($audience === 'user' && $voucher->user) {
            SendVoucherSms::dispatch($voucher->user->mobile, $message);
            $voucher->update(['sms_sent' => true, 'sms_sent_at' => now()]);

            return;
        }

        // همه‌ی کاربران (مشتری‌ها) — صف‌بندی برای جلوگیری از کندی
        User::customersOnly()->whereNotNull('mobile')
            ->select('mobile')
            ->chunk(200, function ($users) use ($message) {
                foreach ($users as $u) {
                    SendVoucherSms::dispatch($u->mobile, $message);
                }
            });

        $voucher->update(['sms_sent' => true, 'sms_sent_at' => now()]);
    }
}
