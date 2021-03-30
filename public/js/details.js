webpackJsonp([7],{

/***/ "./resources/assets/js/mix/details.js":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_jquery__ = __webpack_require__("./node_modules/jquery/dist/jquery.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_jquery___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_jquery__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_bootstrap__ = __webpack_require__("./node_modules/bootstrap/dist/js/bootstrap.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_bootstrap___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_bootstrap__);



// --------------------------------------------
// инициализация карты
// --------------------------------------------
function initMaps() {

    // координаты по умолчанию для всех карт
    var mapCoords = [window.coord_lat, window.coord_lon];
    var map = new ymaps.Map("map", { center: mapCoords, zoom: 10 });
    var myPlacemark = void 0;

    // включаю скролл на карте
    map.behaviors.enable("scrollZoom");

    // формирую метку
    myPlacemark = new ymaps.Placemark(mapCoords);

    // добавляю метки на карты
    map.geoObjects.add(myPlacemark);
}

// --------------------------------------------
// document ready
// --------------------------------------------
__WEBPACK_IMPORTED_MODULE_0_jquery___default()(function () {

    ymaps.ready(initMaps);

    __WEBPACK_IMPORTED_MODULE_0_jquery___default()("#carousel").carousel();

    __WEBPACK_IMPORTED_MODULE_0_jquery___default()("#makeVip").on("click", function (item) {

        __WEBPACK_IMPORTED_MODULE_0_jquery___default()(".modal-title").text("В топ");
        __WEBPACK_IMPORTED_MODULE_0_jquery___default()(".modal-body p").text("Ссылку на ваше объявление увидят все посетители сайта. Она будет первой в горячих предложениях, пока кто-либо не займет это место.");
        __WEBPACK_IMPORTED_MODULE_0_jquery___default()(".modal-body h5").text(window.vip_price + " ₸");

        __WEBPACK_IMPORTED_MODULE_0_jquery___default()("#billingModalDialog").modal("show");

        __WEBPACK_IMPORTED_MODULE_0_jquery___default()("#continueBilling").off().on("click", function (item) {

            __WEBPACK_IMPORTED_MODULE_0_jquery___default.a.ajax({
                url: "/objavlenie/makeExtend/" + window.advert_id + "/goTop",
                type: "POST",
                data: { "_token": __WEBPACK_IMPORTED_MODULE_0_jquery___default()('meta[name="csrf-token"]').attr('content') },
                success: function success(response) {
                    __WEBPACK_IMPORTED_MODULE_0_jquery___default()("#billingModalDialog").modal("hide");
                }
            });
        });
    });

    __WEBPACK_IMPORTED_MODULE_0_jquery___default()("#makeTorg").on("click", function (item) {

        __WEBPACK_IMPORTED_MODULE_0_jquery___default()(".modal-title").text("Срочно");
        __WEBPACK_IMPORTED_MODULE_0_jquery___default()(".modal-body p").text("Ваше объявление украсит флажок со словами «Срочно, торг».");
        __WEBPACK_IMPORTED_MODULE_0_jquery___default()(".modal-body h5").text(window.srochno_torg_price + " ₸");

        __WEBPACK_IMPORTED_MODULE_0_jquery___default()("#billingModalDialog").modal("show");

        __WEBPACK_IMPORTED_MODULE_0_jquery___default()("#continueBilling").off().on("click", function (item) {

            __WEBPACK_IMPORTED_MODULE_0_jquery___default.a.ajax({
                url: "/objavlenie/makeExtend/" + window.advert_id + "/srochno_torg",
                type: "POST",
                data: { "_token": __WEBPACK_IMPORTED_MODULE_0_jquery___default()('meta[name="csrf-token"]').attr('content') },
                success: function success(response) {
                    __WEBPACK_IMPORTED_MODULE_0_jquery___default()("#billingModalDialog").modal("hide");
                }
            });
        });
    });

    __WEBPACK_IMPORTED_MODULE_0_jquery___default()("#makePaint").on("click", function (item) {

        __WEBPACK_IMPORTED_MODULE_0_jquery___default()(".modal-title").text("Выделить");
        __WEBPACK_IMPORTED_MODULE_0_jquery___default()(".modal-body p").text("Цветное объявление намного заметнее в общем списке.");
        __WEBPACK_IMPORTED_MODULE_0_jquery___default()(".modal-body h5").text(window.color_price + " ₸");

        __WEBPACK_IMPORTED_MODULE_0_jquery___default()("#billingModalDialog").modal("show");

        __WEBPACK_IMPORTED_MODULE_0_jquery___default()("#continueBilling").off().on("click", function (item) {

            __WEBPACK_IMPORTED_MODULE_0_jquery___default.a.ajax({
                url: "/objavlenie/makeExtend/" + window.advert_id + "/makePaint",
                type: "POST",
                data: { "_token": __WEBPACK_IMPORTED_MODULE_0_jquery___default()('meta[name="csrf-token"]').attr('content') },
                success: function success(response) {
                    __WEBPACK_IMPORTED_MODULE_0_jquery___default()("#billingModalDialog").modal("hide");
                }
            });
        });
    });
});

__WEBPACK_IMPORTED_MODULE_0_jquery___default()("#sendComplainLink").on("click", function (event) {

    event.preventDefault();

    __WEBPACK_IMPORTED_MODULE_0_jquery___default()("#complainTextarea").val("");
    __WEBPACK_IMPORTED_MODULE_0_jquery___default()("#complainDialog").modal("show");
});

__WEBPACK_IMPORTED_MODULE_0_jquery___default()("#sendComplain").on("click", function (event) {

    if (__WEBPACK_IMPORTED_MODULE_0_jquery___default()("#complainTextarea").val().length > 3) {

        __WEBPACK_IMPORTED_MODULE_0_jquery___default.a.ajax({
            url: "/objavlenie/makeComplaint/" + window.advert_id,
            type: "POST",
            data: { "_token": __WEBPACK_IMPORTED_MODULE_0_jquery___default()('meta[name="csrf-token"]').attr('content'), "complainText": __WEBPACK_IMPORTED_MODULE_0_jquery___default()("#complainTextarea").val() },
            success: function success(response) {
                __WEBPACK_IMPORTED_MODULE_0_jquery___default()("#complainDialog").modal("hide");
                alert(response.msg);
            }
        });
    } else {
        alert("Мало конкретики");
    }
});

// ---------------------------------------------------------
// обработчик клика
// ---------------------------------------------------------
document.body.addEventListener('click', function (evt) {

    // закрыть страницу
    if (evt.target.classList[0] === 'close-link') {

        if (window.view) window.location = "/";else window.history.length > 1 && document.referrer ? window.history.go(-1) : window.location = "/";
    }

    // кнопка - показать номер
    if (evt.target.id === "numberButton") {

        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/api/getPhoneNumber?id=' + window.advert_id, true);
        xhr.onload = function () {

            if (xhr.status != 200) alert(xhr.status + ': ' + xhr.statusText);else {

                document.getElementById("numberButton").style.display = "none";
                document.getElementById("phone-number").style.display = "block";

                // удаляю лишние символы для ссылки с набором номера
                var hRefTel = JSON.parse(xhr.responseText)[0].phone.split('(').join('').split(')').join('').split(' ').join('').split('-').join('');

                document.getElementById("phone-number").innerHTML = "<b>тел: <a href='tel:+7" + hRefTel + "'>+7 " + JSON.parse(xhr.responseText)[0].phone + "</a></b><br><a class='btn btn-outline-success btn-sm mt-1 mb-2' href='tel:+7" + hRefTel + "'>позвонить</a>";
            }
        };

        xhr.send();
    }
}, false);

/***/ }),

/***/ 5:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/mix/details.js");


/***/ })

},[5]);