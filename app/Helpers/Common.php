<?php
// ----------------------------------
// функции общего назначения
 // ----------------------------------

namespace App\Helpers;
 
class Common {

    // минимальное количество места на диске для сохранения изображений
    const MIN_FREE_DISK_SPACE_IN_GB = 1255; // гига

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

    // путь до хранилища
    public static function getStoragePath() {

        // если места на диске мало
        if (self::getFreeDiskSpace(".") < self::MIN_FREE_DISK_SPACE_IN_GB) {
            \Debugbar::info("маловато места");
            return "https://ilbo.object.pscloud.io/images";
        }
        else 
            // если много            
            return "storage/app/images";
    }

    public static function getVipPrice() { return 100; }
    public static function getSrochnoTorgPrice() { return 200; }
    public static function getColorPrice() { return 300; }

}