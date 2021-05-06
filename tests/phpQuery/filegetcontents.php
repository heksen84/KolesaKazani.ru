<?
$image = file_get_contents("https://frankfurt.apollo.olxcdn.com/v1/files/yw2w4bes7l1n-KZ/image;s=1000x700");
file_put_contents('olx_images/file.webp', $image);
?>