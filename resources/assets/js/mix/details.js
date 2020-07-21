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
$( document ).ready(function() {	         
    
    ymaps.ready(initMaps);

    $("#carousel").carousel();    

    $("#makeVip").click(function(item) {
                
        $(".modal-title").text("В топ");
        $(".modal-body p").text("Ссылку на ваше объявление увидят все посетители сайта. Она будет первой в горячих предложениях, пока кто-либо не займет это место.");
        $(".modal-body h5").text(window.vip_price+" ₸");
        $("#billingModalDialog").modal("show");
        $("#continueBilling").off().click(function(item) {
        	$.ajax({
                url: "/objavlenie/makeExtend/"+window.advert_id+"/makeVip",
                type: "POST",
                data: {"_token": $('meta[name="csrf-token"]').attr('content')},
                success: function (response) {
                    $("#billingModalDialog").modal("hide");   
                }
            });            
        });        	
    });

    
    $("#makeTorg").click(function(item) {
        
        $(".modal-title").text("Срочно");
        $(".modal-body p").text("Ваше объявление украсит флажок со словами «Срочно, торг».");        
        $(".modal-body h5").text(window.srochno_torg_price+" ₸");
        $("#billingModalDialog").modal("show");
        $("#continueBilling").off().click(function(item) {
            $.ajax({
                url: "/objavlenie/makeExtend/"+window.advert_id+"/srochno_torg",
                type: "POST",
                data: {"_token": $('meta[name="csrf-token"]').attr('content')},
                success: function (response) {
                    $("#billingModalDialog").modal("hide");
                }
            });           
        });        
    });    

    $("#makePaint").click(function(item) {

        $(".modal-title").text("Выделить");
        $(".modal-body p").text("Цветное объявление намного заметнее в общем списке.");
        $(".modal-body h5").text(window.color_price+" ₸");
        $("#billingModalDialog").modal("show");
        $("#continueBilling").off().click(function(item) {
            $.ajax({
                url: "/objavlenie/makeExtend/"+window.advert_id+"/makePaint",
                type: "POST",
                data: {"_token": $('meta[name="csrf-token"]').attr('content')},
                success: function (response) {
                    $("#billingModalDialog").modal("hide");
                }
            });
        });        
    });

    $("#prodlit").click(function(item) {

        $("#billingModalDialog").modal("show"); // отобразить окно
        /*$.ajax({
            url: "/objavlenie/makeExtend/"+window.advert_id+"/prodlit",
            type: "POST",
            data: {"_token": $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {                
            }
        });        */
    });
	
});

// ---------------------------------------------------------
// обработчик клика
// ---------------------------------------------------------
document.body.addEventListener('click', function (evt) {

	// закрыть страницу
	if (evt.target.classList[0] === 'close-link')        
        window.location="/";

	// кнопка - показать номер
	if (evt.target.id==="numberButton") {
		
		let xhr = new XMLHttpRequest();		
		xhr.open('GET', '/api/getPhoneNumber?id='+window.advert_id, true);		
		xhr.onload = function () {

		if (xhr.status != 200)
			alert( xhr.status + ': ' + xhr.statusText );		
			else {			
				document.getElementById("numberButton").style.display = "none";
                document.getElementById("phone-number").style.display = "block";
                // удаляю лишние символы для ссылки с набором номера
                let hRefTel = JSON.parse(xhr.responseText)[0].phone.split('(').join('').split(')').join('').split(' ').join('').split('-').join('');
				document.getElementById("phone-number").innerHTML = "<b>тел: <a href='tel:+7"+hRefTel+"'>+7 "+JSON.parse(xhr.responseText)[0].phone+"</a></b><br>Скажите продавцу, что нашли это объявление на сайте объявлений <b>Ильбо</b>.";
			}
			
		}

		xhr.send();				
		
	}

}, false);
