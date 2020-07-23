require('./bootstrap');
import $ from "jquery";
import "bootstrap";

// html загружен
$( document ).ready(function() {
    
    $(".prodlit").click(function(item) {        

        let self = $(this);

        $.ajax({
            url: "/objavlenie/makeExtend/"+$(this).parent().data("id")+"/prodlit",
            type: "POST",
            data: {"_token": $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {                
                self.hide();
            }
        });        
    });

    $(".color").click(function(item) {

        let self = $(this);

        $.ajax({
            url: "/objavlenie/makeExtend/"+$(this).parent().data("id")+"/makePaint",
            type: "POST",
            data: {"_token": $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {                
                self.hide();
            }
        });        
    });

    $(".srochno").click(function(item) {

        let self = $(this);

        $.ajax({
            url: "/objavlenie/makeExtend/"+$(this).parent().data("id")+"/srochno_torg",
            type: "POST",
            data: {"_token": $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {                
                self.hide();
            }
        });        
    });
    
});