// Показать / скрыть категории
function showHideSubCategories() {

 $(".col_item").click(function(e) {
  
  var index = $(this).index();  

  if ( index < 2 ) {
    e.preventDefault();
    $("#close_subcats_btn").show();
    $("#categories").hide();
    $("#subcategories").show();
    $("*[data-id='"+(index+1)+"']").show();
    $("#categories_title").text("подкатегории");
  }

});

$("#close_subcats_btn").click(function(e) {
  $(this).hide();
  $("#categories").show();
  $("#subcategories").hide();
  $("#close_subcats_btn").hide();
  $("*[data-id]").hide();
  $("#categories_title").text("категории");
});

//$("#select_location_btn").click(function(e) {
  //alert("ok")
//});


}

// Назначить методы
function setMethods() {
 showHideSubCategories();
}

// Документ готов
$( document ).ready(function() {
   setMethods();
});