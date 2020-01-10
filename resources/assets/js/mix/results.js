document.body.addEventListener('click', function (evt) {        


  console.log(evt.target.className)

/*  if (evt.target.classList[0] === 'close_button') {                        

      if (window.history.length<=3)
          window.location = "/"
      else
          window.history.back();
  }

  */


}, false);