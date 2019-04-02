<?php
 
namespace App\Helpers;


// Поисковик переиндексирует файл если изменилось поле <lastmod>

// класс для работы с sitemap.xml
class Sitemap {

	private static $sitemaps = "sitemaps/";
	private static $public_path = "damelya:90/obyavlenie/";
	private static $sitemap_index_file = "sitemaps/_sitemap.xml";

	// ------------------------------------------------
	// создать sitemap
	// ------------------------------------------------
	public static function createNew($current_sitemap, $sitemap_index, $date_time) {

	$sitemap_num = strpos($current_sitemap, "p_"); // sitema(p_)1
	$sitemap_ext = strpos($current_sitemap, ".");  // .xml

	// нужно определить длину вырезаемого числа
	$length = $sitemap_ext-$sitemap_num-2;

	\Debugbar::info("LENGTH :".$length);

   	$snum = substr($current_sitemap, $sitemap_num+2, $length);
	$nextval = intval($snum)+1;

        \Debugbar::info("NEXTVAL :".$nextval);

	$new_name = Sitemap::$sitemaps."sitemap_".$nextval.".xml";

	$file = fopen($new_name, "w");

	if (!$file) 
		return false;

	// генерирую заголовок
	fwrite($file, '<?xml version="1.0" encoding="UTF-8"?>'."\n");
	fwrite($file, '<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">'."\n");
	fwrite($file, '</urlset>');
	fclose($file);

	$record = $sitemap_index->addChild("sitemap");

	$record->addChild("loc", "damelya:90/".$new_name);
	$record->addChild("lastmod", $date_time);			

	$dom = new \DOMDocument("1.0", LIBXML_NOBLANKS);

	$dom->preserveWhiteSpace = false;
	$dom->formatOutput = true;	

	if (!$dom->loadXML($sitemap_index->asXML()))
	 return false;
	
	if (!$dom->save(Sitemap::$sitemap_index_file))
	 return false;

	return $new_name;

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

        \Debugbar::info("OKK");
					
					$date_time = date(\DateTime::ISO8601);

					$sitemap_created=false;

					// если sitemap больше или равен 50 мб. то ...
//					if (filesize($current_sitemap)>=1) {
				        if (filesize($current_sitemap)>=50000000) {
					 $current_sitemap = Sitemap::createNew($current_sitemap, $sitemap_index, $date_time);
					 if ($current_sitemap!=false)
					  $sitemap_created=true;
					}			   						
					
					\Debugbar::info("Добавляю url в ".$current_sitemap."...");

					$sitemap = simpleXML_load_file($current_sitemap);

					$record = $sitemap->addChild("url");
					$record->addChild("loc", Sitemap::$public_path.$url);
					$record->addChild("lastmod", $date_time);			
					$record->addChild("changefreq", "hourly");
					$record->addChild("priority", "0.8");

					$dom = new \DOMDocument("1.0", LIBXML_NOBLANKS);
					$dom->preserveWhiteSpace = false;
					$dom->formatOutput = true;
					$dom->loadXML($sitemap->asXML());
					$dom->saveXML();
					$dom->save($current_sitemap);

					// обновляю дату в индексе
					if (!$sitemap_created) {
					  $rec->lastmod = $date_time;
					  $dom->loadXML($sitemap_index->asXML());
					  $dom->saveXML();
					  $dom->save(Sitemap::$sitemap_index_file);
					}
		
					\Debugbar::info("url добавлен");
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