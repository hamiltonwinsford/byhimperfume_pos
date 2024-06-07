<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FirstStock extends Model
{
    /**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $table   = "first_stock";
}
