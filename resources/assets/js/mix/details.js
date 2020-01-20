function initMaps() {

    console.log(window.coord_lat+"\n"+window.coord_lon)

	// координаты по умолчанию для всех карт
	let mapCoords = [window.coord_lat, window.coord_lon];

	let map = new ymaps.Map("map", { center: mapCoords, zoom: 10 });
	
	// включаю скролл на карте
	map.behaviors.enable("scrollZoom");
			
	// формирую метки
	myPlacemark = new ymaps.Placemark(mapCoords);	

	// добавляю метки на карты
    map.geoObjects.add(myPlacemark);	

}

// document ready
document.addEventListener('DOMContentLoaded', function(){ // Аналог $(document).ready(function(){
     
    ymaps.ready(initMaps);  

});