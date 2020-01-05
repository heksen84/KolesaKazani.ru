require('./bootstrap');

import Vue from 'vue';
import $ from "jquery";
import bootstrap from "bootstrap";
import search from './views/components/search'
import location from './views/components/location'

// экземляр приложения vue
export default new Vue ({

  el: "#app",

  data () {   
    return {     
      categories: true,
      subCategories: false      
    }
  },

  delimiters: ['${', '}'], // для разрешения конфликта c переменными php

  components: { bootstrap, location, search },

  // Компонент создан
  created() {

    //alert(window.country);
    //alert(window.lang);
    
    $("#subcats").show();
    $("#close_subcats_btn").show();    
  },

  // Методы
  methods: {  

  // Отобразить окно расположения
  showLocationWindow() {    
    $("#locationModal").modal("show");
  },  

  // Показать подкатегории
  showSubcategories(e, categoryId) {
    if ( categoryId < 10 ) {      
      e.preventDefault();
      // получаю элементы
      let elements = $("*[data-category-id='"+(categoryId)+"']");
      // сбиваю в кучу их если кол-во меньше 4	      
      if (elements.length < 4)
       elements.addClass("col-xl-12")	  
      // отображаю
      elements.show();
      this.categories=false;
      this.subCategories=true;
    }
  },

  // Вернуться к категориям
  returnToCategories() {    
    $("*[data-category-id]").hide();
    this.categories=true;
    this.subCategories=false;    
  }
}
  
});