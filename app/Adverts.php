<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adverts extends Model {
   /* protected $fillable = [
        'user_id', 'title', 'text', 'contacts', 'price', 'category_id', 'ad_category_id', 'date_reg'
    ];*/
    
     protected $dates = ['created_at'];
}
