require('./bootstrap');

import $ from "jquery";
import "bootstrap";

$( document ).ready(function() {

    $(".actions button").click(function(item) {
        //alert($(this).index());
        $("#myModal").modal('show');
    });
   
});