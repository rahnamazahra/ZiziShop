<?php

namespace App\Domains\User\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
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
}