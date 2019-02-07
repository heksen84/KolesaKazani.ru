<!-- git -->
<template>
  <b-container fluid class="mycontainer">
    <b-row>
        <!-- окно выбоа региона и местоположения -->
        <b-modal v-model="locationDialog" style="text-align:center;color:rgb(50,50,50)" hide-footer :title="locationDialogTitle">
          <!-- регионы -->
          <b-button variant="link" style="color:black" v-for="i in regions" :key="i.region_id" @click="selectLocation(i)">{{i.name}}
          </b-button>
          <hr v-if="buttonAllCountry">
          <b-button variant="link" v-if="buttonAllCountry" @click="selectAllCountry" style="margin-top:-15px">Весь Казахстан</b-button>
          <!-- города, cёлы, аулы, деревни -->
          <b-button variant="link" style="color:black" v-for="i in places" :key="i.city_id" @click="selectPlace(i)">{{i.name}}</b-button>
          <hr v-if="buttonAllRegion">
          <b-button variant="link" style="margin-top:-5px" v-if="buttonAllRegion" @click="selectAllRegion">Вся область</b-button>
        </b-modal> 
        <b-col id="welcome_menu" v-show="auth">
          <div class="button" id="button_login" style="text-align:center;position:relative;top:5px;margin-left:10px" @click="login">{{ this.$store.state.str_my_adverts }}</div>
          <!--<div class="button" style="width:50px;text-align:center;position:relative;top:3px;background:rgb(100,100,200);margin-right:10px" @click="setLang">{{ lang }}</div>-->   
        </b-col>        
        <b-col style="text-align:center;top:5px" v-show="!auth">
          <div class="button" id="button_login" style="margin-left:17px" @click="login">Вход</div>
          <div class="button" id="button_reg" @click="register">Регистрация</div>
          <!--<div class="button" style="width:50px;text-align:center;position:relative;background:rgb(100,100,200);float:right;top:3px;margin-right:10px" @click="setLang">{{ lang }}</div>-->
        </b-col>     
    </b-row>

    <b-row style="margin-top:2px">
        <b-col cols="12" sm="12" md="12" lg="3" xl="3" style="text-align:center">

          <!-- Логотип -->        
          <div id="logo_block" @click="closeSubCats">
            <div id="logo_block_text">{{ this.$store.state.str_title }}</div>
            <div style="font-size:16px;color:yellow;margin-top:-13px;letter-spacing:2px;">{{ this.$store.state.str_desc }}</div>
          </div>
        </b-col>

        <b-col cols="12" sm="12" md="12" lg="6" xl="6" style="text-align:center">
          <input type="text" id="search_string" :placeholder="$store.state.str_search_placeholder"/>
          <button id="button_search" @click="search" title="Найти что требуется">{{ this.$store.state.str_button_search }}</button>

          <!-- кнопки выбора региона и т.п.-->
          <div id="index_select_region_and_other_button_block">
          <b-button class="search_options_button mb-1 mr-sm-1 mb-sm-1" size="sm" @click="openLocationWindow" :title="$store.state.str_location">{{ $store.state.str_location }}: {{ selectedPlaceName }}</b-button>
          <!--<b-button class="search_options_button mb-1 mr-sm-1 mb-sm-1" size="sm" style="background:rgb(100,100,150)">Категория</b-button>-->
          </div>
        </b-col>

        <b-col cols="12" sm="12" md="12" lg="3" xl="3" style="text-align:center" title="Подать новое объявление">
          <a href="/podat-obyavlenie"><div id="new_advert_block">{{ this.$store.state.str_create_advert }}</div></a>
        </b-col>
    </b-row>


    <div id="categories_line">
      
    <!-- КАТЕГОРИИ -->
    <div v-if="show_categories" style="text-align:center">    
      <div id="categories_title" class="shadow_text" style="margin-bottom:15px">категории</div>        
        <b-row v-for="i in Object.keys(items).length" v-bind:key=i>
          <b-col cols="12" sm="12" md="12" lg="3" xl="3" v-for="item in items.slice((i - 1) * 4, i * 4)" v-bind:key=item.id>
            <a :href="urlRegAndPlace+'/'+item.url" @click="showSubcats($event, item.id)">
              <div class="category_item">{{ item.name }}
              <!--<span style="font-size:13px;color:rgb(170,255,170);float:right;margin-top:4px" :id="item.id">{{ getCategoryCountById(item.id) }}</span>-->
              </div>
            </a>
          </b-col>
        </b-row>
    </div>

    <!-- ПОДКАТЕГОРИИ -->  
    <div v-if="!show_categories" style="text-align:center">
      <div id="categories_title" class="shadow_text" style="margin-bottom:15px">подкатегории</div>  
      <b-button @click="closeSubCats" variant="primary" style="border:1px solid white;font-size:14px" size="sm" id="close_subcats_btn">&#8634; Вернуться к категориям</b-button>      
        <b-row v-for="i in Object.keys(subcats).length" v-bind:key=i>
          <b-col cols="12" sm="12" md="12" lg="3" xl="3" v-for="item in subcats.slice((i - 1) * 4, i * 4)" v-bind:key=item.id>            
              <a :href="urlRegAndPlace+'/'+item.url">
                <div class="category_item" style="width:280px;font-size:17px" v-show="displaySubItem(item.category_id)">{{ item.name }}</div>            
              </a>
          </b-col>
        </b-row>
    </div>
    </div>

    <!-- VIP -->
    <b-row style="margin-top:60px" class="shadow_text"><h5>VIP объявления</h5></b-row>
      <b-row>    
        <b-col v-for="i in 10" style="border:1px solid rgb(255,255,255);margin:3px;padding:50px;opacity:0.5" v-bind:key="i"></b-col>
      </b-row>

    <!-- ПОДВАЛ -->
    <b-row>
      <div id="footer"><a href="advertisers" class="underline_link">Реклама</a> | 
        <a href="rules" class="underline_link">Правила сайта</a> | 
        <a href="about" class="underline_link">О сайте</a> | 
        <span @click="setLang">Язык: <span style="color:rgb(180,255,180);cursor:pointer">{{ lang }}</span></span> | 
        beta версия
      </div>
    </b-row>

  </b-container>
