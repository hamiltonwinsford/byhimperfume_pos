<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $fillable = ['transaction_id', 'product_id', 'quantity', 'price', 'discount_amount', 'bottle_id'];
    protected $casts = [
        'quantity' => 'decimal:2', // Use consistent decimal precision
        'price' => 'decimal:2', // Use consistent decimal precision
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2', // Make sure discount amounts are in the same format as prices
    ];

    // Relationship with Transaction
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    // Relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // // Calculated subtotal (not stored in DB, computed on the fly)
    // public function getSubtotalAttribute()
    // {
    //     return ($this->price - $this->discount_amount) * $this->quantity;
    // }
}
