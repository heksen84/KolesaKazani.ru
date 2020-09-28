<?php
 
namespace App\Helpers;
 
class Common {

    public static function getImagesPath() {
         return "https://ilbo.object.pscloud.io/images";
    }

    public static function getFreeDiskSpace($target) {

	    $bytes = disk_free_space($target); 
	    $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
	    $base = 1024;
	    $class = min((int)log($bytes , $base) , count($si_prefix) - 1);
	    $free_space = sprintf("%1.0f", $bytes / pow($base,$class));
//	    echo $free_space.' '.$si_prefix[$class];
	    return $free_space;
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