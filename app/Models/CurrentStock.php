<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrentStock extends Model
{
    // Mass assignable attributes to allow filling the model
    protected $fillable = ['product_id', 'current_stock', 'current_stock_gram'];

    // Define the relationship with the Product model
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
