<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bottle extends Model
{
    use HasFactory;

    protected $table = 'bottle';

    protected $fillable = [
        'bottle_name',
        'bottle_size',
        'bottle_type',
        'harga_ml',
        'variant'
    ];

    public function bundleItems()
    {
        return $this->hasMany(BundleItem::class, 'bottle_id');
    }
}
