document.body.addEventListener('click', function (evt) {    

    if (evt.toElement.classList[0] === 'close_button') {
        window.history.back();
    }

}, false);