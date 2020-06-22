<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Images extends Model {
    public $timestamps = false;
    protected $fillable = ['advert_id', 'name'];
}
