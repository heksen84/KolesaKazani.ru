<?php
// ----------------------------------
// функции общего назначения
 // ----------------------------------

namespace App\Helpers;
 
class Common {

    // минимальное количество места на диске для сохранения изображений
    const MIN_FREE_DISK_SPACE_IN_GB = 5; // гига    
    const SMALL_IMAGES_LOCAL_STORAGE_PATH  = "storage/app/images/normal/";
    const NORMAL_IMAGES_LOCAL_STORAGE_PATH = "storage/app/images/small/";

    // сободное место на диске
    public static function getFreeDiskSpace($target) {        
        $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
        $bytes = disk_free_space($target); 	    
	    $base = 1024;
	    $class = min((int)log($bytes , $base) , count($si_prefix) - 1);
	    $free_space = sprintf("%1.0f", $bytes / pow($base, $class));
	    return $free_space;
    }

    // аватарка для результатов поиска
    public static function getPreviewImage($advert_id) {          
        return "(SELECT concat(url,'/small/', name) FROM `images` JOIN storages ON storages.id = images.storage_id WHERE images.advert_id = ".$advert_id." LIMIT 1) as imageName";                        
    }       

    public static function getVipPrice() { return 100; }
    public static function getSrochnoTorgPrice() { return 200; }
    public static function getColorPrice() { return 300; }

}