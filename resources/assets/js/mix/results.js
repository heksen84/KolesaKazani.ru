// возврат назад
/*document.body.addEventListener('click', function (evt) {

  if (evt.target.classList[0] === 'close_button') {                        
      //window.history.back();
      window.location="/";
  }


}, false);*/

// document ready
document.addEventListener('DOMContentLoaded', function(){ // Аналог $(document).ready(function(){
 
  if (window.mark)
    document.getElementById("mark").value= window.mark;

    if (window.model)
      document.getElementById("model").value= window.model;

});