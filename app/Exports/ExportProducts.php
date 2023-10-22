<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportProducts implements FromCollection, WithHeadings, WithMapping
{
    protected $products;

    public function __construct($products)
    {
        $this->products = $products;
    }

    public function collection()
    {
        return $this->products;
    }

    public function headings(): array
    {
        return [
            'نام',
        ];

    }

    public function map(mixed $product): array
    {
        return [
            $product->name,
            $product->sku,
            $product->slug,
            $product->barcode,
            $product->category->name,
            $product->price,
            $product->description,
            $product->inventory,
            $product->is_healthy ? 'سالم' : 'ایرادجزئی',
            $product->is_published ? 'انتشار' : 'عدم‌انتشار',
            $product->weight,
            $product->width,
            $product->length,
        ];
    }
}
