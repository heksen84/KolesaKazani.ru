<?php
 
namespace App\Helpers;
 
class Common {

    public static function getImagesPath() {
        //return \Storage::disk("local")->url("app/images");
//        return \Storage::disk("s3")->url("images");
        return "https://ilbo.object.pscloud.io/images";

    }

    public static function getVipPrice() {
	return 100;
    }

    public static function getSrochnoTorgPrice() {
	return 200;
    }

    public static function getColorPrice() {
	return 300;
    }

}