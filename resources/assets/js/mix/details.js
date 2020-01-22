// инициализация карты
function initMaps() {

	// координаты по умолчанию для всех карт
	let mapCoords = [window.coord_lat, window.coord_lon];
	let map = new ymaps.Map("map", { center: mapCoords, zoom: 10 });

	// включаю скролл на карте
	map.behaviors.enable("scrollZoom");

	// формирую метку
	myPlacemark = new ymaps.Placemark(mapCoords);

	// добавляю метки на карты
	map.geoObjects.add(myPlacemark);
	
}

// document ready
document.addEventListener('DOMContentLoaded', function() {	     
	ymaps.ready(initMaps);
	console.log(window.advert_id);
});

// обработчик клика
document.body.addEventListener('click', function (evt) {

	// кнопка - показать номер
	if (evt.target.id==="showNumberBtn") {

		let xhr = new XMLHttpRequest();
		xhr.open('GET', '/api/getPhoneNumber?id='+window.advert_id, false);		
		xhr.send();		

		if (xhr.status != 200)
			alert( xhr.status + ': ' + xhr.statusText );
		else {						  
			console.log( "+7 "+JSON.parse(xhr.responseText)[0].phone );
		}
		
	}

}, false);