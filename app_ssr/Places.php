<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Places extends Model
{
    protected $table = 'kz_city';
    protected $primaryKey = 'city_id';
	public $timestamps = false;
}
