<?php
namespace App\Domains\Location\Services;

use App\Domains\Location\Repositories\LocationRepository;

class LocationService
{
    public function __construct(
        protected LocationRepository $repository
    ) {}

    public function getProvinces()
    {
        return $this->repository->getProvinces();
    }

    public function getCitiesByProvince(int $provinceId)
    {
        return $this->repository->getCitiesByProvince($provinceId);
    }
}
