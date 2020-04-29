import $ from "jquery";
import bootstrap from "bootstrap";

// инициализация карты
function initMaps() {

	// координаты по умолчанию для всех карт
	let mapCoords = [window.coord_lat, window.coord_lon];
	let map = new ymaps.Map("map", { center: mapCoords, zoom: 10 });
	let myPlacemark;

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
	$("#carousel").carousel();


	// -------------------------------------------------------------
    // оплата
    // -------------------------------------------------------------
    $(".actions button").click(function(item) {         
                        
        let title_text="";
        let desc="";
        let price=0;

        //current_advert_id = $(this).parent().data("id");
        
        switch($(this).index()) {
            case 0: {
                title_text = "Срочно, торг";
                desc = "Объявление будет...";
                price = 100;
                break;
            }
            case 1: { 
                title_text = "Продлить"; 
                desc = "Объявление будет...";
                price = 200;
                break;
            }
            case 2: { 
                title_text = "Поднять в топ";
                desc = "Объявление будет..."; 
                price = 300;
                break;
            }
            case 3: { 
                title_text = "Покрасить"; 
                desc = "Объявление будет...";
                price = 400;
                break;
            }
            case 4: {                 
               // $("#delete_advert_window").modal("show");
                break;
            }
		}        
		

		alert(title_text);

    /*    if ($(this).index()!=4) {
            $("#payment_window_title").text(title_text);
            $("#desc").text(desc);
            $("#price").text(price);
            $("#payment_window").modal("show");
        }
     */           
	});
	
});

// обработчик клика
document.body.addEventListener('click', function (evt) {

	// вернуться назад
	if (evt.target.classList[0] === 'return-link')
		window.history.back();	

	// кнопка - показать номер
	if (evt.target.id==="numberButton") {
		
		let xhr = new XMLHttpRequest();		
		xhr.open('GET', '/api/getPhoneNumber?id='+window.advert_id, true);		
		xhr.onload = function () {

		if (xhr.status != 200)
			alert( xhr.status + ': ' + xhr.statusText );		
			else 
			{			
				document.getElementById("numberButton").style.display = "none";
				document.getElementById("phone-number").style.display = "block";
				document.getElementById("phone-number").innerHTML = "<b>тел: <a href='tel:+7"+JSON.parse(xhr.responseText)[0].phone+"'>+7 "+JSON.parse(xhr.responseText)[0].phone+"</a></b><br>Скажите продавцу, что нашли это объявление на сайте объявлений <b>Ильбо</b>.";
			}
			
		}

		xhr.send();				
		
	}

}, false);
