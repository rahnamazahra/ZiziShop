<?php

namespace App\Models;

use App\Casts\JalaliDate;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\{MorphOne, BelongsTo, BelongsToMany, HasMany};

class User extends Authenticatable
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

}
