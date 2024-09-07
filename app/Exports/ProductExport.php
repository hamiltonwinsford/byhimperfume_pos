<?php

namespace App\Exports;

use App\Models\Product;
use Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings
{
    protected $branch_id;

    public function __construct($branch_id = null)
    {
        $this->branch_id = $branch_id;
    }

    public function collection()
    {
        $query = Product::leftJoin('fragrances', 'products.id', '=', 'fragrances.product_id')
            ->select(
                'products.id',
                'products.name',
                'products.description',
                'products.price',
                'products.category_id',
                'products.branch_id',
                'products.status',
                'products.is_favorite',
                'fragrances.name as fragrances_name',
                'fragrances.total_weight',
                'fragrances.gram_to_ml',
                'fragrances.ml_to_gram',
                'fragrances.gram',
                'fragrances.mililiter',
                'fragrances.pump_weight',
                'fragrances.bottle_weight',
                'products.stock'
            );

        if ($this->branch_id) {
            // Jika branch_id ada, filter berdasarkan cabang tersebut
            $query->where('products.branch_id', $this->branch_id);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID Product',
            'Product Name',
            'Description',
            'Price',
            'Category ID',
            'Branch ID',
            'Status',
            'Is Favorite',
            'Fragrance Name',
            'Total Weight',
            'Gram to ML',
            'ML to Gram',
            'Gram',
            'Milliliter',
            'Pump Weight',
            'Bottle Weight',
            'Stock'
        ];
    }
}

