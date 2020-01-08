document.body.addEventListener('click', function (evt) {    

    if (evt.toElement.classList[0] === 'close_button') {        
        
        if (window.history.length<=3)
            window.location = "/"
        else
            window.history.back();
    }

}, false);