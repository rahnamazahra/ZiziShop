<?php

namespace App\Casts;

use Morilog\Jalali\Jalalian;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class JalaliDate implements CastsAttributes
{

    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return Jalalian::fromCarbon(Carbon::parse($value))->format('Y/m/d');
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return Jalalian::fromFormat('Y/m/d', $value)->toCarbon()->format('Y-m-d');
    }
}
