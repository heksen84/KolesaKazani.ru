require('./bootstrap');
import $ from "jquery";
import "bootstrap";

/*@if ($item->top)
                  <span class="badge badge-primary" title="В топе с {{ date('d.m.Y', strtotime($item->topStartDate)) }} по {{ date('d.m.Y', strtotime($item->topFinishDate)) }}">В топе</span>
                @endif
                @if ($item->srochno)
                  <span class="badge badge-danger" title="Срочное с {{ date('d.m.Y', strtotime($item->srochnoStartDate)) }} по {{ date('d.m.Y', strtotime($item->srochnoFinishDate)) }}">Срочное</span>
                @endif
                @if ($item->color)                  
                  <span class="badge badge-success" title="Выделено с {{ date('d.m.Y', strtotime($item->colorStartDate)) }} по {{ date('d.m.Y', strtotime($item->colorFinishDate)) }}">Выделено</span>
                @endif
                @if ($item->color || $item->srochno || $item->top)
                  <hr style="margin-top:8px">
                @endif*/

function setExtendOptions() {

    $(".color").off().click(function(item) {

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

    $(".srochno").off().click(function(item) {

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

    $(".prodlit").off().click(function(item) {        

        let self = $(this);

        $.ajax({
            url: "/objavlenie/makeExtend/"+$(this).parent().data("id")+"/prodlit",
            type: "POST",
            data: {"_token": $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {                
                self.hide();                

                let buttons = '<button class="btn btn-outline-success btn-sm m-1 top">В топ</button>'+
                              '<button class="btn btn-outline-secondary btn-sm m-1 color">Выделить</button>'+
                              '<button class="btn btn-outline-danger btn-sm m-1 srochno">Срочно</button>';                
                
                self.parent().append(buttons);                
                setExtendOptions();             
            }
        });        
    });
}

// html загружен
$( document ).ready(function() {
    setExtendOptions();    
});