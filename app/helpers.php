<?php

if (!function_exists('successResponse')) {
    function successResponse($data = null, $message = 'عملیات موفق بود.', $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data
        ], $code);
    }
}

if (!function_exists('errorResponse')) {
    function errorResponse($message = 'خطا رخ داد.', $code = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $code);
    }
}

if (!function_exists('gdate')) {
    /**
     * تبدیل هر تاریخ به رشته‌ی شمسی برای نمایش. مقدار خالی → خط تیره.
     * (نام gdate برای جلوگیری از تداخل با تابع jdate پکیج morilog انتخاب شده است.)
     */
    function gdate($date, string $format = 'Y/m/d'): string
    {
        if (! $date) {
            return '—';
        }

        try {
            $formatted = \Morilog\Jalali\Jalalian::fromCarbon(\Carbon\Carbon::parse($date))->format($format);

            // ایزوله‌ی LTR تا در متن راست‌به‌چپ، سال سمت چپ و روز سمت راست درست نمایش داده شود
            return "\u{2066}" . $formatted . "\u{2069}";
        } catch (\Throwable $e) {
            return '—';
        }
    }
}

if (!function_exists('gdatetime')) {
    /**
     * تاریخ و ساعت شمسی.
     */
    function gdatetime($date): string
    {
        return gdate($date, 'Y/m/d H:i');
    }
}

if (!function_exists('toman')) {
    /**
     * نمایش مبلغ با جداکننده‌ی سه‌رقمی و واحد تومان.
     */
    function toman($amount): string
    {
        return number_format((int) $amount) . ' تومان';
    }
}

if (!function_exists('fa_num')) {
    /**
     * تبدیل ارقام لاتین به فارسی (برای نمایش). جداکننده‌ی هزارگان هم فارسی می‌شود.
     */
    function fa_num($value): string
    {
        return strtr((string) $value, [
            '0' => '۰', '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴',
            '5' => '۵', '6' => '۶', '7' => '۷', '8' => '۸', '9' => '۹',
            ',' => '٬',
        ]);
    }
}

if (!function_exists('fa_toman')) {
    /**
     * مبلغ با ارقام فارسی و واحد تومان.
     */
    function fa_toman($amount): string
    {
        return fa_num(number_format((int) $amount)) . ' تومان';
    }
}
