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
      tmpLocationName: "",
      categories: true,
      subCategories: false,      
    }
  
  },
  delimiters: ['${', '}'], // для разрешения конфликта c переменными php
  components: {    
    bootstrap
  },

  // -------------------------------
  // Компонент создан
  // -------------------------------
  created() {

    // Вытаскивыю местоположение из локалстораджа
    var locationUrl = localStorage.getItem("locationUrl");
    var locationName = localStorage.getItem("locationName");
    
    if (locationUrl!=null) {
      this.locationName = locationName;
      $( ".url" ).each(function( index ) {      
        $(this).attr("href", locationUrl+$(this).data("default-url"));
      });
    }

    // Показываю то, что скрыто
    $("#locationButton").show();
    $("#close_subcats_btn").show();    
  },

  // --------------------------------------
  // Методы
  // --------------------------------------
  methods: {

  // Отобразить окно расположения
  showLocationWindow() {
    $("#locationModal").modal("show");
  },
  
  // Закрыть окно расположения
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
    this.tmpLocationName=e.target.innerText;

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

  searchInCountry(e) {    
    
    /*let self=this;
    this.locationName=this.tmpLocationName;
  
    $( ".url" ).each(function( index ) {      
      $(this).attr("href", self.regionUrl+$(this).data("default-url"))      
    });

    localStorage.setItem("locationUrl", self.regionUrl);
    localStorage.setItem("locationName", this.locationName);*/
  
    this.closeLocationWindow();
  },

  searchInRegion(e) {    
    
    let self=this;
    this.locationName=this.tmpLocationName;
  
    $( ".url" ).each(function( index ) {      
      $(this).attr("href", self.regionUrl+$(this).data("default-url"))      
    });

    localStorage.setItem("locationUrl", self.regionUrl);
    localStorage.setItem("locationName", this.locationName);
  
    this.closeLocationWindow();
  },
  
  // --------------------------------------
  // Выбрать город / село и т.п.
  // --------------------------------------
  selectPlace(e, placeName, placeUrl) {    
    
    let self=this;    
    e.preventDefault();
    
    this.locationName=placeName;
    this.closeLocationWindow();

    $( ".url" ).each(function( index ) {      
      $(this).attr("href", self.regionUrl+"/"+placeUrl+$(this).data("default-url"))      
    });

    localStorage.setItem("locationUrl", self.regionUrl+"/"+placeUrl);
    localStorage.setItem("locationName", this.locationName);

  },

  // --------------------------------------
  // Показать подкатегории
  // --------------------------------------
  showSubcategories(e, categoryId) {

    if (categoryId<3) {
      e.preventDefault();        
      $("*[data-category-id='"+(categoryId)+"']").show();
      this.categories=false;
      this.subCategories=true;
    }
  },

  returnToCategories() {    
    $("*[data-category-id]").hide();
    this.categories=true;
    this.subCategories=false;    
  }
}
  
});