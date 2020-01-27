<?php
 
namespace App\Helpers;
 
class Common {
    public static function getImagePath() {      
        return \Storage::disk("local")->url('app/images/preview/');
    }

}