<template>
  <b-container fluid class="mycontainer">
    <b-row>
        <b-col id="welcome_menu" v-show="auth">

          <div class="button" id="button_login" style="width:160px;text-align:center;position:relative;top:3px" @click="login">мои объявления</div>

          

          <!-- окно выбоа региона и местоположения -->
          <b-modal v-model="locationDialog" style="text-align:center;color:rgb(50,50,50)" hide-footer :title="locationDialogTitle">

            <!-- регионы -->
            <b-button variant="link" style="color:black" v-for="i in regions" :key="i.region_id" @click="selectLocation(i)">{{i.name}}
            </b-button>

            <hr v-if="buttonAllCountry">
            <b-button variant="link" v-if="buttonAllCountry" @click="selectAllCountry">Весь Казахстан</b-button>

            <!-- города, cёлы, аулы, деревни -->
            <b-button variant="link" style="color:black" v-for="i in places" :key="i.city_id" @click="selectPlace(i)">{{i.name}}
            </b-button>

            <hr v-if="buttonAllRegion">
            <button style="color:black;display:block;margin:auto;margin-top:-5px" v-if="buttonAllRegion" @click="selectAllRegion">Вся область</button>

          </b-modal>
        </b-col>

        <b-col style="text-align:center" v-show="!auth">
          <div class="button" id="button_login" style="margin-top:3px" @click="login">Вход</div>
          <div class="button" id="button_reg" style="margin-top:3px" @click="register">Регистрация</div>
        </b-col>
        
    </b-row>

    <b-row style="margin-top:2px">
        <b-col cols="12" sm="12" md="12" lg="3" xl="3" style="text-align:center">

        <!-- ЛОГОТИП -->
        <a href="/">
          <div id="logo_block">
            <div id="logo_block_text">КупиПродай</div>
            <div style="font-size:18px;color:yellow;margin-top:-13px;letter-spacing:2px;">доска объявлений</div>
          </div>
        </a>

        </b-col>

        <b-col cols="12" sm="12" md="12" lg="6" xl="6" style="text-align:center">
          <input type="text" id="search_string" placeholder="Поиск по сайту"/>

          

          <button id="button_search" @click="search">найти</button>

          <!-- кнопка выбора региона -->
          <b-button style="margin-top:-8px;color:white;padding:4px 10px; background:rgb(150,100,150)" size="sm" @click="openLocationWindow"> Искать в {{ selectedPlaceName }}</b-button>

        </b-col>

        <b-col cols="12" sm="12" md="12" lg="3" xl="3" style="text-align:center">
          <a href="/podat-obyavlenie"><div id="new_advert_block">подать объявление</div></a>
        </b-col>
    </b-row>

    <div id="categories_title" class="shadow_text">категории</div>
    
    <!-- категории -->
    <b-row v-for="i in Math.ceil(Object.keys(items).length / 4)" v-bind:key=i>
      <b-col cols="12" sm="12" md="12" lg="3" xl="3" v-for="item in items.slice((i - 1) * 4, i * 4)"  v-bind:key=item.id>

        <a :href="urlRegAndPlace+'/'+item.url">

        <div class="category_item">{{ item.name }}
          <span style="font-size:13px;color:rgb(170,255,170);float:right;margin-top:4px" :id="item.id">| {{ 555 }} </span>
        </div></a>
      </b-col>
    </b-row>

</b-container>
</template>
<script>
import { get } from './../helpers/api'
export default {
  props: ["items", "auth", "count"],

  data () {
    return {
      regions: [],
      places: [],
      location: null,
      locationDialog: false,
      locationDialogTitle: "",
      urlRegAndPlace: "",
      buttonAllCountry: true,
      buttonAllRegion: false,
      regionName: ""

    }
  },
  created() {

   // alert(screen.width);

    var placeName = localStorage.getItem("placeName");

    if(placeName==null)
      this.selectedPlaceName = "Весь казахстан";
    else 
      this.selectedPlaceName = placeName;

    var urlRegAndPlace = localStorage.getItem("urlRegAndPlace");

    if(urlRegAndPlace==null) 
    this.urlRegAndPlace = "";
      else 
    this.urlRegAndPlace = urlRegAndPlace;

  },
  methods: {

    login() {
      window.location='/login';
    },

    register() {
      window.location='/register';
    },

    search() {
      window.location='/search';
    },
    
    openLocationWindow() {

      this.buttonAllCountry=true;
      this.buttonAllRegion=false;
      this.locationDialog=true;
      this.locationDialogTitle="Выберите регион"
      this.places={};
      this.regions={};

      get('/getRegions').then((res) => {
          this.regions=res.data;
      }).catch((err) => {});
      
    },

    // ----------------------------------------------------------
    // Выбор региона либо локального места жительства в диалоге
    // ----------------------------------------------------------
    selectLocation(e) {

      this.regionName = e.name;
      this.buttonAllCountry=false;
      this.buttonAllRegion=true;
      this.urlRegAndPlace=e.url;
      this.regions=[];
      this.locationDialogTitle="Выберите расположение"

      get('/getPlaces/?region_id='+e.region_id).then((res) => {
          this.places=res.data;
          console.log(res.data);
      }).catch((err) => {});

    },
    selectPlace(e) {

      this.buttonAllCountry=false;
      this.selectedPlaceName=e.name;
      this.locationDialog=false;

      // формируем url
      this.urlRegAndPlace=this.urlRegAndPlace+"/"+e.url;

      // закидываем в localStrorage
      localStorage.setItem("placeName", this.selectedPlaceName);
      localStorage.setItem("urlRegAndPlace", this.urlRegAndPlace);
    },
    selectAllCountry(e) {
      this.selectedPlaceName="Весь Казахстан";
      this.urlRegAndPlace="";
      
      // закидываем в localStrorage
      localStorage.setItem("placeName", this.selectedPlaceName);
      localStorage.setItem("urlRegAndPlace", "");

      this.locationDialog=false;
    },
    selectAllRegion(e) {
      this.selectedPlaceName=this.regionName;
      
      // закидываем в localStrorage
      localStorage.setItem("placeName", this.selectedPlaceName);
      localStorage.setItem("urlRegAndPlace", this.urlRegAndPlace);

      this.locationDialog=false;
    }
  }
}
</script>
