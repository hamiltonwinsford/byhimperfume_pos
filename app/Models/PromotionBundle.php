<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionBundle extends Model
{
    /**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $table   = "promotion_bundle";
}
