require('./bootstrap');
import $ from "jquery";
import "bootstrap";

function setExtendOptions() {

    $(".prodlit").off().on("click",function(item) {        

        let self = $(this);

        $.ajax({
            url: "/objavlenie/makeExtend/"+$(this).parent().data("id")+"/prodlit",
            type: "POST",
            data: {"_token": $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {                
                
                self.hide();                
                
                /*let buttons = '<button class="btn btn-outline-success btn-sm m-1 top">В топ</button>'+
                              '<button class="btn btn-outline-secondary btn-sm m-1 color">Выделить</button>'+
                              '<button class="btn btn-outline-danger btn-sm m-1 srochno">Срочно</button>';                
                
                self.parent().append(buttons);*/

                alert("Объявление продлено на 30 дней")
                
                setExtendOptions();             
            }
        });        
    });

    $(".top").off().on("click",function(item) {

        let self = $(this);

        $.ajax({
            url: "/objavlenie/makeExtend/"+$(this).parent().data("id")+"/goTop",
            type: "POST",
            data: {"_token": $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {                
                self.hide();
                self.parent().parent().find(".col-title").find(".statuses").append('<span class="badge badge-primary">В топе</span>');
            }
        });        
    });

    $(".color").off().on("click",function(item) {

        let self = $(this);

        $.ajax({
            url: "/objavlenie/makeExtend/"+$(this).parent().data("id")+"/makePaint",
            type: "POST",
            data: {"_token": $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {                
                self.hide();
                self.parent().parent().find(".col-title").find(".statuses").append('<span class="badge badge-success">Выделено</span>');
            }
        });        
    });

    $(".srochno").off().on("click",function(item) {

        let self = $(this);

        $.ajax({
            url: "/objavlenie/makeExtend/"+$(this).parent().data("id")+"/srochno_torg",
            type: "POST",
            data: {"_token": $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {                
             self.hide();
             self.parent().parent().find(".col-title").find(".statuses").append('<span class="badge badge-danger">Срочное</span>');
            }
        });
        
    });    
    
}

// html загружен
$(function() {
    setExtendOptions();    
});