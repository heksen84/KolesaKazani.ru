document.addEventListener('DOMContentLoaded', function() {
 
 document.body.addEventListener('click', function (evt) {        
 
 if (evt.target.id=="auth_vk") {
  console.log("vk")
 }

 if (evt.target.id=="auth_ok") {
  console.log("ok")
 }

}, false);
 
});