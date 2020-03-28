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

// html загружен
$( document ).ready(function() {

  if (window.mark)
  document.getElementById("mark").value=window.mark;

  if (window.model)
    document.getElementById("model").value=window.model;
    
    $.ajax({
      url: "/api/getCarsMarks",
      type: "GET",
      data: {"_token": $('meta[name="csrf-token"]').attr('content')},
      success: function (response) {                
        $.each(response, function(index, value) {
          $("#mark").append("<option>"+value.name+"</option>");
        });
      }
  });

});