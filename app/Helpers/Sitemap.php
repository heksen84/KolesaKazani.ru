<?php
 
namespace App\Helpers;
 
class Sitemap {

        private $sitemaps=array(
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
	);

        private static function addUrl($url) {
		
	if (file_exists($sitemaps[0])) {
	    $xml = simpleXML_load_file($sitemaps[0]); 
	}
	else

            return true;
        }

        private static function delUrl($url) {
            return true;
        }
}