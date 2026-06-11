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
