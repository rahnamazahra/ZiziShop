<?php

namespace App\Models;

use Cryptommer\Smsir\Smsir;
use Illuminate\Support\Facades\Cache;
use Cryptommer\Smsir\Objects\Parameters;
use Illuminate\Notifications\Notification;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\{MorphOne, BelongsTo, BelongsToMany, HasMany};
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{

    use SoftDeletes;
    use Notifiable;


    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'mobile',
        'birthday',
        'password',
        'province_id',
        'city_id',
    ];

    protected static function booted(): void
    {
        // همگام‌سازی نام نمایشی از نام و نام خانوادگی هنگام ذخیره
        static::saving(function (User $user) {
            if ($user->first_name || $user->last_name) {
                $user->name = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
            }
        });
    }

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'mobile_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

       /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoriteProducts()
    {
        return $this->belongsToMany(Product::class, 'favorites', 'user_id', 'product_id')->withTimestamps();
    }

    public function city():BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function province()
    {
        // little bit hacky
        return $this->hasOneThrough(
            Province::class,
            City::class,
            'id',
            'id',
            'city_id',
            'province_id',
        );
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function getWalletAttribute()
    {
        return $this->wallet()->firstOrCreate([]);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function isAdmin($userId)
    {
        $user = $this->find($userId);
        $roles = $user->roles;

        return $roles->count() > 0;
    }

    public static function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%$search%")
              ->orWhere('mobile', 'like', "%$search%")
              ->orWhereHas('city', function ($c) use ($search) {
                  $c->where('name', 'like', "%$search%")
                    ->orWhereHas('province', fn ($p) => $p->where('name', 'like', "%$search%"));
              });
        });
    }

    /**
     * فقط کاربران عادی (بدون نقش ادمین).
     */
    public static function scopeCustomersOnly($query)
    {
        return $query->whereDoesntHave('roles', fn ($q) => $q->where('name', 'admin'));
    }

    /**
     * کاربرانی که امروز (روز و ماه) تولدشان است.
     */
    public static function scopeBirthdayToday($query)
    {
        return $query->whereNotNull('birthday')
            ->whereMonth('birthday', now()->month)
            ->whereDay('birthday', now()->day);
    }

    public function getCartAttribute()
    {
        return $this->cart()->firstOrCreate();
    }

    public function routeNotificationForVonage(Notification $notification): string
    {
        return $this->mobile;
    }

    public function sendSmsCodeVerify($mobile)
    {
        $verificationCode = random_int(100000, 999999);
        session()->put('verification_code', $verificationCode);

        $name = "Code";
        $value = $verificationCode;
        $templateId = 100000;

        $parameter = new Parameters($name, $value);
        $parameters = array($parameter);
        $send = smsir::Send();

        $send->Verify($mobile, $templateId, $parameters);

        Cache::put('last_sent_time_' . $mobile, now(), 1);

    }

    public function checkSendingSmsCodeVerify()
    {
        $lastSentTime = Cache::get('last_sent_time_' . $this->mobile);
        if ($lastSentTime && now()->diffInMinutes($lastSentTime) < 1) {
            return true;
        }

       $this->sendSmsCodeVerify($this->mobile);
    }


}
