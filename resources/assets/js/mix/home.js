require('./bootstrap');

import $ from "jquery";
import "bootstrap";

let current_advert_id = null;

// html загружен
$( document ).ready(function() {

    // удаление объявления
    $("#delete_advert_button").click(function(item) {                       
        
        $.ajax({
            url: "objavlenie/delete/"+current_advert_id,
            type: "POST",
            data: {"_token": $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
                $("#delete_advert_window").modal("hide");                
                /*$("#advert_deleted_window").modal("show").on('hide.bs.modal', function(e){
                    e.preventDefault();
                });*/

                $("#advert_deleted_window").modal("show");
                    
            }
        });

    });

    // закрыть сообщение и обновить страницу
    $("#close_advert_deleted_message_window").click(function(item) {                       
        //window.location="/home";
        $("#advert_deleted_window").modal("hide");
    });
        
    // оплата
    $(".actions button").click(function(item) {         
                        
        let title_text="";
        let price=0;

        current_advert_id = $(this).parent().data("id");
        

        switch($(this).index()) {
            case 0: {
                title_text = "Срочно, торг"; 
                price = 100;
                break;
            }
            case 1: { 
                title_text = "Продлить"; 
                price = 200;
                break;
            }
            case 2: { 
                title_text = "Поднять в топ"; 
                price = 300;
                break;
            }
            case 3: { 
                title_text = "Покрасить"; 
                price = 400;
                break;
            }
            case 4: {                 
                $("#delete_advert_window").modal("show");
                break;
            }
        }        

        if ($(this).index()!=4) {
            $("#payment_window_title").text(title_text);
            $("#price").text(price);
            $("#payment_window").modal("show");
        }

                
    });

});