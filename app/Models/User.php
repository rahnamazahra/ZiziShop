<?php

namespace App\Models;

use App\Casts\{cityName, JalaliDate, provinceName};
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
        'province_id' => provinceName::class,
        'city_id' => cityName::class,
    ];

    public function file(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable');
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

    public function province():BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function isAdmin($userId)
    {
        $user = $this->find($userId);
        $roles = $user->roles;

        return $roles->count() > 0;
    }

    public static function search($query)
    {
        return self::whereNull('deleted_at')
               ->where('name', 'like', "%$query%")
               ->orWhere('mobile', 'like', "%$query%")
               ->select(['id', 'name', 'mobile', 'birthday', 'province_id', 'city_id'])
               ->orderBy('id', 'DESC')
               ->paginate(15)
               ->withQueryString();
    }
}
