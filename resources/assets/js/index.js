require('./bootstrap');
import Vue from 'vue';
import $ from "jquery";
import bootstrap from "bootstrap";
import { get } from './helpers/api' // axios

// ------------------------
// экземляр приложения vue
// ------------------------
export default new Vue ({
  el: '#app',
  data () {      
    return {      
      placesList: [], // массив городов / сёл / деревень
      regions: true,    
      places: false,
      locationName: "",
      categories: true,
      subCategories: false
    }
  },
  delimiters: ['${', '}'], // для разрешения конфликта c переменными php
  components: {    
    bootstrap
  },

  // -------------------
  // Компонент создан
  // -------------------
  created() { 
    $("#locationButton").show();    
  },

  // --------------------------------------
  // Методы
  // --------------------------------------
  methods: {

  showLocationWindow() {
    $("#locationModal").modal("show");
  },
  
  closeLocationWindow() {
    this.regions=true;
    this.places=false;
    $("#locationModal").modal("hide");    
  },
  
  // --------------------------------------
  // Выбор региона
  // --------------------------------------
  showPlacesByRegion(e, regionId) {
    e.preventDefault();

    // Получить города / сёлы
    get("getPlaces?region_id="+regionId).then((res) => {    
      this.placesList=res.data;
      this.regionUrl=e.target.pathname;
      this.regions=false;
      this.places=true;
    }).catch((err) => { console.log(err) });    
  },

  // --------------------------------------
  // Выбор расположения
  // --------------------------------------

  searchInRegion() {    
    let self=this;

    $( ".url" ).each(function( index ) {      
      $(this).attr("href", self.regionUrl+$(this).data("default-url"))      
    });    
    this.closeLocationWindow();
  },
  
  selectPlace(e, placeName, placeUrl) {      
    
    let self=this;    
    e.preventDefault();

    this.locationName=placeName;
    this.closeLocationWindow();    

    $( ".url" ).each(function( index ) {      
      $(this).attr("href", self.regionUrl+"/"+placeUrl+$(this).data("default-url"))      
    });        
  },

  showSubcategories(e, categoryId) {
    e.preventDefault();        
    $("*[data-category-id='"+(categoryId)+"']").show();
    this.categories=false;
    this.subCategories=true;
  },

  returnToCategories() {    
    $("*[data-category-id]").hide();
    this.categories=true;
    this.subCategories=false;    
  }
}
  
});