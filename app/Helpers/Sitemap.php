<?php
 
namespace App\Helpers;

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

	private static $sitemap_file = "sitemaps/sitemap.xml";
	private static $public_path = "https://damelya.kz/obyablenie/";

	// добавить url
	public static function addUrl($url) {

		// 1. Открыть файл
		// 2. Если его нет создать и открыть
		
		if (file_exists(Sitemap::$sitemap_file)) {
			
			$sitemap = simpleXML_load_file(Sitemap::$sitemap_file);
			
			\Debugbar::info("Sitemap загружен");
			\Debugbar::info("Всего элементов:".$sitemap->count());

			date_default_timezone_set("Asia/Almaty");

			$record = $sitemap->addChild("url");
			$record->addChild("loc", Sitemap::$public_path.$url);
			$record->addChild("lastmod", date("Y-m-d H:i:s"));			
			$record->addChild("changefreq", "daily");
			$record->addChild("priority", "2.0");

			$dom = new \DOMDocument("1.0", LIBXML_NOBLANKS);
			$dom->preserveWhiteSpace = false;
			$dom->formatOutput = true;
			$dom->loadXML($sitemap->asXML());
			$dom->saveXML();
			$dom->save(Sitemap::$sitemap_file);

			return true;
		}
		else {
			\Debugbar::info("файл не найден");
			return false;
		}
    }

	// удалить url
	public static function delUrl($url) {
        return true;
    }
}