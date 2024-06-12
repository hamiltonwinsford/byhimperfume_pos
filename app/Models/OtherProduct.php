<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtherProduct extends Model
{
    /**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $table   = "other_product";

    protected $fillable = [
        'product_name',
        'base_price',
        'sale_price',
        'product_description',
        'image',
    ];

}
