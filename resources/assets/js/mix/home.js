require('./bootstrap');

import $ from "jquery";
import "bootstrap";

$( document ).ready(function() {
    
    // оплата
    $(".actions button").click(function(item) {        
        
        let title_text="";
        let price=0;

        switch($(this).index()) {
            case 0: {
                title_text = "срочно, торг"; 
                price = 100;
                break;
            }
            case 1: { 
                title_text = "продлить"; 
                price = 200;
                break;
            }
            case 2: { 
                title_text = "поднять в топ"; 
                price = 300;
                break;
            }
            case 3: { 
                title_text = "покрасить"; 
                price = 400;
                break;
            }
        }
        
        $(".modal-title").text(title_text);
        $("#price").text(price);
        $("#payment_window").modal('show');
        
    });

});