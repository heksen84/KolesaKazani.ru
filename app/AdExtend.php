<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdExtend extends Model {
    protected $fillable = ["advert_id", "srochno_torg", "v_top", "color", "startDate", "finishDate"];
    protected $table = 'ad_extend';
    public $timestamps = false;
}
