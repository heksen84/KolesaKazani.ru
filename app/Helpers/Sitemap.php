<?php
 
namespace App\Helpers;


// Поисковик переиндексирует файл если изменилось поле <lastmod>

// класс для работы с sitemap.xml
class Sitemap {

    /*private $sitemaps=array(
	"sitemap001.xml",
	"sitemap002.xml",
	"sitemap003.xml",
	"sitemap004.xml",
	"sitemap005.xml",
	"sitemap006.xml",
	"sitemap007.xml",
	"sitemap008.xml",
	"sitemap009.xml",
	"sitemap010.xml",
	);*/

	private static $sitemap_index_file = "sitemaps/sitemap.xml";
	private static $sitemap_file = "sitemaps/sitemap.xml";
	private static $public_path = "damelya:90/obyavlenie/";

	// -------------------------------------
	// создать sitemap
	// -------------------------------------
	public static function createNew($old_filename) {			

		$new_sitemap_file = "sitemaps/new_sitemap.xml";

		$file = fopen($new_sitemap_file, "w");

		if (!$file) return false;
		
		// генерирую заголовок
		fwrite($file, '<?xml version="1.0" encoding="UTF-8"?>'."\n");
		fwrite($file, '<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">'."\n");
		fwrite($file, '</urlset>');
		fclose($file);

		$sitemap = simpleXML_load_file($new_sitemap_file);

		if (!$sitemap) 
			return false;
		
		Sitemap::$sitemap_file = $new_sitemap_file;

		\Debugbar::info("Сайтпап создан!");

		return $sitemap;
	}

	// -------------------------------------
	// добавить url
	// -------------------------------------
	public static function addUrl($url) {		

		// -------------------------------------------------
		// 1. открываем sitemap index
		// 2. Читаем кол-во записей берём последний
		// -------------------------------------------------
		if (file_exists(Sitemap::$sitemap_index_file)) {

			$sitemap_index = simpleXML_load_file(Sitemap::$sitemap_index_file);

			\Debugbar::info("Число записей в индексе sitemap :".$sitemap_index->count());

			if ($sitemap_index->count() > 0) {
				$rec = $sitemap_index->sitemap[$sitemap_index->count()-1];		
				$current_sitemap = $rec->loc;  

				\Debugbar::info("current_sitemap: ".$current_sitemap);
				$pos = strpos($current_sitemap, "sitemaps");
				\Debugbar::info("sitemap path string pos :".$pos);

			 	if ($pos>0)
			   	$current_sitemap = substr($current_sitemap, $pos, strlen($current_sitemap)-$pos);
			 	else {
					\Debugbar::info("Проблема sitemap substr");
					return false;
				}

				date_default_timezone_set("Asia/Almaty");

				// проверяем наличие файла
				if (file_exists($current_sitemap)) {
					
					if (filesize($current_sitemap)>=50000000) {

					// --------------------------------------------------
					// получаем имя прибавляем 1 проверяем наличие, 
					// записываем его имя в sitemap index
					// добавляем строку url в sitemap
					// --------------------------------------------------

			    }
			    // иначе добавляю
			    else {
						
						\Debugbar::info("Добавляю url в ".$current_sitemap."...");

						$sitemap = simpleXML_load_file($current_sitemap);

						$date_time = date("Y-m-d H:i:s");	
						$record = $sitemap->addChild("url");
						$record->addChild("loc", Sitemap::$public_path.$url);
						$record->addChild("lastmod", $date_time);			
						$record->addChild("changefreq", "daily");
						$record->addChild("priority", "2.0");

						$dom = new \DOMDocument("1.0", LIBXML_NOBLANKS);
						$dom->preserveWhiteSpace = false;
						$dom->formatOutput = true;
						$dom->loadXML($sitemap->asXML());
						$dom->saveXML();
						$dom->save($current_sitemap);

						$rec->lastmod = $date_time;
						$dom->loadXML($sitemap_index->asXML());
						$dom->saveXML();
						$dom->save(Sitemap::$sitemap_index_file);
		
						\Debugbar::info("url добавлен");
			    }
			}
			else {
			  \Debugbar::error($current_sitemap." не найден");			
			  return false;		
			}	
			  	
		}
		else {
			\Debugbar::error("Файл индекса sitemap.xml без записей");
			return false;		
		}
	}
	else {
		\Debugbar::error("Файл индекса sitemap.xml не найден");
		return false;
	}
}

// -------------------------------------------------
// удалить url в указанном sitemap'е
// -------------------------------------------------
public static function delUrl($url, $sitemap_file) {
    return true;
}

}