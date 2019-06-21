// ------------------------------------
// Показать / скрыть категории
// ------------------------------------
function showHideSubCategories() {

  // Выбор категории
  $(".col_item").click(function(e) {    

    var index = $(this).index();  
    
    // Показывать подкатегории только для транспорта и надвижимости
    if ( index < 2 ) {
      e.preventDefault();
      $("#close_subcats_btn").show();
      $("#categories").hide();
      $("#subcategories").show();
      $("#categories_title").text("подкатегории");
      $("*[data-id='"+(index+1)+"']").show();
    }
  });

  // Назад к категориям
  $("#close_subcats_btn").click(function(e) {
    $(this).hide();
    $("#categories").show();
    $("#subcategories").hide();
    $("#categories_title").text("категории");
    $("*[data-id]").hide();
  });

  // Выбираю регион
  $(".region_link").click(function(e) {
    e.preventDefault();

   // Получить список городов и сёл
   $.ajax({
     method: "GET",
     url: "getPlaces",
     data: { region_id: $(this).data("region_id") },
     statusCode: {
       404: function() { console.error( "Controller not found" ); }
     }
   }).done(function( json_places ) {      
     $("#regions").hide();

     // Заполняем модалку данными
     $.each(json_places, function (index, place) {
       console.log(place.name)       
       $("#places").append('<a href="'+place.url+'" class="black link">'+place.name+'</a><br>');
     })

   });    
  });

  // Закрыть модальный диалог для крестика и кнопки "Закрыть"
  $(".closeLocationModalBtn").click(function(e) {
     $("#places").empty();
     $("#regions").show();
     $("#locationModal").modal("hide");
  });

}

// ---------------------------------
// html загружен
// ---------------------------------
$( document ).ready(function() { 
 showHideSubCategories();
});