<?php
 
namespace App\Helpers;

// Поисковик переиндексирует файл если изменилось поле <lastmod>
// класс для работы с sitemap.xml
class Sitemap {

	private static $public_path = "/objavlenie/show/";
	private static $sitemaps_path = "sitemaps/";
	private static $index_file_name = "index.xml";

	// ------------------------------------------------
	// создать sitemap
	// ------------------------------------------------
	public static function createNewSitemap($current_sitemap, $sitemap_index, $date_time) {		

		$sitemap_num = strpos($current_sitemap, "p_"); // sitema(p_)1
		$sitemap_ext = strpos($current_sitemap, ".");  // .xml		
		$length = $sitemap_ext-$sitemap_num-2;
   		$snum = substr($current_sitemap, $sitemap_num+2, $length);
		$nextval = intval($snum)+1;
		$new_name = Sitemap::$sitemaps_path."sitemap_".$nextval.".xml";

		$file = fopen($new_name, "w");
		
		if (!$file) 
			return false;

		// генерирую заголовок
		fwrite($file, '<?xml version="1.0" encoding="UTF-8"?>'."\n");
		fwrite($file, '<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">'."\n");
		fwrite($file, '</urlset>');
		fclose($file);

		if ($current_sitemap!="sitemaps/sitemap_0.xml") {
		                
			// добавляю запись в сайтмап индекс
			$record = $sitemap_index->addChild("sitemap");
			$record->addChild("loc", config('app.url')."/".$new_name);
			$record->addChild("lastmod", $date_time);			

			$dom = new \DOMDocument("1.0", LIBXML_NOBLANKS);

			$dom->preserveWhiteSpace = false;
			$dom->formatOutput = true;	

			if (!$dom->loadXML($sitemap_index->asXML()))
	 			return false;
	
			if (!$dom->save(Sitemap::$sitemaps_path.Sitemap::$index_file_name))
				 return false;			 
		}

		return $new_name;
	}

	// --------------------------------------
	// создать индекс
	// --------------------------------------
	public static function createIndex() {		

		$file = fopen(Sitemap::$sitemaps_path.Sitemap::$index_file_name, "w");		

		if (!$file) 
			return false;
		
//		$date_time = date(\DateTime::ISO8601);
		$date_time = date("Y-m-d");

		fwrite($file, '<?xml version="1.0" encoding="UTF-8"?>'."\n");
		fwrite($file, '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n");
		fwrite($file, '<sitemap>'."\n");
    	fwrite($file, '<loc>'.config('app.url').'/'.Sitemap::$sitemaps_path.'sitemap_1.xml</loc>'."\n");
    	fwrite($file, '<lastmod>'.$date_time.'</lastmod>'."\n");
    	fwrite($file, '<changefreq>hourly</changefreq>'."\n");
		fwrite($file, '</sitemap>'."\n");
		fwrite($file, '</sitemapindex>');
		
		fclose($file);

		return true;
	}
	
	
	// --------------------------------------
	// добавить url
	// --------------------------------------
	public static function addUrl($url) {

		date_default_timezone_set("Asia/Almaty");

		// нет файла индекса - создаю
		if (!file_exists(Sitemap::$sitemaps_path.Sitemap::$index_file_name) && Sitemap::createIndex()) {

			\Debugbar::info("создаю индекс!");			
			Sitemap::addUrl($url);			
		}
		else {
				$sitemap_index = simpleXML_load_file(Sitemap::$sitemaps_path.Sitemap::$index_file_name);					
				$sitemapRecord = $sitemap_index->sitemap[$sitemap_index->count()-1];		
				$current_sitemap = $sitemapRecord->loc;  				
				$sitemapPos = strpos($current_sitemap, "sitemaps");				

			 	if ($sitemapPos>0)
			   		$current_sitemap = substr($current_sitemap, $sitemapPos, strlen($current_sitemap)-$sitemapPos);
			 	else {
					\Debugbar::info("Проблема sitemap substr");
					return false;
				}

				\Debugbar::info("CURRENT_SITEMAP: ".$current_sitemap);

				// проверяем наличие файла
				if (file_exists($current_sitemap)) {        			
					
					//$date_time = date(\DateTime::ISO8601);
					$date_time = date("Y-m-d");

					$sitemap_created=false;

					// если sitemap больше или равен 50 мб. то ...
				  	if (filesize($current_sitemap)>=50000000) {
					//	if (filesize($current_sitemap)>=500) {
					 	$current_sitemap = Sitemap::createNewSitemap($current_sitemap, $sitemap_index, $date_time);
					 
						 if ($current_sitemap!=false)
							$sitemap_created=true;						
					}			   						
					
					\Debugbar::info("Добавляю url в ".$current_sitemap."...");

					$sitemap = simpleXML_load_file($current_sitemap);

					$record = $sitemap->addChild("url");
					$record->addChild("loc", config('app.url').Sitemap::$public_path.$url);
					$record->addChild("lastmod", $date_time);			

					/*
					 NEVER: Old news stories, press releases, etc
					 YEARLY: Contact, “About Us”, login, registration pages
					 MONTHLY: FAQs, instructions, occasionally updated articles
					 WEEKLY: Product info pages, website directories
					 DAILY: Blog entry index, classifieds, small message board
					 HOURLY: Major news site, weather information, forum
					 ALWAYS: Stock market data, social bookmarking categories
					*/
					
					$record->addChild("changefreq", "daily");
					
					/*
					 0.8-1.0: Homepage, subdomains, product info, major features, major category pages.
					 0.4-0.7: Articles and blog entries, minor category pages, sub-category pages, FAQs
					 0.0-0.3: Outdated news, info that has become irrelevant
					*/
	
					$record->addChild("priority", "0.8");

					$dom = new \DOMDocument("1.0", LIBXML_NOBLANKS);
					$dom->preserveWhiteSpace = false;
					$dom->formatOutput = true;
					$dom->loadXML($sitemap->asXML());
					$dom->saveXML();
					$dom->save($current_sitemap);

					// обновляю дату в индексе
					if (!$sitemap_created) {
					  $sitemapRecord->lastmod = $date_time;
					  $dom->loadXML($sitemap_index->asXML());
					  $dom->saveXML();
					  $dom->save(Sitemap::$sitemaps_path.Sitemap::$index_file_name);
					}
		
					\Debugbar::info("url добавлен");
			}
			else {
			  
				\Debugbar::error($current_sitemap." не найден\n Создаю...");			
				
				$newSitemapName = Sitemap::createNewSitemap("sitemaps/sitemap_0.xml", simpleXML_load_file(Sitemap::$sitemaps_path.Sitemap::$index_file_name), date(\DateTime::ISO8601));

			  	if ($newSitemapName) {
			  		Sitemap::addUrl($url);
				 	// Здесь нужно добавить новый сайтмап в таблицу sitemaps с именем $newSitemapName
				}
			  	
				  return false;		
			}				  	
	}	
}

// -------------------------------------------------
// удалить url в указанном sitemap'е
// -------------------------------------------------
public static function delUrl($url, $sitemap_file) {
    return true;
}

}