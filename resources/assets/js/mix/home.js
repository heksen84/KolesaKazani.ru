require('./bootstrap');

import $ from "jquery";
import "bootstrap";

$( document ).ready(function() {
    
    // оплата
    $(".actions button").click(function(item) {
        //alert($(this).index());
        $("#payment_window").modal('show');
    });

});