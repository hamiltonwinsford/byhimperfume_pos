<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    use HasFactory;

    protected $table = 'bundles';

    protected $fillable = [
        'name',
        'description',
        'discount_percent',
    ];

    public function items()
    {
        return $this->hasMany(BundleItem::class);
    }
}
