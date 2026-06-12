<?php

namespace App\Http\Controllers\Panel;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Exports\ExportProducts;
use Maatwebsite\Excel\Excel as Type;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Models\{Inventory, Product, Color, Size, Tag};
use App\Http\Requests\{ProductStoreRequest, ProductUpdateRequest};

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // todo get laracasts video from ostaaaad
        $products = $this->getProductsFromRequest($request);

        return view('panel.products.index', [
            'categories' => Category::get(),
            'products' => $products->paginate(15),
        ]);
    }

    public function create()
    {
        return view('panel.products.create', [
            'categories' => Category::get(),
            'colors' => Color::get(),
            'sizes' => Size::get(),
        ]);
    }

    public function store(Request $request)
    {
        $this->validateMedia($request);

        $product = Product::make($request->except(['tags', 'repeater_variety', 'media', 'delete_media']));

        $product->ensureUniqueSlug($request);

        $product->save();

        $this->handleMediaUpload($request, $product);

        if($request->tags) {

            $product->tags()->attach(Tag::findOrCreateFromRequest($request->tags));
        }


        $this->syncVariants($product, $request);

        $this->syncMaterials($product, $request);

        return to_route('admin.products.index')->with('swal', [
            'title' => 'موفقیت‌آمیز!',
            'message' => 'محصول '.$request->input('name').' باموفقیت ایجاد شد.',
            'icon' => 'success',
        ]);
    }

    /**
     * ساخت تنوع‌های محصول از روی فرم (سایز/رنگ به‌صورت نام، قیمت و تعداد per-variant).
     * سایز/رنگ جدید به‌صورت خودکار ساخته می‌شود و موجودی کل محصول = جمع تعداد تنوع‌ها.
     */
    protected function syncVariants(Product $product, Request $request): void
    {
        $varieties = $request->input('repeater_variety');

        if (! $varieties) {
            return;
        }

        $product->stocks()->delete();

        $total = 0;

        foreach ($varieties as $variety) {
            $sizeName  = trim($variety['size'] ?? '');
            $colorName = trim($variety['color'] ?? '');
            $count     = (int) ($variety['product_inventory'] ?? 0);
            $price     = (int) ($variety['price'] ?? 0);

            if ($sizeName === '' && $colorName === '' && $count === 0) {
                continue;
            }

            // سایز/رنگ خالی → مقدار پیش‌فرض تا قید NOT NULL جدول stocks رعایت شود
            $size  = \App\Models\Size::firstOrCreate(['name' => $sizeName !== '' ? $sizeName : 'تک‌سایز']);
            $color = \App\Models\Color::firstOrCreate(
                ['name' => $colorName !== '' ? $colorName : 'تک‌رنگ'],
                ['code' => '#cccccc']
            );

            $product->stocks()->create([
                'color_id' => $color->id,
                'size_id'  => $size->id,
                'price'    => $price > 0 ? $price : null,
                'count'    => $count,
            ]);

            $total += $count;
        }

        // موجودی کل محصول بر اساس جمع تنوع‌ها به‌روزرسانی می‌شود
        if ($total > 0) {
            $product->update(['inventory' => $total]);
        }
    }

    /**
     * ذخیره‌ی ریز متریال‌های محصول و محاسبه‌ی خودکار قیمت تمام‌شده.
     */
    protected function syncMaterials(Product $product, Request $request): void
    {
        $materials = $request->input('materials');

        $product->materials()->delete();

        if (! $materials) {
            return;
        }

        foreach ($materials as $m) {
            $name = trim($m['name'] ?? '');

            if ($name === '') {
                continue;
            }

            $product->materials()->create([
                'name'       => $name,
                'color'      => trim($m['color'] ?? '') ?: null,
                'weight'     => (int) ($m['weight'] ?? 0) ?: null,
                'quantity'   => max(1, (int) ($m['quantity'] ?? 1)),
                'unit_price' => (int) ($m['unit_price'] ?? 0),
            ]);
        }

        // قیمت تمام‌شده = جمع هزینه‌ی متریال‌ها
        $product->recomputeCostPrice();
    }

    public function show(Product $product)
    {
        $product->load(['category', 'images', 'stocks.color', 'stocks.size', 'tags', 'materials']);

        // تحلیل سود کلی
        $profit = $product->profitAnalysis();

        // فروش ماهانه (۱۲ ماه اخیر)
        $monthlySales = \Illuminate\Support\Facades\DB::table('order_product')
            ->join('orders', 'orders.id', '=', 'order_product.order_id')
            ->where('order_product.product_id', $product->id)
            ->where('orders.is_demo', false)
            ->where('orders.created_at', '>=', now()->subMonths(12))
            ->selectRaw("DATE_FORMAT(orders.created_at, '%Y-%m') as month,
                         SUM(order_product.count) as units,
                         SUM(order_product.price * order_product.count) as revenue")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $chartMonths  = $monthlySales->pluck('month')->toArray();
        $chartUnits   = $monthlySales->pluck('units')->map(fn ($v) => (int) $v)->toArray();
        $chartRevenue = $monthlySales->pluck('revenue')->map(fn ($v) => (int) $v)->toArray();

        // تنوع‌ها
        $variations = $product->stocks->map(function ($stock) use ($product) {
            return sprintf(
                'سایز: %s | رنگ: %s | قیمت: %s | تعداد: %s',
                optional($stock->size)->name ?? '—',
                optional($stock->color)->name ?? '—',
                number_format($stock->price ?: $product->price) . ' ت',
                $stock->count
            );
        })->implode('<br>');

        // ریز متریال‌ها
        $materialsHtml = '—';
        if ($product->materials->isNotEmpty()) {
            $rows = $product->materials->map(fn ($m) => sprintf(
                '<tr><td class="py-1">%s</td><td class="text-center">%s</td><td class="text-center">%s</td><td class="text-center">%s</td><td class="text-center">%s</td><td class="text-center fw-bold">%s</td></tr>',
                e($m->name), e($m->color ?: '—'), $m->weight ? $m->weight . 'g' : '—',
                $m->quantity, number_format($m->unit_price), number_format($m->line_cost)
            ))->implode('');
            $materialsHtml = '<table class="table table-sm table-row-bordered fs-7 mb-0"><thead><tr class="text-gray-500 fw-bold">'
                . '<th>متریال</th><th class="text-center">رنگ</th><th class="text-center">وزن</th><th class="text-center">تعداد</th><th class="text-center">قیمت واحد</th><th class="text-center">جمع</th></tr></thead><tbody>'
                . $rows . '</tbody></table>';
        }

        $items = [
            'نام'             => $product->name,
            'دسته‌بندی'       => optional($product->category)->name ?? '—',
            'قیمت فروش'       => number_format($product->price) . ' تومان',
            'تخفیف'           => $product->discount . '%',
            'موجودی'          => (int) $product->inventory > 0
                ? $product->inventory . ' عدد'
                : '<span class="badge badge-light-danger">ناموجود</span>',
            'SKU'             => $product->sku ?: '—',
            'بارکد'           => $product->barcode ?: '—',
            'وزن'             => $product->weight ? $product->weight . ' گرم' : '—',
            'وضعیت انتشار'     => $product->is_published ? 'منتشر شده' : 'پیش‌نویس',
            'تگ‌ها'           => $product->tags_string ?: '—',
            'تنوع‌ها'         => $variations ?: '—',
            'ریز مواد مصرفی'   => $materialsHtml,
            'توضیحات'         => $product->description ?: '—',
        ];

        return view('panel.products.show', [
            'product'      => $product,
            'profit'       => $profit,
            'chartMonths'  => $chartMonths,
            'chartUnits'   => $chartUnits,
            'chartRevenue' => $chartRevenue,
            'items'        => $items,
            'editUrl'      => route('admin.products.edit', $product),
            'backUrl'      => route('admin.products.index'),
            'breadcrumb'   => ['داشبورد' => route('admin.dashboard'), 'محصولات' => route('admin.products.index')],
        ]);
    }

    public function edit(Product $product)
    {
        return view('panel.products.edit', [
            'categories' => Category::get(),
            'sizes' => Size::get(),
            'colors' => Color::get(),
            'product' => $product,
            'varieties' => $product->stocks,
            'tags' => $product->tags,
        ]);
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        $this->validateMedia($request, $product);

        $product->fill($request->except(['tags', 'repeater_variety', 'media', 'delete_media']));
        $product->ensureUniqueSlug($request);
        $product->save();

        $this->handleMediaUpload($request, $product);

        if($request->tags) {
            $product->tags()->sync(Tag::findOrCreateFromRequest($request->tags));
        }

        $this->syncVariants($product, $request);

        $this->syncMaterials($product, $request);

        return to_route('admin.products.index')->with('swal', [
            'title' => 'موفقیت‌آمیز!',
            'message' => 'محصول '.$request->input('name').' باموفقیت ویرایش شد.',
            'icon' => 'success',
        ]);
    }
    public function destroy(Product $product)
    {
        $product->delete();

        return to_route('admin.products.index');
    }

    public function restore(Product $product)
    {
        $product->restore();

        return to_route('admin.products.index');
    }

    public function forceDelete(Product $product)
    {
        //todo delete images
        $product->tags()->delete();
        $product->stocks()->delete();
        $name = $product->name;
        $product->forceDelete();

        return to_route('admin.products.index')->with('swal', [
            'title' => 'موفقیت‌آمیز!',
            'message' => 'محصول '.$name.' باموفقیت حذف شد.',
            'icon' => 'success',
        ]);
    }

    public function export(Request $request)
    {
        $products = $this->getProductsFromRequest($request);
        $products = $products->get();

        return Excel::download(new ExportProducts($products), 'products.xlsx', Type::XLSX);

    }

    /**
     * اعتبارسنجی مدیای آپلودی (عکس/فیلم) و سقف ۵ مورد برای هر محصول.
     */
    protected function validateMedia(Request $request, ?Product $product = null): void
    {
        $request->validate([
            'media'   => ['nullable', 'array', 'max:' . Product::MAX_MEDIA],
            'media.*' => ['file', 'mimetypes:image/jpeg,image/png,image/jpg,image/webp,video/mp4,video/quicktime,video/webm', 'max:20480'],
        ], [], [
            'media'   => 'عکس/فیلم محصول',
            'media.*' => 'عکس/فیلم محصول',
        ]);

        // بررسی سقف نهایی پس از احتساب مدیای موجود و حذف‌شده‌ها
        $existing = $product ? $product->images()->count() : 0;
        $deleting = $product ? count((array) $request->input('delete_media', [])) : 0;
        $adding   = $request->hasFile('media') ? count($request->file('media')) : 0;

        if (($existing - $deleting + $adding) > Product::MAX_MEDIA) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'media' => 'هر محصول حداکثر می‌تواند ' . Product::MAX_MEDIA . ' عکس یا فیلم داشته باشد.',
            ]);
        }
    }

    /**
     * ذخیره‌ی مدیای جدید و حذف مدیای انتخاب‌شده برای حذف.
     * نوع هر فایل (عکس/فیلم) از روی mime تشخیص داده می‌شود و ترتیب نمایش حفظ می‌شود.
     */
    protected function handleMediaUpload(Request $request, Product $product): void
    {
        // حذف مدیای انتخاب‌شده
        if ($request->filled('delete_media')) {
            $product->images()
                ->whereIn('id', (array) $request->input('delete_media'))
                ->get()
                ->each
                ->delete();
        }

        if (! $request->hasFile('media')) {
            return;
        }

        $count    = $product->images()->count();
        $nextSort = (int) $product->images()->max('sort_order');

        foreach ($request->file('media') as $file) {
            if ($count >= Product::MAX_MEDIA) {
                break;
            }

            $isVideo = str_starts_with((string) $file->getMimeType(), 'video');
            $path    = $file->store('images/product', 'public');

            $product->images()->create([
                'path'       => $path,
                'type'       => $isVideo ? 'video' : 'image',
                'sort_order' => ++$nextSort,
            ]);

            $count++;
        }
    }

    protected function getProductsFromRequest($request)
    {
        return Product::query()
            ->when($request->trashed, fn ($q) => $q->onlyTrashed())
            ->when($request->search, fn ($q) => $q->search($request->search))
            ->when($request->filled('category'), fn ($q) => $q->where('category_id', $request->category))
            ->when($request->filled('is_published'), fn ($q) => $q->publishStatusProducts($request->input('is_published')))
            ->when($request->filled('is_healthy'), fn ($q) => $q->healtystatusProducts($request->input('is_healthy')));
    }

}
