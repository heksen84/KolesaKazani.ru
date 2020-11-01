require('./bootstrap');
import $ from "jquery";
import "bootstrap";

let selectedRegionUrl = "";

// html loaded
$(function() {

  $(".col_item").on("click",function(item) {    
    let element_id = $(this).attr("id");    
    if ( element_id < 10 ) {            
      item.preventDefault();
      let elements = $("*[data-category-id='"+element_id+"']");    
      if (elements.length < 4)
      elements.addClass("col-xl-12")
      elements.show();
      $("#categories").hide();
      $("#subcats").show();
      localStorage.setItem("show_filters", "false");      
    }
  });

  $("#close_subcats_btn").on("click",function(item) {                       
    $("*[data-category-id]").hide();
    $("#categories").show();
    $("#subcats").hide();  
  });

  $("#locationButton").on("click",function(item) {                       
    $("#locationModal").modal("show");
  });

  $(".closeLocationWindow").on("click",function(item) {                       
    $("#locationModal").modal("hide");
    $("#regions").show();
    $("#places").empty();
    $("#placeData").show();
    $("#placeSearchResults").empty();   
    $("#placeFilter").val(""); 
  });  

  $(".region_link").on("click",function(item) {        
    selectedRegionUrl = $(this).attr("href");
    item.preventDefault();
    $("#regions").hide();
    $("#loaderForSearchPlace").show();      
    $.ajax({
      url: "/api/getPlaces",
      type: "GET",
      data: {"_token": $('meta[name="csrf-token"]').attr('content'), "region_id": $(this).attr("id")},
      success: function (response) {        
        $("#places").append('<div style="text-align:center;margin-bottom:5px"><a href="'+selectedRegionUrl+'" class="grey link" style="background:yellow;margin:auto">Искать в регионе</a></div>');
        $.each(response, function(index, item) {               
          $("#places").append("<div style='display:inline-block;padding:6px;border:1px solid rgb(220,220,220);margin:3px'><a href='"+selectedRegionUrl+"/"+item.url+"' class='grey link text-center place_link'>"+item.name+"</a></div>");
        });                        
        $("#places").append("<br><button class='btn btn-sm btn-success mt-2 mb-4' id='returnToRegions'>Отмена</button>").show();
        $("#loaderForSearchPlace").hide();
        $("#returnToRegions").on("click",function(item) {
          $("#placeFilter").val("");
          $("#places").empty();
          $("#regions").show();
        });        
      }    
    });
  });
    
  $("#placeFilter").keyup(function() {
    let searchVal = $(this).val(); 
    if (searchVal=="") {     
      $("#placeData").show();
      $("#placeSearchResults").empty();
    }
    else {
      $("#placeData").hide();            
      $.ajax({
        url: "/api/searchPlaceByString",
        type: "GET",
        data: {"_token": $('meta[name="csrf-token"]').attr('content'), "searchString": searchVal},
        success: function (response) {

          console.log("RESPONSE: "+response);
          
          $("#placeSearchResults").empty().css("padding-top","4px");      
          $.each(response, function(index, item) {               
            $("#placeSearchResults").append("<a href='/"+item.url+"' style='color:black;display:block;margin:5px;margin-top:3px'>"+item.city_name+", "+item.region_name+" обл.</a>");
          });
          $("#placeSearchResults").append("<div class='text-center'><button class='btn btn-sm btn-success' id='cancelPlaceSearchResults'>Отмена</button></div>").on("click",function(item) {                       
            $("#placeFilter").val(""); 
            $("#placeData").show();
            $("#placeSearchResults").empty();
          });        
        },
        error: function (jqXHR, exception) {
          console.log("error!!!");
          $("#placeSearchResults").css("color","red").text("Произошла ошибка.");        
        }
      })
    }      
  });

});
