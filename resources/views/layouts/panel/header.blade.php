<style>
    /* یکدست‌سازی اندازه‌ی آیکن زنگوله و آواتار پروفایل در هدر پنل */
    #kt_header_user_menu_toggle .btn.btn-icon,
    #kt_header_user_menu_toggle .symbol { width: 40px !important; height: 40px !important; }
    #kt_header_user_menu_toggle .symbol > img { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
    #kt_header_user_menu_toggle { gap: 6px; }
    /* نمایش جزئیات با هاور روی دکمه‌ی چشم */
    .btn[title="مشاهده جزئیات"]:hover { background: #eef2ff !important; }

    /* یکدست‌سازی نوار دکمه‌های بالای لیست‌ها (ایجاد/اکسل/سطل‌زباله) */
    .card-toolbar { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
    .card-toolbar .btn,
    .card-toolbar form > .btn {
        display: inline-flex !important; align-items: center; justify-content: center; gap: 6px;
        height: 40px; padding: 0 16px; white-space: nowrap; line-height: 1;
    }
    .card-toolbar .btn .svg-icon,
    .card-toolbar .btn .svg-icon-svg { margin: 0 !important; display: inline-flex; }
    .card-toolbar form { margin: 0; }
    /* دکمه‌های اقدامِ ردیف (ویرایش/حذف/جزئیات) هم‌اندازه و وسط‌چین */
    td .btn-group .btn { display: inline-flex !important; align-items: center; justify-content: center; }

    /* ====== پالت رنگ سازمانی پنل (ایندیگو) ====== */
    :root { --bs-primary: #343265; --bs-primary-rgb: 52,50,101; --bs-link-color: #343265; }
    .btn-primary { background-color: #343265 !important; border-color: #343265 !important; color: #fff !important; }
    .btn-primary:hover, .btn-primary:focus, .btn-primary:active { background-color: #222143 !important; border-color: #222143 !important; }
    .btn-light-primary { background-color: #e8e8f3 !important; color: #343265 !important; }
    .btn-light-primary:hover { background-color: #343265 !important; color: #fff !important; }
    .text-primary { color: #343265 !important; }
    .bg-primary { background-color: #343265 !important; }
    .badge-light-primary { background-color: #e8e8f3 !important; color: #343265 !important; }
    .text-hover-primary:hover, a.text-hover-primary:hover { color: #343265 !important; }
    .text-active-primary.active, .nav-line-tabs .nav-link.active { color: #343265 !important; border-color: #343265 !important; }
    /* تب‌های نوتیفیکیشن روی هدر تیره → سفید */
    .menu-sub .nav-line-tabs .nav-link { color: rgba(255,255,255,.75) !important; border-color: transparent !important; }
    .menu-sub .nav-line-tabs .nav-link.active { color: #fff !important; border-color: #fff !important; }
    .menu-sub .menu-item .menu-link.active { background: #ecedf7 !important; color: #343265 !important; }
    a { color: #343265; }
    .form-control:focus, .form-select:focus { border-color: #7796c9; box-shadow: 0 0 0 .2rem rgba(52,50,101,.12); }
    .page-item.active .page-link { background-color: #343265 !important; border-color: #343265 !important; }
    .page-link { color: #343265; }

    /* سایدبار تیره → ایندیگو */
    .aside.aside-dark { background-color: #222143 !important; }
    .aside-dark .menu .menu-item .menu-link.active,
    .aside-dark .menu .menu-item.here > .menu-link { background-color: #343265 !important; }
    .aside-dark .menu .menu-item .menu-link:hover { background-color: rgba(255,255,255,.06) !important; }

    /* کارت‌های رنگیِ داشبورد با پالت */
    .card.bg-primary { background: linear-gradient(135deg,#343265,#222143) !important; }
    .card.bg-info    { background: linear-gradient(135deg,#527aba,#343265) !important; }
    .card.bg-success { background: linear-gradient(135deg,#7796c9,#527aba) !important; }
    .card.bg-dark    { background: linear-gradient(135deg,#222143,#0f0e1f) !important; }
    .card.bg-danger  { background: linear-gradient(135deg,#464387,#343265) !important; }
    .card.bg-warning { background: linear-gradient(135deg,#9bb2d7,#7796c9) !important; }

    /* هدر بالای پنل */
    .header { border-bottom: 2px solid #343265; }

    /* اینپوت‌های پنل: بورد ایندیگوی تمیز + رادیوس یکدست */
    .form-control, .form-select, .form-control-solid, textarea.form-control,
    .input-group-text, select.form-select {
        border: 1px solid #cdd3e6 !important; border-radius: 8px !important;
        background-color: #fff !important;
    }
    .form-control:focus, .form-select:focus, .form-control-solid:focus {
        border-color: #343265 !important; box-shadow: 0 0 0 .2rem rgba(52,50,101,.12) !important;
    }
    .btn { border-radius: 8px !important; }
    .card { border-radius: 12px !important; }
</style>
<!--begin::Header-->
<div id="kt_header" class="header align-items-stretch">
    <!--begin::Container-->
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <!--begin::Aside mobile toggle-->
        <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show aside menu">
            <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" id="kt_aside_mobile_toggle">
                <!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
                <span class="svg-icon svg-icon-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="currentColor"/>
                        <path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="currentColor"/>
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </div>
        </div>
        <!--end::Aside mobile toggle-->

        <!--begin::Mobile logo-->
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="{{ route('admin.dashboard') }}" class="d-lg-none fw-bold text-dark fs-5">گالری رهنما</a>
        </div>
        <!--end::Mobile logo-->

        <!--begin::Wrapper-->
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
            <!--begin::Navbar-->
            <div class="d-flex align-items-stretch" id="kt_header_nav">
            </div>
            <!--end::Navbar-->

            <!--begin::Toolbar wrapper-->
            <div class="d-flex align-items-stretch flex-shrink-0">
                <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">

                    <!--begin::Menu- wrapper-->
                    @php
                        $newOrderNotifications = auth()->user()->unreadNotifications;
                        $outOfStockProducts = \App\Models\Product::where('inventory', 0)->latest('id')->take(15)->get();
                        $notifCount = $newOrderNotifications->count() + $outOfStockProducts->count();
                    @endphp

                    <div class="btn btn-icon btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px position-relative" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        <!--begin::Bell Icon-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path opacity="0.3" d="M12 22C13.6569 22 15 20.6569 15 19C15 17.3431 13.6569 16 12 16C10.3431 16 9 17.3431 9 19C9 20.6569 10.3431 22 12 22Z" fill="currentColor"/>
                                <path d="M19 15V18C19 18.6 18.6 19 18 19H6C5.4 19 5 18.6 5 18V15C6.1 15 7 14.1 7 13V10C7 7.6 8.7 5.6 11 5.1V3C11 2.4 11.4 2 12 2C12.6 2 13 2.4 13 3V5.1C15.3 5.6 17 7.6 17 10V13C17 14.1 17.9 15 19 15ZM11 10C11 9.4 11.4 9 12 9C12.6 9 13 8.6 13 8C13 7.4 12.6 7 12 7C10.3 7 9 8.3 9 10C9 10.6 9.4 11 10 11C10.6 11 11 10.6 11 10Z" fill="currentColor"/>
                            </svg>
                        </span>
                        @if($notifCount > 0)
                            <span class="bullet bullet-dot bg-danger h-6px w-6px position-absolute translate-middle top-0 start-50 animation-blink"></span>
                        @endif

                        <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true">
                        <!--begin::Heading-->
                        <div class="d-flex flex-column rounded-top" style="background:linear-gradient(135deg,#343265 0%,#222143 100%);">
                            <h3 class="text-white fw-bold px-7 mt-7 mb-5">
                                اعلان‌ها <span class="fs-8 opacity-75 ps-3">{{ $notifCount }} مورد</span>
                            </h3>

                            <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-bold px-7">
                                <li class="nav-item">
                                    <a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active" data-bs-toggle="tab" href="#kt_topbar_notifications_orders" onclick="event.stopPropagation();">سفارش‌های جدید ({{ $newOrderNotifications->count() }})</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab" href="#kt_topbar_notifications_stock" onclick="event.stopPropagation();">اتمام موجودی ({{ $outOfStockProducts->count() }})</a>
                                </li>
                            </ul>
                        </div>
                        <!--end::Heading-->

                        <div class="tab-content">
                            <!--begin::Orders tab-->
                            <div class="tab-pane fade active show" id="kt_topbar_notifications_orders" role="tabpanel">
                                <div class="scroll-y mh-325px my-5 px-8">
                                    @forelse ($newOrderNotifications as $notification)
                                        <div class="d-flex flex-stack py-4">
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-35px me-4">
                                                    <span class="symbol-label bg-light-primary">
                                                        <span class="svg-icon svg-icon-2 svg-icon-primary">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path opacity="0.3" d="M18.041 22.041C18.5932 22.041 19.041 21.5932 19.041 21.041C19.041 20.4887 18.5932 20.041 18.041 20.041C17.4887 20.041 17.041 20.4887 17.041 21.041C17.041 21.5932 17.4887 22.041 18.041 22.041Z" fill="currentColor"/>
                                                                <path opacity="0.3" d="M6.04095 22.041C6.59324 22.041 7.04095 21.5932 7.04095 21.041C7.04095 20.4887 6.59324 20.041 6.04095 20.041C5.48867 20.041 5.04095 20.4887 5.04095 21.041C5.04095 21.5932 5.48867 22.041 6.04095 22.041Z" fill="currentColor"/>
                                                                <path d="M7.04 16V4H5.04L4.04 2H1.04C0.44 2 0 2.44 0 3.04C0 3.64 0.44 4.08 1.04 4.08H2.74L5.04 16H19.04L21.34 8H8.04" fill="currentColor"/>
                                                            </svg>
                                                        </span>
                                                    </span>
                                                </div>
                                                <div class="mb-0 me-2">
                                                    <a onclick="event.stopPropagation()" href="{{ route('admin.orders.show', ['order' => $notification->data['order_id']]) }}" class="fs-6 text-gray-800 text-hover-primary fw-bolder">
                                                        سفارش جدید #{{ $notification->data['order_id'] }}
                                                    </a>
                                                </div>
                                            </div>
                                            <span class="badge badge-light fs-8">
                                                {{ gdatetime($notification->data['order_careated_at']) }}
                                            </span>
                                        </div>
                                    @empty
                                        <div class="text-center text-gray-500 py-10">سفارش جدیدی نیست.</div>
                                    @endforelse
                                </div>
                                <div class="py-3 text-center border-top">
                                    <a onclick="event.stopPropagation();" href="{{ route('admin.orders.index') }}" class="btn btn-color-gray-600 btn-active-color-primary">مشاهده همه سفارش‌ها</a>
                                </div>
                            </div>
                            <!--end::Orders tab-->

                            <!--begin::Out-of-stock tab-->
                            <div class="tab-pane fade" id="kt_topbar_notifications_stock" role="tabpanel">
                                <div class="scroll-y mh-325px my-5 px-8">
                                    @forelse ($outOfStockProducts as $product)
                                        <div class="d-flex flex-stack py-4">
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-35px me-4">
                                                    <span class="symbol-label bg-light-danger">
                                                        <span class="svg-icon svg-icon-2 svg-icon-danger">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path opacity="0.3" d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z" fill="currentColor"/>
                                                                <path d="M12 13C11.4 13 11 12.6 11 12V8C11 7.4 11.4 7 12 7C12.6 7 13 7.4 13 8V12C13 12.6 12.6 13 12 13ZM12 17C12.6 17 13 16.6 13 16C13 15.4 12.6 15 12 15C11.4 15 11 15.4 11 16C11 16.6 11.4 17 12 17Z" fill="currentColor"/>
                                                            </svg>
                                                        </span>
                                                    </span>
                                                </div>
                                                <div class="mb-0 me-2">
                                                    <a onclick="event.stopPropagation();" href="{{ route('admin.products.show', $product) }}" class="fs-6 text-gray-800 text-hover-primary fw-bolder">{{ $product->name }}</a>
                                                    <div class="text-gray-500 fs-8">موجودی به صفر رسید — کد: {{ $product->sku ?: '—' }}</div>
                                                </div>
                                            </div>
                                            <span class="badge badge-light-danger fs-8">ناموجود</span>
                                        </div>
                                    @empty
                                        <div class="text-center text-gray-500 py-10">محصول ناموجودی نیست.</div>
                                    @endforelse
                                </div>
                                <div class="py-3 text-center border-top">
                                    <a onclick="event.stopPropagation();" href="{{ route('admin.products.index') }}" class="btn btn-color-gray-600 btn-active-color-primary">مشاهده محصولات</a>
                                </div>
                            </div>
                            <!--end::Out-of-stock tab-->
                        </div>
                        </div>{{-- /notification menu --}}
                    </div>{{-- /bell trigger --}}

                    <div class="cursor-pointer btn btn-icon btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="1.6"/>
                                <path d="M4 20a8 8 0 0 1 16 0" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                            </svg>
                        </span>

                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <div class="symbol symbol-50px me-5"></div>
                                <div class="d-flex flex-column">
                                    <div class="fw-bolder d-flex align-items-center fs-5">
                                        {{ \Auth::user()->name }}
                                        <span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">فعال</span>
                                    </div>
                                    <span class="fw-bold text-muted fs-7"> {{ \Auth::user()->mobile }} </span>
                                </div>
                            </div>
                        </div>
                        <!--end::Menu item-->

                        <div class="separator my-2"></div>

                        <div class="menu-item px-5">
                            <a href="{{ route('auth.logout') }}" class="menu-link px-5" onclick="event.stopPropagation(); window.location.href=this.getAttribute('href'); return false;">خروج</a>
                        </div>
                        </div>{{-- /profile menu --}}
                    </div>{{-- /avatar trigger --}}
                    <!--end::User account menu-->

                    <!--end::Menu wrapper-->
                </div>
                <!--end::User menu-->

                <!--begin::Header menu toggle-->
                <div class="d-flex align-items-center d-lg-none ms-2 me-n3" title="Show header menu">
                    <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" id="kt_header_menu_mobile_toggle">
                        <!--begin::Svg Icon | path: icons/duotune/text/txt001.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M13 11H3C2.4 11 2 10.6 2 10V9C2 8.4 2.4 8 3 8H13C13.6 8 14 8.4 14 9V10C14 10.6 13.6 11 13 11ZM22 5V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4V5C2 5.6 2.4 6 3 6H21C21.6 6 22 5.6 22 5Z" fill="currentColor"/>
                                <path opacity="0.3" d="M21 16H3C2.4 16 2 15.6 2 15V14C2 13.4 2.4 13 3 13H21C21.6 13 22 13.4 22 14V15C22 15.6 21.6 16 21 16ZM14 20V19C14 18.4 13.6 18 13 18H3C2.4 18 2 18.4 2 19V20C2 20.6 2.4 21 3 21H13C13.6 21 14 20.6 14 20Z" fill="currentColor"/>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                </div>
                <!--end::Header menu toggle-->
            </div>
            <!--end::Toolbar wrapper-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Container-->
</div>
<!--end::Header-->
