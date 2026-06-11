<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\{Order, User, Product, Category, CustomOrder, Expense};
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\Jalalian;

class DashboardController extends Controller
{
    public function index()
    {
        $today      = Carbon::today();
        $weekStart  = Carbon::now()->subDays(7);
        $monthStart = Carbon::now()->subDays(30);

        // فروش ماهانه‌ی ۶ ماه اخیر (برای نمودار) با برچسب ماه شمسی
        $monthlyLabels = [];
        $monthlyValues = [];
        for ($i = 5; $i >= 0; $i--) {
            $start = Carbon::now()->subMonths($i)->startOfMonth();
            $end   = (clone $start)->endOfMonth();
            $monthlyLabels[] = Jalalian::fromCarbon($start)->format('F');
            $monthlyValues[] = (int) Order::whereBetween('created_at', [$start, $end])->sum('total');
        }

        // سود واقعی = درآمد کل − هزینه‌ی تمام‌شده‌ی اقلام فروخته‌شده
        $totalRevenue = (int) Order::sum('total');
        $totalCost = (int) DB::table('order_product')
            ->join('products', 'products.id', '=', 'order_product.product_id')
            ->selectRaw('COALESCE(SUM(order_product.count * COALESCE(products.cost_price, 0)), 0) as c')
            ->value('c');
        $grossProfit = $totalRevenue - $totalCost;

        // هزینه‌های جانبیِ کسب‌وکار و سود خالص
        $totalExpenses    = (int) Expense::sum('amount');
        $netProfit        = $grossProfit - $totalExpenses;
        $monthlyExpenseEstimate = (int) round(Expense::all()->sum(fn ($e) => $e->monthlyEquivalent()));

        // سود به‌تفکیک محصول (از روی سفارش‌های واقعی)
        $productProfit = DB::table('order_product')
            ->join('products', 'products.id', '=', 'order_product.product_id')
            ->join('orders', 'orders.id', '=', 'order_product.order_id')
            ->where('orders.is_demo', false)
            ->groupBy('products.id', 'products.name')
            ->selectRaw('products.id, products.name,
                SUM(order_product.price * order_product.count) as revenue,
                SUM(order_product.count * COALESCE(products.cost_price,0)) as cost,
                SUM(order_product.count) as units')
            ->get()
            ->map(function ($r) {
                $r->profit = (int) $r->revenue - (int) $r->cost;
                $r->margin = $r->revenue > 0 ? round($r->profit / $r->revenue * 100) : 0;
                return $r;
            });

        $topProfitProducts = $productProfit->sortByDesc('profit')->take(5)->values();
        $lossProducts      = $productProfit->filter(fn ($r) => $r->profit < 0)->sortBy('profit')->values();

        // پیشنهادها و هشدارهای هوشمند
        $suggestions = [];
        $missingCost = Product::where(fn ($q) => $q->whereNull('cost_price')->orWhere('cost_price', 0))->count();
        if ($missingCost > 0) {
            $suggestions[] = ['warning', '🧮', "برای {$missingCost} محصول «قیمت تمام‌شده» ثبت نشده است. با افزودن ریز متریال در تب پیشرفته‌ی محصول، سود واقعی دقیق محاسبه می‌شود."];
        }
        if ($lossProducts->isNotEmpty()) {
            $names = $lossProducts->take(3)->pluck('name')->implode('، ');
            $suggestions[] = ['danger', '⚠️', "{$lossProducts->count()} محصول زیر قیمت تمام‌شده فروخته شده‌اند ({$names}). قیمت فروش یا هزینه‌ی متریال را بازبینی کنید."];
        }
        if ($grossProfit > 0 && $totalExpenses > $grossProfit * 0.6) {
            $suggestions[] = ['danger', '📉', 'هزینه‌های جانبی بیش از ۶۰٪ سود ناخالص را می‌بلعند. برای افزایش سود خالص، هزینه‌های جانبی را کاهش دهید.'];
        }
        $lowMargin = $productProfit->filter(fn ($r) => $r->units > 0 && $r->margin > 0 && $r->margin < 15);
        if ($lowMargin->isNotEmpty()) {
            $suggestions[] = ['info', '📊', "{$lowMargin->count()} محصول حاشیه‌ی سود کمتر از ۱۵٪ دارند. با بازنگری قیمت‌گذاری می‌توانید سودآوری را بهبود دهید."];
        }
        if ($topProfitProducts->isNotEmpty()) {
            $best = $topProfitProducts->first();
            $suggestions[] = ['success', '⭐', "پرسودترین کالای شما «{$best->name}» با سود " . number_format($best->profit) . " تومان است. موجودی و تبلیغ این محصول را در اولویت بگذارید."];
        }

        return view('panel.dashborad.admin', [
            // فروش کل
            'totalSalesAmount' => (int) Order::sum('total'),
            'totalSalesCount'  => Order::count(),

            // فروش روز / هفته / ماه
            'salesToday'  => Order::whereDate('created_at', $today)->count(),
            'amountToday' => (int) Order::whereDate('created_at', $today)->sum('total'),
            'salesWeek'   => Order::where('created_at', '>=', $weekStart)->count(),
            'amountWeek'  => (int) Order::where('created_at', '>=', $weekStart)->sum('total'),
            'salesMonth'  => Order::where('created_at', '>=', $monthStart)->count(),
            'amountMonth' => (int) Order::where('created_at', '>=', $monthStart)->sum('total'),

            // شمارش‌ها
            'usersCount'      => User::count(),
            'productsCount'   => Product::count(),
            'categoriesCount' => Category::count(),
            'outOfStockCount' => Product::where('inventory', 0)->count(),

            // سفارش‌های ویژه
            'customOrdersCount'   => CustomOrder::count(),
            'pendingCustomOrders' => CustomOrder::where('status', 'pending')->count(),

            // سود و هزینه
            'totalCost'              => $totalCost,
            'grossProfit'            => $grossProfit,
            'totalExpenses'          => $totalExpenses,
            'netProfit'              => $netProfit,
            'monthlyExpenseEstimate' => $monthlyExpenseEstimate,

            // داده‌ی نمودار فروش ماهانه
            'monthlyLabels' => $monthlyLabels,
            'monthlyValues' => $monthlyValues,

            // تحلیل سود محصولات + پیشنهادها
            'topProfitProducts' => $topProfitProducts,
            'lossProducts'      => $lossProducts,
            'suggestions'       => $suggestions,

            // فهرست محصولات ناموجود
            'outOfStockProducts' => Product::where('inventory', 0)->latest('id')->take(12)->get(),

            // متولدین امروز + کوپن تولدشان (برای تشخیص ارسال پیامک)
            'birthdayUsers'    => $birthdayUsers = User::birthdayToday()->customersOnly()->get(),
            'birthdayVouchers' => \App\Models\Voucher::whereIn(
                    'code',
                    $birthdayUsers->map(fn ($u) => 'BDAY-' . $u->id . '-' . now()->year)->all()
                )->get()->keyBy('user_id'),
        ]);
    }
}
