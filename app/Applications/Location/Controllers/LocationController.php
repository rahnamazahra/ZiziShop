<?php
namespace App\Applications\Location\Controllers;

use App\Support\Responses\ApiResponse;
use App\Domains\Location\Services\LocationService;

class LocationController
{
    public function __construct(
        protected LocationService $service
    ) {}

    public function provinces()
    {
        $provinces = $this->service->getProvinces();
        return ApiResponse::success('لیست استان‌ها', ['provinces' => $provinces]);
    }

    public function cities(int $provinceId)
    {
        $cities = $this->service->getCitiesByProvince($provinceId);
        return ApiResponse::success('لیست شهرها', ['cities' => $cities]);
    }
}
