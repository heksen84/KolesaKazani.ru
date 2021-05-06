<?php

/*$cookieJar = tempnam('/tmp', 'cookie');

$host1 = "https://salexy.kz";
$host2 = "https://shymkent.salexy.kz/catalog/info/phone/id/5746231";

// Получаем cookie
$ch = curl_init($host1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
$page = curl_exec($ch);


// {"refresh_token":"17fc86b790b70526e138334e977c27f7c53599a0","grant_type":"refresh_token","scope":"i2 read write v2","client_id":"100302","client_secret":"dHXhnUG4QDkQ3Btx07EgdZGOYydoccbtZBE5ROlNTycHxs2W"}

// Авторизованный запрос
$ch = curl_init($host2);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($ch, CURLOPT_GET, true); 
//curl_setopt($ch, CURLOPT_POSTFIELDS, $postData); 
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Requested-With: XMLHttpRequest", "Content-Type: application/json; charset=utf-8"));
$page = curl_exec($ch);

echo $page;
curl_close($ch);*/

	// Include the phpQuery library
	// Download at http://code.google.com/p/phpquery/
	include 'phpQuery.php';

	echo "-------------------------\n";
	echo "-- Salexy parser v 1.0 --\n";
	echo "-------------------------\n";
	echo "Получаю данные...";



/*	$placesArray = [
        "https://astana.salexy.kz/",
	"https://almaty.salexy.kz/",
	"https://pavlodar.salexy.kz/",
	"https://ekibastuz.salexy.kz/",
	"https://ust-kamenogorsk.salexy.kz/",
	"https://shymkent.salexy.kz/",
	"https://aktobe.salexy.kz/",
	"https://karaganda.salexy.kz/"
	];

	foreach($placesArray as $place) {
	    echo $place."\n";
	}*/


	$categoriesArray = [
	"avtomobili_i_motocikly",
	"nedvizhimost",
	"rabota",
	"dlya_biznesa",
	"yelektronnaya_tehnika",
	"uslugi"
	];

	

	// Create array to hold stats
	$stats = array();

	$cookieJar = tempnam('/tmp', 'cookie');

	foreach($categoriesArray as $category) {

	$ch = curl_init();	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
	curl_setopt($ch, CURLOPT_URL, 'https://astana.salexy.kz/'.$category);	

	$html = curl_exec($ch);
	curl_close($ch);

	// Create phpQuery document with returned HTML
	$doc = phpQuery::newDocument($html);

	$items = $doc->find('.title a').find();

/*	$ch = curl_init(pq($item)->attr("href")); // Good
	$page = curl_exec($ch);
	$doc = phpQuery::newDocument($page);
	$title = $doc->find('title')->text();
	$id = $doc->find('.add')->attr('data-id');
	$desc = $doc->find('.description p')->text();
	$price = $doc->find('.control-holder .price')->text();

	
	$ch = curl_init("https://astana.salexy.kz/catalog/info/phone/id/".$id);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Requested-With: XMLHttpRequest", "Content-Type: application/json; charset=utf-8"));
	$page = curl_exec($ch);
	$doc = phpQuery::newDocument($page);
	$entry = $doc->find('a')->attr('href');
	$tel = str_replace("tel:", "", $entry);
	$tel = str_replace("+", "", $tel);

	if (strlen($tel) >  12) echo "\n-----------------------------\nСтранный номер - пропустить!\n-----------------------------";*/


	foreach ($items as $item) {
	  $stats["titles"][] = pq($item)->text();	
	  $stats["hrefs"][] = pq($item)->attr("href");	
//	  $stats["phones"][] = $tel;	
	} 


	}

	print_r($stats);

/*	$entry = $doc->find('time');

	foreach ($entry as $row) {
	  $stats['date'][] = pq($row)->text();
	}

	print_r($stats);*/