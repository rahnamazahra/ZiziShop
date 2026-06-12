<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use App\Traits\HasDemoFlag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Order extends Model
{
    use HasFactory;
    use HasDemoFlag;


    protected $fillable = [
        'user_id',
        'voucher_id',
        'shipping_fee',
        'total',
        'address_text',
        'postal_tracking',
        'is_demo',
    ];

    protected $casts = [
        'order-status' =>OrderStatusEnum::class
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('count', 'price', 'color_id', 'size_id');
    }

    public function pivotColorName($product): string
    {
        return optional(\App\Models\Color::find($product->pivot->color_id))->name ?? '—';
    }

    public function pivotSizeName($product): string
    {
        return optional(\App\Models\Size::find($product->pivot->size_id))->name ?? '—';
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);

    }

    /**
     * ساخت سفارش از روی سبد خرید (مشترک بین پرداخت درگاهی و پرداخت کامل با کیف پول).
     *
     * @param  int     $walletUsed     مبلغ پرداخت‌شده از کیف پول
     * @param  string  $gateway        نام درگاه (یا 'wallet')
     * @param  string  $trackingCode   کد پیگیری پرداخت
     */
    public static function createFromCart(User $user, Cart $cart, int $walletUsed, string $gateway, string $trackingCode): self
    {
        return \Illuminate\Support\Facades\DB::transaction(function () use ($user, $cart, $walletUsed, $gateway, $trackingCode) {
            $address     = $cart->address;
            $addressText = $address
                ? sprintf(
                    'گیرنده: %s | موبایل: %s | کد ملی: %s | استان/شهر: %s / %s | کد پستی: %s | آدرس: %s',
                    $address->receiver,
                    $address->mobile,
                    $address->national_code,
                    optional(optional($address->city)->province)->name,
                    optional($address->city)->name,
                    $address->postal_code,
                    $address->body
                )
                : '-';

            $order = $user->orders()->create([
                'voucher_id'   => $cart->voucher_id,
                'shipping_fee' => 3500,
                'total'        => $cart->total,
                'address_text' => $addressText,
            ]);

            $cart->products->each(function ($product) use ($order, $cart) {
                $count     = (int) $product->pivot->count;
                $unitPrice = $cart->lineUnitPrice($product);

                // قفل ردیف محصول — جلوگیری از race condition روی موجودی
                $lockedProduct = Product::lockForUpdate()->find($product->id);

                if ((int) $lockedProduct->inventory < $count) {
                    throw new \RuntimeException("موجودی محصول «{$lockedProduct->name}» برای تعداد درخواست‌شده کافی نیست.");
                }

                $stock = null;
                if ($product->pivot->stock_id) {
                    $stock = Stock::lockForUpdate()->find($product->pivot->stock_id);
                    if ($stock && (int) $stock->count < $count) {
                        throw new \RuntimeException("موجودی تنوع انتخابی از محصول «{$lockedProduct->name}» کافی نیست.");
                    }
                }

                $order->products()->attach($product, [
                    'count'    => $count,
                    'price'    => $unitPrice,
                    'color_id' => optional($stock)->color_id,
                    'size_id'  => optional($stock)->size_id,
                ]);

                if ($stock) {
                    $stock->decrement('count', $count);
                }
                $lockedProduct->decrement('inventory', $count);
            });

            $order->payment()->create([
                'user_id'       => $user->id,
                'total'         => max(0, (int) $cart->total - $walletUsed),
                'gateway'       => $gateway,
                'tracking_code' => $trackingCode,
            ]);

            return $order;
        });
    }
}
