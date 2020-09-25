<?php
 
namespace App\Helpers;
 
class Common {

//    public static function getImagesPath($storage_id) {
    public static function getImagesPath() {

/*	if ($storage_id===0)
         return "https://ilbo.object.pscloud.io/images";

	if ($storage_id===1)
         return "---";      */
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