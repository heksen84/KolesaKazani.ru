import $ from "jquery";

function loadCarsModels(idCarMark) {

  $("#model").empty().append("<option value=all>Все модели</option>");

  $.ajax({
    url: "/api/getCarsModels",
    type: "GET",
    data: {"_token": $('meta[name="csrf-token"]').attr('content'), "mark_id": idCarMark},
    success: function (response) {      
            
      $.each(response, function(index, item) {
        $("#model").append("<option value="+item.id_car_model+">"+item.name+"</option>");
      });   

    }    
  });
}

function loadCarsMarks() {

  $("#mark").empty().append("<option value=all>Все марки</option>");

  $.ajax({
    url: "/api/getCarsMarks",
    type: "GET",
    data: {"_token": $('meta[name="csrf-token"]').attr('content')},
    success: function (response) {                                    

      $.each(response, function(index, item) {
        $("#mark").append("<option value="+item.id_car_mark+">"+item.name+"</option>");
      });

      $( "#mark" ).change(function(item) { 
        loadCarsModels($(this).children("option:selected").val()); 
      }).change();
    }
  });
}

function initCars() {
  
  if (window.mark) 
    $("#mark").val(window.mark);
  
    if (window.model) 
      $("#model").val(window.model);

      loadCarsMarks();
}

// -----------------------------------
// html готов
// -----------------------------------
$( document ).ready(function() {
  initCars();
});