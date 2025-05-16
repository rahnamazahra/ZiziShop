<?php
namespace App\Domains\Location\Repositories;

use App\Models\City;
use App\Models\Province;

class LocationRepository
{
    public function getProvinces()
    {
        return Province::select('id', 'name')->get();
    }

    public function getCitiesByProvince(int $provinceId)
    {
        return City::where('province_id', $provinceId)->select('id', 'name')->get();
    }
}