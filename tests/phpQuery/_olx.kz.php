<?php

include 'phpQuery.php';

$cookieJar = tempnam('/tmp', 'cookie');


/*
	Электроника
	Дом и сад
	Мода и стиль
	Детский мир
	Хобби отдых и спорт
	Животные
	Услуги

	1. Сканируем объявления за текущий день
	2. Смотрим есть ли оно в базе olx_id, market_id, ...
	3. Если нету - парсим и вносим на сайт

	https://www.olx.kz/elektronika/aksu_5689/
	https://www.olx.kz/elektronika/aksu_5689/?page=2

	elektronika/telefony-i-aksesuary
	elektronika/telefony-i-aksesuary/zapchasti-dlya-telefonov
	elektronika/telefony-i-aksesuary/aksessuary-dlya-telefonov
	elektronika/telefony-i-aksesuary/mobilnye-telefony-smartfony
	elektronika/telefony-i-aksesuary/sim-karty-tarify-nomera
	elektronika/telefony-i-aksesuary/statsionarnye-telefony
	elektronika/telefony-i-aksesuary/ratsiyi-i-prochie-telefony

	elektronika/kompyutery-i-komplektuyuschie
	elektronika/kompyutery-i-komplektuyuschie/nastolnye-kompyutery
	elektronika/kompyutery-i-komplektuyuschie/komplektuyuschie-i-aksesuary
	elektronika/kompyutery-i-komplektuyuschie/periferiynye-ustroystva
	elektronika/kompyutery-i-komplektuyuschie/monitory
	elektronika/kompyutery-i-komplektuyuschie/vneshnie-nakopiteli
	elektronika/kompyutery-i-komplektuyuschie/rashodnye-materialy
	elektronika/kompyutery-i-komplektuyuschie/drugoe

*/

/*
{"device_id":"739cd004-e31d-4b39-9929-51af70f332b4",
"device_token":"eyJpZCI6IjczOWNkMDA0LWUzMWQtNGIzOS05OTI5LTUxYWY3MGYzMzJiNCJ9.1c708a862296849262e8236c28f8eae902235e2c",
"grant_type": "device", "scope":"i2 read write v2", 
"client_id":"100302",
"client_secret":"dHXhnUG4QDkQ3Btx07EgdZGOYydoccbtZBE5ROlNTycHxs2W"}
*/

// Получить текущий токен
function getToken($clientSecret) {

 $ch = curl_init("https://www.olx.kz/api/open/oauth/token/");
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
 curl_setopt($ch, CURLOPT_POST, 1);
 curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
 curl_setopt($ch, CURLOPT_POSTFIELDS, '{
				      "device_id":"739cd004-e31d-4b39-9929-51af70f332b4", 
				      "device_token":"eyJpZCI6IjczOWNkMDA0LWUzMWQtNGIzOS05OTI5LTUxYWY3MGYzMzJiNCJ9.1c708a862296849262e8236c28f8eae902235e2c",
				      "grant_type":"device",
				      "scope":"i2 read write v2",
				      "client_id":"100302",
				      "client_secret":"'.$clientSecret.'"
				      }');
 $page = curl_exec($ch);

 return $page;
}


// при открытии объявления
// https://www.olx.kz/api/open/oauth/token/
// request {"refresh_token":"42309399ffaa297dc8f3e42b68ff7005f0cdb50b","grant_type":"refresh_token","scope":"i2 read write v2","client_id":"100302","client_secret":"dHXhnUG4QDkQ3Btx07EgdZGOYydoccbtZBE5ROlNTycHxs2W"}
// response {"access_token":"71bb709b22d4c58b2ac94aaced3b38b7744502e2","expires_in":86400,"token_type":"bearer","scope":"i2 read write v2","refresh_token":"42309399ffaa297dc8f3e42b68ff7005f0cdb50b"}
// Обновить токен
function getAccessToken($refreshToken, $clientSecret) {

 $ch = curl_init("https://www.olx.kz/api/open/oauth/token/");
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
 curl_setopt($ch, CURLOPT_POST, 1);
 curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
 curl_setopt($ch, CURLOPT_POSTFIELDS, '{"refresh_token":"42309399ffaa297dc8f3e42b68ff7005f0cdb50b","grant_type":"refresh_token","scope":"i2 read write v2","client_id":"100302","client_secret":"dHXhnUG4QDkQ3Btx07EgdZGOYydoccbtZBE5ROlNTycHxs2W"}');
 $page = curl_exec($ch);

 return $page;
}

echo "\n-----------------------------------------\n";
echo  $cookieJar;
echo "\n-----------------------------------------\n";

$baseHost = "https://olx.kz";
$numberUrl = "https://www.olx.kz/api/v1/offers/300846889/phones/";

// Получаем cookie
$ch = curl_init($baseHost);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
$page = curl_exec($ch);
//echo $page;

$token = getToken("dHXhnUG4QDkQ3Btx07EgdZGOYydoccbtZBE5ROlNTycHxs2W");
//$token = getToken("4fae323ac73cd14a4e3e89e21accc912d535a4bd");

$json = json_decode($token);

if ($json->error === "invalid_client" || $json->error === "invalid_grant") {
 echo "Ошибка получения токена";
 curl_close($ch);
 return;
}

echo $token."\n";
$hours = json_decode($token)->expires_in/3600;
echo "Осталось: ".$hours." часа\n";

//$authorization = "Authorization: Bearer d7e58168d75ff7e7f364e1185a7b9f5c63fe0026";
$authorization = "Authorization: Bearer 4fae323ac73cd14a4e3e89e21accc912d535a4bd";
//$authorization = "Authorization: Bearer ".json_decode($token)->access_token;

// Авторизованный запрос
$ch = curl_init($numberUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Requested-With: XMLHttpRequest", "Content-Type: application/json", $authorization));
$page = curl_exec($ch);
//echo "\n".$page."\n\n";

$json = json_decode($page);
echo "Номер: ".str_replace(" ", "", $json->data->phones[0]);

//echo $page;

curl_close($ch);