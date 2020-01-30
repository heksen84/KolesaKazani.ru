// возврат назад
document.body.addEventListener('click', function (evt) {

  if (evt.target.classList[0] === 'close_button') {                        
      window.history.back();
  }


}, false);