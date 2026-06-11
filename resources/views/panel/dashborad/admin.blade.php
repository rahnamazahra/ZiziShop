@extends('layouts.panel.master')

@section('title', 'داشبورد')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد' => route('admin.dashboard')]" title='داشبورد' />
@endsection

@section('content')
    @php
        $cards = [
            ['title' => 'فروش امروز',      'value' => toman($amountToday), 'sub' => number_format($salesToday) . ' سفارش',  'bg' => 'bg-primary'],
            ['title' => 'فروش ۷ روز اخیر',  'value' => toman($amountWeek),  'sub' => number_format($salesWeek) . ' سفارش',   'bg' => 'bg-info'],
            ['title' => 'فروش ۳۰ روز اخیر', 'value' => toman($amountMonth), 'sub' => number_format($salesMonth) . ' سفارش',  'bg' => 'bg-success'],
            ['title' => 'سود خالص',         'value' => toman($netProfit),   'sub' => 'درآمد: ' . toman($totalSalesAmount) . ' − هزینه‌ها', 'bg' => 'bg-dark'],
        ];
        $counters = [
            ['title' => 'کاربران',         'value' => $usersCount,        'icon' => 'user',     'color' => 'text-primary', 'url' => route('admin.users.index')],
            ['title' => 'محصولات',         'value' => $productsCount,     'icon' => 'product',  'color' => 'text-info',    'url' => route('admin.products.index')],
            ['title' => 'دسته‌بندی‌ها',     'value' => $categoriesCount,   'icon' => 'category', 'color' => 'text-success', 'url' => route('admin.categories.index')],
            ['title' => 'محصولات ناموجود',  'value' => $outOfStockCount,   'icon' => 'product',  'color' => 'text-danger',  'url' => route('admin.products.index')],
            ['title' => 'سفارش‌های ویژه',   'value' => $customOrdersCount, 'icon' => 'basket',   'color' => 'text-warning', 'url' => route('admin.custom-orders.index')],
            ['title' => 'ویژه در انتظار',   'value' => $pendingCustomOrders, 'icon' => 'basket', 'color' => 'text-danger',  'url' => route('admin.custom-orders.index', ['status' => 'pending'])],
        ];
    @endphp

    {{-- کارت‌های فروش و سود --}}
    <div class="row g-5 g-xl-8 mb-5">
        @foreach($cards as $card)
            <div class="col-sm-6 col-xl-3">
                <div class="card {{ $card['bg'] }} h-100">
                    <div class="card-body text-white">
                        <div class="fs-6 opacity-75 mb-2">{{ $card['title'] }}</div>
                        <div class="fs-2hx fw-bold">{{ $card['value'] }}</div>
                        <div class="fs-8 opacity-75 mt-1">{{ $card['sub'] }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- جمع‌بندی حسابداری --}}
    <div class="row g-5 mb-5">
        <div class="col-md-3 col-6"><div class="card h-100"><div class="card-body text-center">
            <div class="fs-7 text-gray-500">درآمد کل</div><div class="fs-4 fw-bold text-success">{{ toman($totalSalesAmount) }}</div>
        </div></div></div>
        <div class="col-md-3 col-6"><div class="card h-100"><div class="card-body text-center">
            <div class="fs-7 text-gray-500">قیمت تمام‌شده‌ی فروش</div><div class="fs-4 fw-bold text-warning">{{ toman($totalCost) }}</div>
        </div></div></div>
        <div class="col-md-3 col-6"><div class="card h-100"><div class="card-body text-center">
            <div class="fs-7 text-gray-500">هزینه‌های جانبی</div><div class="fs-4 fw-bold text-danger">{{ toman($totalExpenses) }}</div>
        </div></div></div>
        <div class="col-md-3 col-6"><div class="card h-100"><div class="card-body text-center">
            <div class="fs-7 text-gray-500">پیشنهاد پس‌انداز ماهانه</div>
            <a href="{{ route('admin.expenses.index') }}" class="fs-4 fw-bold text-info text-decoration-none">{{ toman($monthlyExpenseEstimate) }}</a>
        </div></div></div>
    </div>

    {{-- پیشنهادها و هشدارهای هوشمند --}}
    @if(!empty($suggestions))
        <div class="card mb-5">
            <div class="card-header"><div class="card-title fw-bold">💡 پیشنهادها و راهنمایی‌های مالی</div></div>
            <div class="card-body">
                <div class="d-flex flex-column gap-3">
                    @foreach($suggestions as [$type, $icon, $text])
                        <div class="d-flex align-items-start gap-3 bg-light-{{ $type }} rounded p-4">
                            <span class="fs-2">{{ $icon }}</span>
                            <div class="fs-6 text-gray-800 pt-1">{{ $text }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- نمودار فروش ماهانه --}}
    <div class="card mb-5">
        <div class="card-header"><div class="card-title fw-bold">روند فروش ۶ ماه اخیر</div></div>
        <div class="card-body">
            <div id="gr-sales-chart" style="min-height:320px;"></div>
        </div>
    </div>

    {{-- سود به‌تفکیک محصول --}}
    <div class="row g-5 mb-5">
        <div class="col-lg-7">
            <div class="card h-100">
                <div class="card-header"><div class="card-title fw-bold">⭐ پرسودترین محصولات</div></div>
                <div class="card-body">
                    @if($topProfitProducts->isEmpty())
                        <div class="text-center text-gray-500 py-5">هنوز فروشی ثبت نشده است.</div>
                    @else
                        <table class="table table-row-dashed align-middle gy-3">
                            <thead><tr class="fw-bold text-gray-600 fs-7"><th>محصول</th><th class="text-center">تعداد فروش</th><th class="text-center">درآمد</th><th class="text-center">سود</th><th class="text-center">حاشیه</th></tr></thead>
                            <tbody>
                                @foreach($topProfitProducts as $p)
                                    <tr>
                                        <td class="fw-bold text-gray-800">{{ $p->name }}</td>
                                        <td class="text-center">{{ number_format($p->units) }}</td>
                                        <td class="text-center">{{ toman($p->revenue) }}</td>
                                        <td class="text-center fw-bold text-{{ $p->profit >= 0 ? 'success' : 'danger' }}">{{ toman($p->profit) }}</td>
                                        <td class="text-center"><span class="badge badge-light-{{ $p->margin >= 30 ? 'success' : ($p->margin >= 15 ? 'warning' : 'danger') }}">{{ $p->margin }}%</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header"><div class="card-title fw-bold"><span class="text-danger me-2">●</span> محصولات زیان‌ده</div></div>
                <div class="card-body">
                    @if($lossProducts->isEmpty())
                        <div class="text-center text-gray-500 py-5">هیچ محصولی زیر قیمت تمام‌شده فروخته نشده. 👌</div>
                    @else
                        <table class="table table-row-dashed align-middle gy-3">
                            <thead><tr class="fw-bold text-gray-600 fs-7"><th>محصول</th><th class="text-center">زیان</th></tr></thead>
                            <tbody>
                                @foreach($lossProducts as $p)
                                    <tr><td class="fw-bold text-gray-800">{{ $p->name }}</td><td class="text-center fw-bold text-danger">{{ toman($p->profit) }}</td></tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- شمارنده‌ها --}}
    <div class="row g-5 g-xl-8 mb-5">
        @foreach($counters as $counter)
            <div class="col-6 col-md-4 col-xl-2">
                <a href="{{ $counter['url'] }}" class="card h-100 text-hover-primary">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <span class="svg-icon svg-icon-3x {{ $counter['color'] }}">
                                <x-svg.icon-svg :icon="$counter['icon']" />
                            </span>
                        </div>
                        <div class="fs-2 fw-bold text-gray-800">{{ number_format($counter['value']) }}</div>
                        <div class="fs-7 text-gray-500">{{ $counter['title'] }}</div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    {{-- محصولات ناموجود (اولویت بالا برای تصمیم‌گیری) --}}
    <div class="card mb-5">
        <div class="card-header">
            <div class="card-title fw-bold"><span class="text-danger me-2">●</span> محصولات ناموجود (موجودی صفر)</div>
            <div class="card-toolbar"><span class="badge badge-light-danger">{{ $outOfStockCount }} مورد</span></div>
        </div>
        <div class="card-body">
            @if($outOfStockProducts->isEmpty())
                <div class="text-center text-gray-500 py-5">همه‌ی محصولات موجودند. 🎉</div>
            @else
                <table class="table table-row-dashed align-middle gy-3">
                    <thead>
                        <tr class="fw-bold text-gray-600 fs-7">
                            <th>تصویر</th><th>نام محصول</th><th>کد (SKU)</th><th>دسته‌بندی</th><th>قیمت</th><th>اقدام</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($outOfStockProducts as $product)
                            <tr>
                                <td><img src="{{ $product->poster_url }}" style="width:44px;height:44px;object-fit:cover;border-radius:8px;"></td>
                                <td class="fw-bold text-gray-800">{{ $product->name }}</td>
                                <td>{{ $product->sku ?: '—' }}</td>
                                <td>{{ optional($product->category)->name ?? '—' }}</td>
                                <td>{{ toman($product->price) }}</td>
                                <td><a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-light-primary">شارژ موجودی</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    {{-- متولدین امروز (اولویت پایین‌تر) --}}
    @if($birthdayUsers->isNotEmpty())
        <div class="card mb-5">
            <div class="card-header">
                <div class="card-title fw-bold">🎂 متولدین امروز</div>
                <div class="card-toolbar"><span class="badge badge-light-warning">{{ $birthdayUsers->count() }} نفر</span></div>
            </div>
            <div class="card-body">
                <div class="text-muted fs-7 mb-3">به‌صورت خودکار (هر روز ۹ صبح) پیامک تبریک و کوپن هدیه‌ی ۲۰۰٬۰۰۰ تومانی (اعتبار ۱۰ روزه) صادر می‌شود.</div>
                <table class="table table-row-dashed align-middle gy-3 text-center">
                    <thead>
                        <tr class="fw-bold text-gray-600 fs-7">
                            <th class="text-center">نام</th>
                            <th class="text-center">موبایل</th>
                            <th class="text-center">تاریخ عضویت</th>
                            <th class="text-center">وضعیت پیامک تبریک</th>
                            <th class="text-center">کد تخفیف</th>
                            <th class="text-center">مبلغ کوپن</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($birthdayUsers as $bUser)
                            @php $voucher = $birthdayVouchers[$bUser->id] ?? null; @endphp
                            <tr>
                                <td class="fw-bold text-gray-800"><a href="{{ route('admin.users.show', $bUser) }}" class="text-hover-primary">{{ $bUser->name }}</a></td>
                                <td dir="ltr">{{ $bUser->mobile }}</td>
                                <td>{{ gdate($bUser->created_at) }}</td>
                                <td>
                                    @if($voucher && $voucher->sms_sent)
                                        <span class="badge badge-success">ارسال شد — {{ gdate($voucher->sms_sent_at) }}</span>
                                    @elseif($voucher)
                                        <span class="badge badge-danger">ساخته شد، پیامک ناموفق</span>
                                    @else
                                        <span class="badge badge-secondary">در انتظار (۹ صبح)</span>
                                    @endif
                                </td>
                                <td dir="ltr">{{ $voucher ? $voucher->code : '—' }}</td>
                                <td>{{ $voucher ? toman($voucher->amount) : '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection

@section('custom-scripts')
    <script>
        (function () {
            const el = document.querySelector('#gr-sales-chart');
            if (!el || typeof ApexCharts === 'undefined') return;
            const chart = new ApexCharts(el, {
                series: [{ name: 'فروش (تومان)', data: @json($monthlyValues) }],
                chart: { type: 'area', height: 320, fontFamily: 'inherit', toolbar: { show: false } },
                colors: ['#343265'],
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 3 },
                fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05 } },
                xaxis: { categories: @json($monthlyLabels) },
                yaxis: { labels: { formatter: v => new Intl.NumberFormat('fa-IR').format(v) } },
                tooltip: { y: { formatter: v => new Intl.NumberFormat('fa-IR').format(v) + ' تومان' } },
                grid: { borderColor: '#eee' },
            });
            chart.render();
        })();
    </script>
@endsection
