// Показать / скрыть категории
function showHideSubcategory() {

 $(".col_item").click(function(e) {

   e.preventDefault();

   $("#categories").hide();
   $("#subcategories").show();

   var subcats = $("*[data-id='"+($(this).index()+1)+"']").show();

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