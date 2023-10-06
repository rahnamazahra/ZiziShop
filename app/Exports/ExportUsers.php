<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportUsers implements FromCollection, WithHeadings, WithMapping
{
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function collection()
    {
        return $this->users;
    }

    public function headings(): array
    {
        return [
            'نام و نام خانوادگی',
            'تلفن',
            'شهر',
            'استان',
            'تاریخ تولد',
        ];

    }

    public function map(mixed $user): array
    {
        return [
            $user->name,
            $user->mobile,
            $user->province_id ?? '-',
            $user->city_id ?? '-',
            $user->birthday ?? '-',
        ];
    }
}
