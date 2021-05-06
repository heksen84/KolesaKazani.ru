<?php

include 'phpQuery.php';

$cookieJar = tempnam('/tmp', 'cookie');

$host1 = "https://salexy.kz";
$host2 = "https://shymkent.salexy.kz/catalog/info/phone/id/";

// Получаем cookie
$ch = curl_init($host1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
$page = curl_exec($ch);

$ch = curl_init("https://aksu.salexy.kz/c/prodam_nabor_shapka_sharf_5351019.html"); // Good
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
$page = curl_exec($ch);
$doc = phpQuery::newDocument($page);
$title = $doc->find('title')->text();
$id = $doc->find('.add')->attr('data-id');
$desc = $doc->find('.description p')->text();
$price = $doc->find('.control-holder .price')->text();
echo "\nid: ".$id;
echo "\nЗаголовок: ".str_replace("на Salexy.kz", "", $title);
echo "\nОписание: ".$desc;
echo "\nЦена: ".$price;

// Авторизованный запрос
$ch = curl_init($host2.$id);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Requested-With: XMLHttpRequest", "Content-Type: application/json; charset=utf-8"));
$page = curl_exec($ch);
$doc = phpQuery::newDocument($page);
$entry = $doc->find('a')->attr('href');
$tel = str_replace("tel:", "", $entry);
$tel = str_replace("+", "", $tel);
echo "\nТелефон: ".$tel;

if (strlen($tel) >  12) echo "\n-----------------------------\nСтранный номер - пропустить!\n-----------------------------";


curl_close($ch);

?>