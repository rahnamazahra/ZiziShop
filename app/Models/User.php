<?php

namespace App\Models;

use App\Casts\JalaliDate;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'mobile',
        'birthday',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'mobile_verified_at' => 'datetime',
        'password' => 'hashed',
        'birthday' => JalaliDate::class,
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

    public function isAdmin($userId)
    {
        $user = $this->find($userId);
        $roles = $user->roles->whereIn('name', ['developer', 'admin']);

        return $roles->count() > 0;
    }
    
}
