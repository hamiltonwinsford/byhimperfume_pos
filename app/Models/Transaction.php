<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_number',
        'transaction_date',
        'user_id',
        'customer_id',
        'branch_id',
        'total_amount',
        'discount',
        'payment_method',
    ];

    // Relasi dengan TransactionItem
    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relasi dengan Branch
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

}
