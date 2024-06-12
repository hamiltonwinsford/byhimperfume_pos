<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'stock',
        'status',
        'is_favorite',
        'category_id',
        'branch_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function fragrance()
    {
        return $this->hasOne(Fragrance::class, 'product_id');
    }
    
    public function branch()
    {
        return $this->belongsTo(Branch::class); 
    }
}
