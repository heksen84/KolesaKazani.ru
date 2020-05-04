require('./bootstrap');
import $ from "jquery";
import "bootstrap";

$( document ).ready(function() {

  $(".col_item").click(function(item) {     
    let element_id = $(this).attr("id");    
    if ( element_id < 10 ) {            
      item.preventDefault();
      let elements = $("*[data-category-id='"+element_id+"']");    
      if (elements.length < 4)
      elements.addClass("col-xl-12")
      elements.show();
      $("#categories").hide();
      $("#subcats").show();
    }
  });

  $("#close_subcats_btn").click(function(item) {                       
    $("*[data-category-id]").hide();
    $("#categories").show();
    $("#subcats").hide();  
  });

  $("#locationButton").click(function(item) {                       
    $("#locationModal").modal("show");
  });

  $("#closeLocationWindow").click(function(item) {                       
    $("#locationModal").modal("hide");
    $("#regions").show();
    $("#places").empty();
  });  

  $(".region_link").click(function(item) {            
    item.preventDefault();
    $("#regions").hide(); 
    $("#places").show(); 
    $.ajax({
      url: "/api/getPlaces",
      type: "GET",
      data: {"_token": $('meta[name="csrf-token"]').attr('content'), "region_id": $(this).attr("id")},
      success: function (response) {        
        $("#places").append('<div style="font-weight:bold;text-align:center;margin:5px"><a href="/" class="grey link" style="background:yellow;margin:auto;font-size:17px">Искать в регионе</a></div>');
        $.each(response, function(index, item) {               
          $("#places").append("<h3 style='display:inline-block;padding:6px;border:1px solid grey;margin:3px'><a href='"+item.url+"' class='grey link text-center region_link'>"+item.name+"</a></h3>");
        });        
        $("#places").append("<br><button class='btn btn-sm btn-success m-2'>< Назад</button>");
      }    
    });
  });    

});
