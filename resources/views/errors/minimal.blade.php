<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('code') | گالری رهنما</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, #eef2f7 0%, #f6f8fb 100%);
            font-family: Tahoma, Vazirmatn, sans-serif; color: #2b303a; padding: 20px;
        }
        .err-box {
            background: #fff; border-radius: 18px; box-shadow: 0 18px 50px rgba(0,0,0,.08);
            padding: 48px 40px; text-align: center; max-width: 480px; width: 100%;
        }
        .err-code { font-size: 96px; font-weight: 800; color: #343265; line-height: 1; margin: 0; }
        .err-title { font-size: 22px; font-weight: 700; margin: 16px 0 8px; }
        .err-text { color: #6b7280; font-size: 15px; line-height: 2; margin-bottom: 26px; }
        .err-btn {
            display: inline-block; background: #343265; color: #fff; text-decoration: none;
            padding: 12px 34px; border-radius: 30px; font-weight: 700; transition: background .2s;
        }
        .err-btn:hover { background: #222143; }
        .err-brand { margin-top: 22px; color: #9aa1ab; font-size: 13px; }
    </style>
</head>
<body>
    <div class="err-box">
        <p class="err-code">@yield('code')</p>
        <h1 class="err-title">@yield('title')</h1>
        <p class="err-text">@yield('message')</p>
        <a href="{{ url('/') }}" class="err-btn">بازگشت به صفحه اصلی</a>
        <div class="err-brand">گالری رهنما</div>
    </div>
</body>
</html>
