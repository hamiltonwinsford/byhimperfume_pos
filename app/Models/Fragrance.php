<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fragrance extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'concentration',
        'bottle_id',
        'gram',
        'mililiter',
        'pump_weight',
        'bottle_weight',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'bottle_id');
    }
}
