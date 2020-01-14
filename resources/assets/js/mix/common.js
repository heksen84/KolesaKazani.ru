document.body.addEventListener('click', function (evt) {        

    if (evt.target.classList[0] === 'close_button') {                        

        /*if (window.history.length<=3)
            window.location = "/"
        else
            window.history.back();*/

            window.location = "/";
    }

}, false);