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
        'name',
        'mobile',
        'birthday',
        'password',
        'province_id',
        'city_id',
    ];

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
        return $query->where('name', 'like', "%$search%")
               ->orWhere('mobile', 'like', "%$search%");
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
