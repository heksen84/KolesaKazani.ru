<?php

include 'phpQuery.php';

// Данные клиента
$clientId = "100302"; // Из первого запроса токена в браузере
$clientSecret = "dHXhnUG4QDkQ3Btx07EgdZGOYydoccbtZBE5ROlNTycHxs2W"; // Из первого запроса токена в браузере
$refreshToken = "5ecaa241c0a5079625cfa1fbc608141fda424ebc"; // Из первого запроса токена в браузере
$deviceId = "c073d2b0-96ab-497a-89e0-e2bf335d2f09";
$deviceToken = "eyJpZCI6ImMwNzNkMmIwLTk2YWItNDk3YS04OWUwLWUyYmYzMzVkMmYwOSJ9.e578f578f2de49d846e0be2a2c399bb78153c63c";
// grand_type: "device"
 
// Обновить токен
function getAccessToken($refreshToken, $clientSecret, $clientId, $cookie) {

 $ch = curl_init("https://www.olx.kz/api/open/oauth/token/");
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
 curl_setopt($ch, CURLOPT_POST, 1);
 curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
 curl_setopt($ch, CURLOPT_POSTFIELDS, '{"refresh_token":"'.$refreshToken.'","grant_type":"refresh_token","scope":"i2 read write v2","client_id":"'.$clientId.'","client_secret":"'.$clientSecret.'"}');
 $page = curl_exec($ch); 
 curl_close($ch);
 return $page;
}

function getPhone($advertId, $cookie, $token) {

 $ch = curl_init("https://www.olx.kz/api/v1/offers/".$advertId."/phones/");
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
 curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Requested-With: XMLHttpRequest", "Content-Type: application/json", "Authorization: Bearer ".json_decode($token)->access_token));
 $page = curl_exec($ch); 
 curl_close($ch);
 return $page;
}

function getPage($url, $cookie) {

 $ch = curl_init($url);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
 $page = curl_exec($ch); 
 curl_close($ch);
 return $page;
}

function getTitle($page) {
 $doc = phpQuery::newDocument($page);
 return $doc->find("h1")->text();
}

function getDesc($page) {
 $doc = phpQuery::newDocument($page);
 return $doc->find('#textContent')->text();
}

function getPrice($page) {
 $doc = phpQuery::newDocument($page);
 $price = $doc->find('.pricelabel strong')->eq(0)->text();
 $price = str_replace("тг.", "", $price);
 $price = str_replace(" ", "", $price);
 return $price;
}

function getId($page) {
 $doc = phpQuery::newDocument($page);
 return $doc->find('.offer-bottombar__item strong')->eq(2)->text();
}

function getImage($page) {
 $doc = phpQuery::newDocument($page);
 return $doc->find('#descImage img')->attr("src");
}

function getImageName($page) {
 $doc = phpQuery::newDocument($page);
 return $doc->find('#descImage img')->attr("alt");
}


// функция создания объявления
function createAdvert($advertId, $title, $desc, $price, $phoneNumber, $images, $categoryId, $subCategoryId, $regionId, $placeId) {

 echo $advertId."\n";
 echo $title."\n";
 echo $desc."\n";
 echo $price."\n";
 echo "Номер: ".$phoneNumber."\n";
 echo $images."\n";
 echo $categoryId."\n";
 echo $subCategoryId;
}

 $cookie = tempnam('/tmp', 'cookie');
 $token = getAccessToken($refreshToken, $clientSecret, $clientId, $cookie); 

 echo $token."\n";
 echo (json_decode($token)->expires_in/3600)." часов осталось\n";

 //return;

// $page = getPage("https://www.olx.kz/elektronika/kompyutery-i-komplektuyuschie/nastolnye-kompyutery/aksu_5689/", $cookie);
 $page = getPage("https://www.olx.kz/elektronika/telefony-i-aksesuary/mobilnye-telefony-smartfony/aksu_5689/", $cookie);

 echo "ok!\n";

 $doc = phpQuery::newDocument($page);

 $title = $doc->find('title')->text();
 $items = $doc->find('h3 a');

 foreach($items as $item) { 

  $page = getPage(pq($item)->attr("href"), $cookie);
  
//  echo $page;
//  return;

  $id = trim(getId($page));
  $title = trim(getTitle($page));

  $desc =  trim(getDesc($page));

  $desc =  str_replace("Показать номер",  "", $desc);
  $desc =  str_replace("877",  "", $desc);
  $desc =  str_replace("870",  "", $desc);
  $desc =  str_replace("+777",  "", $desc);
  $desc =  str_replace("+ 777",  "", $desc);
  $desc =  str_replace("+770",  "", $desc);
  $desc =  str_replace("Звонить по номеру",  "", $desc);
  $desc =  str_replace("-  - ,  -  -",  "", $desc);
  $desc =  str_replace("-  -",  "", $desc);

  $price = trim(getPrice($page));

 // price может быть Обмен

  $phone = json_decode(getPhone($id, $cookie, $token))->data->phones[0];   

  $phone = str_replace("[",  "", $phone);
  $phone = str_replace("]",  "", $phone);
  $phone = str_replace("(",  "", $phone);
  $phone = str_replace(")",  "", $phone);
  $phone = str_replace(" ",  "", $phone);
  $phone = str_replace("-",  "", $phone);
  $phone = str_replace("+7", "", $phone);
  $phone = str_replace("+",  "", $phone);

  if ($phone[0] === "8") {
//	echo "!!!\n";
	$phone = substr($phone, 1);
  }

  $image = file_get_contents(getImage($page));
  file_put_contents('olx_images/'.getImageName($page).".webp", $image);

  if ($phone != "") {
    $images = 0;
    createAdvert($id, $title, $desc, $price, $phone, $images, 0, 0, 0, 0);
  }

 }

?>