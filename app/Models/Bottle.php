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

    // Accessor for variant
    public function getVariantTextAttribute()
    {
        switch ($this->variant) {
            case 'edp':
                return 'Eau de Perfume';
            case 'edt':
                return 'Eau de Toilette';
            case 'perfume':
                return 'Perfume';
            case 'full_perfume':
                return 'Full Perfume';
            default:
                return $this->variant;
        }
    }
}
