import $ from "jquery";

// document ready
/*document.addEventListener('DOMContentLoaded', function(){ // Аналог $(document).ready(function(){
 
  if (window.mark)
    document.getElementById("mark").value= window.mark;

    if (window.model)
      document.getElementById("model").value= window.model;

    let xmlHttp = new XMLHttpRequest();
    xmlHttp.open( "GET", "/getCarsMarks", false ); // false for synchronous request
    xmlHttp.send( null );
    console.log(xmlHttp.responseText);

});*/

function loadCarsModels(idCarMark) {
  $.ajax({
    url: "/api/getCarsModels",
    type: "GET",
    data: {"_token": $('meta[name="csrf-token"]').attr('content'), "mark_id": idCarMark},
    success: function (response) {      
      $("#model").empty();
      $.each(response, function(index, item) {
        $("#model").append("<option value="+item.id_car_model+">"+item.name+"</option>");
      });      
    }    
  });
}

// -----------------------------------
// html готов
// -----------------------------------
$( document ).ready(function() {

  if (window.mark) 
    $("#mark").val(window.mark);
  
    if (window.model) 
      $("#model").val(window.model);
      
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
});