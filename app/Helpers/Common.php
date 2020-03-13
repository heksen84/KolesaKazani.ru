<?php
 
namespace App\Helpers;
 
class Common {

    public static function getImagesPath() {
        return \Storage::disk("local")->url("app/images");
    }

}