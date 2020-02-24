<?php
 
namespace App\Helpers;
 
class Common {

    public static function getImagePath($imageType) {
              
        if ($imageType=="small")
            $imagePath = 'app/images/small/';

        if ($imageType=="normal")
            $imagePath = 'app/images/normal/';            

        return \Storage::disk("local")->url($imagePath);
    }

}