</template>

<!-- ЛОГИКА -->
<script>

import { get } from './../helpers/api'
//import petrovich from 'petrovich';

export default {
  
  props: ["items", "auth", "count", "subcats"], // входящие данные

  data () {
    
    // переменные
    return {
      lang: "русский",
      show_categories: true,
      selected_category_id: null,
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

  // компонент создан
  created() {
    
    var lang = localStorage.getItem("lang")
    console.log(lang)

    if (lang!=null) {
      this.$store.commit("SetLang", lang)
      if (lang=="ru")
        this.lang="русский";
      else
        this.lang="казакша";
    }
    else {
      this.$store.commit("SetLang", "ru")
      this.lang="русский";
    }
    

    var placeName = localStorage.getItem("placeName");
    var urlRegAndPlace = localStorage.getItem("urlRegAndPlace");

    if(placeName==null)
      this.selectedPlaceName = "Весь казахстан";
    else 
      this.selectedPlaceName = placeName;

    if(urlRegAndPlace==null)
      this.urlRegAndPlace = "";
    else 
      this.urlRegAndPlace = urlRegAndPlace;
  },

  mounted() {},
  computed: {},

  // методы компонента
  methods: {

    // установка языка
    setLang() {
      var ru = "русский";
      if (this.lang==ru) 
      {
        this.$store.commit("SetLang", "kz")
        this.lang="казакша";
        localStorage.setItem("lang", "kz")
      }
      else 
      {
        this.$store.commit("SetLang", "ru")
        this.lang=ru;
        localStorage.setItem("lang", "ru")
      }
    },

    displaySubItem: function (item) {         
      if (item==this.selected_category_id) return true;          
      return false;
    },
    
    // ----------------------------
    // показать подкатегории
    // ----------------------------
    showSubcats(e, cat_id) {

      var total=0;

      for (var i=0; i<Object.keys(this.subcats).length; i++) {
         if (this.subcats[i].category_id===cat_id)
          total++;
      }
      
      if (total>0) {
        e.preventDefault(); // отрубаю редирект
        this.selected_category_id=cat_id;
        this.show_categories=false;
      }
    },

    // ----------------------------
    // скрыть подкатегории
    // ----------------------------
    closeSubCats() {
      if (!this.show_categories) this.show_categories=true;
    },

    getCategoryCountById(id) {
      /*get('getCategoryCountById?category_id='+id).then((res) => {
          return res;
      }).catch((err) => {});*/
      return "|";
    },

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

      // получаю регионы
      get('/getRegions').then((res) => {
          console.log(res.data);
          
          this.regions=res.data;
      }).catch((err) => {
        
    });
      
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

      // Получить города / сёлы
      get('getPlaces?region_id='+e.region_id).then((res) => {
          this.places=res.data;
          console.log(res.data);
      }).catch((err) => {});

    },

    // ----------------------------------------------------------
    // Выбор города, села, и т.д.
    // ----------------------------------------------------------
    selectPlace(e) {
      
      this.buttonAllCountry=false;
      this.selectedPlaceName=e.name;
      this.locationDialog=false;
      this.urlRegAndPlace=this.urlRegAndPlace+"/"+e.url;

      // сохраняю в localStorage
      localStorage.setItem("placeName", this.selectedPlaceName);
      localStorage.setItem("urlRegAndPlace", this.urlRegAndPlace);      
    },

    selectAllCountry(e) {
      this.selectedPlaceName="Весь Казахстан";
      this.urlRegAndPlace="";      
      this.locationDialog=false;

      // сохраняю в localStorage
      localStorage.setItem("placeName", this.selectedPlaceName);
      localStorage.setItem("urlRegAndPlace", "");
    },

    selectAllRegion(e) {
      this.selectedPlaceName=this.regionName;
      this.locationDialog=false;
      this.buttonAllCountry=false;

      // сохраняю в localStorage
      localStorage.setItem("placeName", this.selectedPlaceName);
      localStorage.setItem("urlRegAndPlace", this.urlRegAndPlace);
    }
  }
}
</script>