<?php
 
namespace App\Helpers;
 
class Common {

    public static function getPreviewImage($advert_id) {          
        return "(SELECT concat(url,'/small/', name) FROM `images` JOIN storages ON storages.id = images.storage_id WHERE images.advert_id = ".$advert_id." LIMIT 1) as imageName";                        
    }

    public static function getFreeDiskSpace($target) {
	    $bytes = disk_free_space($target); 
	    $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
	    $base = 1024;
	    $class = min((int)log($bytes , $base) , count($si_prefix) - 1);
	    $free_space = sprintf("%1.0f", $bytes / pow($base,$class));
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