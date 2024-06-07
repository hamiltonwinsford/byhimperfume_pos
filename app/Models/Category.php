<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'fragrances_status',
    ];

    const STATUS_FRAGRANCE = 1;
    const STATUS_NOT_FRAGRANCE = 0;

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
