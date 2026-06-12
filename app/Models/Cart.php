<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'gateway_ref',
        'address_id',
        'voucher_id',
        'user_id',
        'session_token',
    ];

    /**
     * Resolve the active cart for the current visitor (logged-in OR guest).
     * Guests get a cart keyed by a session token, so add-to-cart works without login.
     */
    public static function current(): self
    {
        if (auth('web')->check()) {
            return auth('web')->user()->cart;
        }

        $token = session('cart_token');
        if (! $token) {
            session(['cart_token' => $token = (string) \Illuminate\Support\Str::uuid()]);
        }

        return static::firstOrCreate(['session_token' => $token]);
    }

    /**
     * Read-only lookup of an existing cart (never creates one) — for the mini-cart.
     */
    public static function existing(): ?self
    {
        if (auth('web')->check()) {
            return auth('web')->user()->cart;
        }

        $token = session('cart_token');

        return $token ? static::where('session_token', $token)->first() : null;
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('count', 'stock_id');
    }

    /**
     * افزودن محصول با تنوع (سایز/رنگ) انتخاب‌شده به سبد.
     * موجودی هنگام ثبت سفارش کم می‌شود، نه اینجا.
     */
    public function addVariant(Product $product, ?int $stockId, int $qty = 1): void
    {
        $existing = $this->products()->where('product_id', $product->id)->first();

        if ($existing) {
            $this->products()->updateExistingPivot($product->id, [
                'count'    => $existing->pivot->count + $qty,
                'stock_id' => $stockId,
            ]);
        } else {
            $this->products()->attach($product->id, ['count' => $qty, 'stock_id' => $stockId]);
        }
    }

    /**
     * قیمت واحدِ مؤثرِ یک قلم سبد (قیمت تنوع در صورت انتخاب، وگرنه قیمت پایه).
     */
    public function lineUnitPrice($product): int
    {
        if ($product->pivot->stock_id) {
            $stock = Stock::find($product->pivot->stock_id);
            if ($stock && $stock->price) {
                return (int) $stock->price;
            }
        }

        return (int) $product->price;
    }

    public function address():BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function vouch(String $code)
    {
        $voucher = Voucher::whereCode($code)
            ->where('remaining', '>', 0)
            // کوپن عمومی یا متعلق به همین کاربر
            ->where(function ($q) {
                $q->whereNull('user_id')->orWhere('user_id', auth('web')->id());
            })
            // در بازه‌ی اعتبار (یا بدون تاریخ پایان)
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhereDate('end_date', '>=', now()->toDateString());
            })
            ->firstOrFail();

        // کوپن مخصوص یک محصول → آن محصول باید در سبد باشد
        if ($voucher->product_id && ! $this->products()->where('products.id', $voucher->product_id)->exists()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'code' => 'این کوپن فقط برای یک محصول خاص است که در سبد شما نیست.',
            ]);
        }

        $this->voucher()->associate($voucher)->push();
        $voucher->decrement('remaining');
    }

    public function reset()
    {
        $this->products()->detach();
        $this->update([
            'gateway_ref' => null,
            'address_id' => null,
            'voucher_id' => null,
        ]);
    }

    public function add(Product $product)
    {
        // افزودن ساده (بدون تنوع)؛ موجودی هنگام ثبت سفارش کم می‌شود
        if ((int) $product->inventory > 0) {
            $this->addVariant($product, null, 1);
        }
    }

    public function getCountAttribute()
    {
        return $this->products->sum('pivot.count');
    }

    /**
     * سبد مهمان را به سبد کاربر لاگین‌شده ادغام می‌کند.
     * پس از ادغام، سبد مهمان حذف می‌شود.
     */
    public static function mergeGuestIntoUser(string $guestToken, User $user): void
    {
        $guestCart = static::where('session_token', $guestToken)
            ->with('products')
            ->first();

        if (! $guestCart || $guestCart->products->isEmpty()) {
            $guestCart?->delete();
            return;
        }

        $userCart = $user->cart;

        foreach ($guestCart->products as $product) {
            $userCart->addVariant($product, $product->pivot->stock_id, (int) $product->pivot->count);
        }

        $guestCart->products()->detach();
        $guestCart->delete();
    }

    public function remove(Product $product)
    {
       $this->products()->detach($product);
    }

    public function increase(Product $product)
    {
        $item = $this->products()->whereId($product->id)->first();
        if ($item) {
            $item->pivot->increment('count');
        } else {
            $this->products()->attach($product, ['count' => 1]);
        }
    }

    public function decrease(Product $product)
    {
        $item = $this->products()->whereId($product->id)->first();
        if ($item) {
            if ($item->pivot->count > 1) {
                $item->pivot->decrement('count');
            } else {
                $this->products()->detach($product);
            }
        }
    }

    public function getRawTotalAttribute()
    {
        return $this->products->reduce(function ($carry, $next) {
            return $carry + $next->pivot->count * $this->lineUnitPrice($next);
        });
    }

    public function getTotalAttribute()
    {
        $total = $this->raw_total;

        if ($this->voucher) {
            if ($this->voucher->product_id) {
                // کوپن مخصوص یک محصول: تخفیف فقط روی همان قلم
                $line = $this->products->firstWhere('id', $this->voucher->product_id);
                if ($line) {
                    $lineSubtotal = $line->price * $line->pivot->count;
                    $total -= $this->voucher->amount
                        ? min((int) $this->voucher->amount, (int) $lineSubtotal)
                        : $lineSubtotal * $this->voucher->discount_percent / 100;
                }
            } elseif ($this->voucher->amount) {
                // تخفیف مبلغی ثابت روی کل سبد
                $total -= min((int) $this->voucher->amount, (int) $total);
            } else {
                $total -= $total * $this->voucher->discount_percent / 100;
            }
        }

        return max(0, (int) $total);
    }



}
