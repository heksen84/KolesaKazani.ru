<?php

$cookieJar = tempnam('/tmp', 'cookie');

$host1 = "https://market.kz";
$host2 = "https://market.kz/a/iphone-6s-pluse-104926232/";

// Получаем cookie
$ch = curl_init($host1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
$page = curl_exec($ch);


// {"refresh_token":"17fc86b790b70526e138334e977c27f7c53599a0","grant_type":"refresh_token","scope":"i2 read write v2","client_id":"100302","client_secret":"dHXhnUG4QDkQ3Btx07EgdZGOYydoccbtZBE5ROlNTycHxs2W"}

// Авторизованный запрос
$ch = curl_init($host2);
//curl_setopt($ch, CURLOPT_POSTFIELDS, "id=104926232"); 
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Requested-With: XMLHttpRequest", "Content-Type: application/json; charset=utf-8"));
$page = curl_exec($ch);

echo $page;

curl_close($ch);

?>