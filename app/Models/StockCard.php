<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'branch_id',
        'fragrance_id',
        'opening_stock_gram',
        'restock_gram',
        'sales_ml',
        'calc_g',
        'calc_ml',
        'real_g',
        'real_ml',
        'difference_g',
        'difference_ml',
        'stock_opname_date',
    ];

    // Relationships (define as needed)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function fragrance()
    {
        return $this->hasOneThrough(Fragrance::class, Product::class, 'id', 'product_id', 'product_id', 'id');
    }

    // Accessors/Mutators (optional, for data formatting or conversion)
    // Example:
    // public function getSalesMlAttribute($value)
    // {
    //     return $value / 1000; // Convert ml to liters
    // }
}
