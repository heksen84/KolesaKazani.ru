/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 5);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/mix/details.js":
/***/ (function(module, exports) {

// инициализация карты
function initMaps() {

	// координаты по умолчанию для всех карт
	var mapCoords = [window.coord_lat, window.coord_lon];
	var map = new ymaps.Map("map", { center: mapCoords, zoom: 10 });

	// включаю скролл на карте
	map.behaviors.enable("scrollZoom");

	// формирую метку
	myPlacemark = new ymaps.Placemark(mapCoords);

	// добавляю метки на карты
	map.geoObjects.add(myPlacemark);
}

// document ready
document.addEventListener('DOMContentLoaded', function () {
	ymaps.ready(initMaps);
});

// обработчик клика
document.body.addEventListener('click', function (evt) {

	// вернуться назад
	if (evt.target.classList[0] === 'close_button') {
		window.history.back();
	}

	// кнопка - показать номер
	if (evt.target.id === "showNumberBtn") {

		var xhr = new XMLHttpRequest();

		xhr.open('GET', '/api/getPhoneNumber?id=' + window.advert_id, true);
		xhr.onload = function () {

			if (xhr.status != 200) alert(xhr.status + ': ' + xhr.statusText);else {
				document.getElementById('showNumberBtn').style.display = "none";
				document.getElementById('phone-number').style.display = "block";
				document.getElementById('phone-number').innerHTML = "Номер: <b>+7 " + JSON.parse(xhr.responseText)[0].phone + "</b>";
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

/******/ });