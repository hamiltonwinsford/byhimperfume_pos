<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BundleItem extends Model
{
    use HasFactory;

    protected $table = 'bundle_items';

    protected $fillable = [
        'bundle_id',
        'product_id',
        'bottle_id',
        'quantity',
    ];

    public function bundle()
    {
        return $this->belongsTo(Bundle::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function bottle()
    {
        return $this->belongsTo(Bottle::class);
    }
}
