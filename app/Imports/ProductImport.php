<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $validator = Validator::make($row->toArray(), [
                'name' => 'required',
                'description' => 'required',
                'price' => 'required|numeric',
                'category_id' => 'required',
                'branch_id' => 'required',
                'status' => 'required|boolean',
                'is_favorite' => 'required|boolean',
                'stock' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                continue;
            }

            // Check if product already exists by Product ID
            $product = Product::find($row['id']);  // Check if Product ID exists
            if ($product) {
                // If product exists, update it
                $product->update($row->toArray());
            } else {
                // If product does not exist, create a new one
                Product::create($row->toArray());
            }
        }
    }
}
