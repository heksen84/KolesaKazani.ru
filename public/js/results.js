webpackJsonp([5],{

/***/ "./resources/assets/js/mix/results.js":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_jquery__ = __webpack_require__("./node_modules/jquery/dist/jquery.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_jquery___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_jquery__);


// загрузить модели автомобилей
function loadCarsModels(idCarMark) {

  __WEBPACK_IMPORTED_MODULE_0_jquery___default()("#model").empty().append("<option value=all>Все модели</option>");

  __WEBPACK_IMPORTED_MODULE_0_jquery___default.a.ajax({
    url: "/api/getCarsModels",
    type: "GET",
    data: { "_token": __WEBPACK_IMPORTED_MODULE_0_jquery___default()('meta[name="csrf-token"]').attr('content'), "mark_id": idCarMark },
    success: function success(response) {
      __WEBPACK_IMPORTED_MODULE_0_jquery___default.a.each(response, function (index, item) {
        __WEBPACK_IMPORTED_MODULE_0_jquery___default()("#model").append("<option value=" + item.id_car_model + ">" + item.name + "</option>");
      });
    }
  });
}

// загрузить марки автомобилей
function loadCarsMarks() {

  __WEBPACK_IMPORTED_MODULE_0_jquery___default()("#mark").empty().append("<option value=all>Все марки</option>");

  __WEBPACK_IMPORTED_MODULE_0_jquery___default.a.ajax({

    url: "/api/getCarsMarks",
    type: "GET",
    data: { "_token": __WEBPACK_IMPORTED_MODULE_0_jquery___default()('meta[name="csrf-token"]').attr('content') },
    success: function success(response) {

      __WEBPACK_IMPORTED_MODULE_0_jquery___default.a.each(response, function (index, item) {

        __WEBPACK_IMPORTED_MODULE_0_jquery___default()("#mark").append("<option value=" + item.id_car_mark + ">" + item.name + "</option>");
      });

      __WEBPACK_IMPORTED_MODULE_0_jquery___default()("#mark").trigger("change", function (item) {
        loadCarsModels(__WEBPACK_IMPORTED_MODULE_0_jquery___default()(this).children("option:selected").val());
      }).trigger("change");
    }
  });
}

// загрузить данные автомобилей
function initCars() {

  if (window.mark) __WEBPACK_IMPORTED_MODULE_0_jquery___default()("#mark").val(window.mark);

  if (window.model) __WEBPACK_IMPORTED_MODULE_0_jquery___default()("#model").val(window.model);
  loadCarsMarks();
}

// подготовливаю фильтры
function initFilters() {

  var buttonFiltersDefaultText = "скрыть фильтр";

  __WEBPACK_IMPORTED_MODULE_0_jquery___default()("#filters_button").on("click", function (item) {

    if (__WEBPACK_IMPORTED_MODULE_0_jquery___default()("#filters_button").text() == buttonFiltersDefaultText) {

      __WEBPACK_IMPORTED_MODULE_0_jquery___default()("#filters").hide();
      __WEBPACK_IMPORTED_MODULE_0_jquery___default()("#filters_button").text("отфильтровать");
      localStorage.setItem("show_filters", "false");
    } else {

      __WEBPACK_IMPORTED_MODULE_0_jquery___default()("#filters").show();
      __WEBPACK_IMPORTED_MODULE_0_jquery___default()("#filters_button").text(buttonFiltersDefaultText);
      localStorage.setItem("show_filters", "true");
    }
  });
}

// html готов
__WEBPACK_IMPORTED_MODULE_0_jquery___default()(function () {

  initCars();
  initFilters();

  // что-бы фильтры не вылизили стразу в других категориях
  __WEBPACK_IMPORTED_MODULE_0_jquery___default()(".close-link").on("click", function () {

    localStorage.setItem("show_filters", "false");
    window.history.length > 1 && document.referrer ? window.history.go(-1) : window.location = "/";
  });

  if (localStorage.getItem("show_filters") == "true") {
    __WEBPACK_IMPORTED_MODULE_0_jquery___default()("#filters_button").trigger("click");
  }
});

/***/ }),

/***/ 4:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/mix/results.js");


/***/ })

},[4]);