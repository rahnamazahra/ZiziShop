<?php

namespace App\Models;

use App\Casts\JalaliDate;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\{MorphOne, BelongsTo, BelongsToMany};
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;

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
        'birthday' => JalaliDate::class,
    ];

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'favorites');
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
}
