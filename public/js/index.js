// Показать / скрыть категории
function showHideSubcategory() {

 $(".col_item").click(function(e) {
  
  var index = $(this).index();  

  if ( index < 2 ) {
    e.preventDefault();
    $("#close_subcats_btn").show();
    $("#categories").hide();
    $("#subcategories").show();
    $("*[data-id='"+(index+1)+"']").show();    
  }

});

$("#close_subcats_btn").click(function(e) {
  $(this).hide();
  $("#categories").show();
  $("#subcategories").hide();
  $("#close_subcats_btn").hide();
  $("*[data-id]").hide();
});

}

// Назначить методы
function setMethods() {
 showHideSubcategory();
}

// Документ готов
$( document ).ready(function() {
   setMethods();
});