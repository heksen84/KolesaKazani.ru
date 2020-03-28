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

function loadModels(idMark) {

  $.ajax({
    url: "/api/getCarsModels",
    type: "GET",
    data: {"_token": $('meta[name="csrf-token"]').attr('content'), "mark_id": idMark},
    success: function (response) {      
      $("#model").empty();
      $.each(response, function(index, value) {
        $("#model").append("<option>"+value.name+"</option>");
      });      
    }    
  });

}

// html загружен
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

        $.each(response, function(index, value) {
          $("#mark").append("<option value="+value.id_car_mark+">"+value.name+"</option>");
        });

        $( "#mark" ).change(function(item) { 
          loadModels($(this).children("option:selected").val()); 
        }).change();

      }
  });

});