@extends('layouts.site.lux')

@section('title', 'فعال‌سازی موبایل — گالری رهنما')

@section('content')
    <div class="auth-wrap">
        <div class="auth-card">
            <div class="ornament"><i></i><b>✦</b><i></i></div>
            <h1 class="auth-title goldtext">فعال‌سازی موبایل</h1>
            <p class="auth-sub">کد تأیید پیامک‌شده به {{ fa_num($mobile) }} را وارد کنید</p>

            <form method="POST" action="{{ route('auth.mobile.verify') }}">
                @csrf
                <input type="hidden" name="mobile" value="{{ $mobile }}">

                <label class="f-label" for="verification_code">کد تأیید</label>
                <input class="f-input input-just-number" type="text" id="verification_code" name="verification_code"
                       inputmode="numeric" autocomplete="one-time-code" dir="ltr"
                       style="text-align:center;letter-spacing:.4em;font-size:18px;">
                @error('verification_code') <div class="f-err">{{ $message }}</div> @enderror
                @error('mobile') <div class="f-err">{{ $message }}</div> @enderror

                <div style="margin-top:24px;">
                    <button type="submit" class="buybtn" style="width:100%;">فعال‌سازی</button>
                </div>
            </form>

            <p class="auth-foot" style="margin-top:20px;">
                کد دریافت نکردید؟
                <a id="resend-link" href="{{ route('auth.mobile.sendCode') }}">ارسال دوباره کد</a>
                <span id="resend-timer" style="display:none;color:#aaa;font-size:13px;"></span>
            </p>
        </div>
    </div>

<script>
(function () {
    var link  = document.getElementById('resend-link');
    var timer = document.getElementById('resend-timer');
    var WAIT  = 90; // ثانیه

    function startCountdown(seconds) {
        link.style.display  = 'none';
        timer.style.display = 'inline';

        var remaining = seconds;
        timer.textContent = 'ارسال مجدد تا ' + remaining + ' ثانیه دیگر';

        var interval = setInterval(function () {
            remaining--;
            if (remaining <= 0) {
                clearInterval(interval);
                timer.style.display = 'none';
                link.style.display  = 'inline';
            } else {
                timer.textContent = 'ارسال مجدد تا ' + remaining + ' ثانیه دیگر';
            }
        }, 1000);
    }

    // اگر تازه از send-code آمده‌ایم، تایمر شروع می‌شود
    var arrivedFresh = {{ $smsSent ? 'true' : 'false' }};
    if (arrivedFresh) {
        startCountdown(WAIT);
    }

    // وقتی کلیک می‌کند روی ارسال دوباره، بعد از redirect برگشت، تایمر شروع می‌شود
    link.addEventListener('click', function () {
        sessionStorage.setItem('otp_sent', '1');
    });

    if (sessionStorage.getItem('otp_sent') === '1') {
        sessionStorage.removeItem('otp_sent');
        startCountdown(WAIT);
    }
})();
</script>
@endsection
