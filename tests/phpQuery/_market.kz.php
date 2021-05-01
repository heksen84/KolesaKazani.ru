<?php
// {"refresh_token":"17fc86b790b70526e138334e977c27f7c53599a0","grant_type":"refresh_token","scope":"i2 read write v2","client_id":"100302","client_secret":"dHXhnUG4QDkQ3Btx07EgdZGOYydoccbtZBE5ROlNTycHxs2W"}
include 'phpQuery.php';

$cookieJar = tempnam('/tmp', 'cookie');

$baseHost = "https://market.kz";
$numberUrl = "https://market.kz/ajax/load-phones/";

// Получаем cookie
$ch = curl_init($baseHost);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
$page = curl_exec($ch);
//echo $page;

// Авторизованный запрос
$ch = curl_init($numberUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
curl_setopt($ch, CURLOPT_POSTFIELDS, "id=103274550");
curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Requested-With: XMLHttpRequest", "Content-Type: application/x-www-form-urlencoded"));
$page = curl_exec($ch);

//echo $page;

$page = str_replace("[", "", $page);
$page = str_replace("]", "", $page);
$page = str_replace("(", "", $page);
$page = str_replace(")", "", $page);
$page = str_replace(" ", "", $page);
$page = str_replace("-", "", $page);
//$page = str_replace("+7", "", $page);

$json = json_decode($page);
//echo var_dump(json_decode($json, true));
echo $json->phone;

curl_close($ch);