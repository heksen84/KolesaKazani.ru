<!-- git -->
<template>
  <b-container fluid class="mycontainer">
    <b-row>

	        <!-- 
            BUG: допустим выбрали Астану далее перешли в недвижимость. Допустим там контроллер битый. 
            Далее возвращаемся назад. Щёлкаем по Астане а там уже весь Казахстан вместе Астаны на кнопке 
            -->

          <!-- окно выбоа региона и местоположения -->
          <b-modal v-model="locationDialog" style="text-align:center;color:rgb(50,50,50)" hide-footer :title="locationDialogTitle">
            <!-- регионы -->
            <b-button variant="link" style="color:black" v-for="i in regions" :key="i.region_id" @click="selectLocation(i)">{{i.name}}
            </b-button>

            <hr v-if="buttonAllCountry">
            <b-button variant="link" v-if="buttonAllCountry" @click="selectAllCountry">Весь Казахстан</b-button>

            <!-- города, cёлы, аулы, деревни -->
            <b-button variant="link" style="color:black" v-for="i in places" :key="i.city_id" @click="selectPlace(i)">{{i.name}}</b-button>

            <hr v-if="buttonAllRegion">
            <button style="color:black;display:block;margin:auto;margin-top:-5px" v-if="buttonAllRegion" @click="selectAllRegion">Вся область</button>
          </b-modal> 

        <b-col id="welcome_menu" v-show="auth">
          <div class="button" id="button_login" style="width:160px;text-align:center;position:relative;top:3px" @click="login">мои объявления</div>         
        </b-col>        

        <b-col style="text-align:center" v-show="!auth">
          <div class="button" id="button_login" style="margin-top:3px" @click="login">Вход</div>
          <div class="button" id="button_reg" style="margin-top:3px" @click="register">Регистрация</div>
        </b-col>
        
    </b-row>

    <b-row style="margin-top:2px">
        <b-col cols="12" sm="12" md="12" lg="3" xl="3" style="text-align:center">

        <!-- Логотип -->        
          <div id="logo_block">
            <div id="logo_block_text">Дамеля</div>
            <div style="font-size:16px;color:yellow;margin-top:-13px;letter-spacing:2px;">доска объявлений</div>
          </div>

        </b-col>

        <b-col cols="12" sm="12" md="12" lg="6" xl="6" style="text-align:center">
          <input type="text" id="search_string" placeholder="Поиск по сайту"/>
          <button id="button_search" @click="search" title="Найти что требуется">найти</button>

          <!-- кнопки выбора региона и т.п.-->
          <div id="index_select_region_and_other_button_block">
          <b-button class="search_options_button mb-1 mr-sm-1 mb-sm-1" size="sm" @click="openLocationWindow" title="Расположение поиска">Расположение {{ selectedPlaceName }}</b-button>
          <!--<b-button class="search_options_button mb-1 mr-sm-1 mb-sm-1" size="sm" style="background:rgb(100,100,150)">Категория</b-button>-->
          </div>
          
        </b-col>

        <b-col cols="12" sm="12" md="12" lg="3" xl="3" style="text-align:center" title="Подать новое объявление">
          <a href="/podat-obyavlenie"><div id="new_advert_block">подать объявление</div></a>
        </b-col>
    </b-row>

    <!-- КАТЕГОРИИ -->
    <div v-if="show_categories">    
    <div id="categories_title" class="shadow_text">категории</div>        
    <b-row v-for="i in Object.keys(items).length" v-bind:key=i>
      <b-col cols="12" sm="12" md="12" lg="3" xl="3" v-for="item in items.slice((i - 1) * 4, i * 4)" v-bind:key=item.id>
        <a :href="urlRegAndPlace+'/'+item.url" @click="showSubcat($event)">
        <div class="category_item">{{ item.name }}
          <!--<span style="font-size:13px;color:rgb(170,255,170);float:right;margin-top:4px" :id="item.id">{{ getCategoryCountById(item.id) }}</span>-->
        </div>
        </a>
      </b-col>
    </b-row>

    </div>

    <!-- ПОД КАТЕГОРИИ -->
    <b-row v-if="!show_categories">
      <b-col cols="12" sm="12" md="12" lg="3" xl="3">        
        <div id="categories_title" class="shadow_text">под категории</div>
        <h2 @click="closeSubCats" style="cursor:pointer" title="закрыть под категории">x</h2>
      </b-col>
    </b-row>


<!-- VIP -->

<b-row style="margin-top:80px"><h5>VIP объявления</h5></b-row>

<b-row>    
    <b-col v-for="i in 10" style="border:1px solid rgb(255,255,255);margin:3px;padding:50px;opacity:0.5" v-bind:key="i"></b-col>
</b-row>

<!-- ПОДВАЛ -->
<b-row>
  <div id="footer"><a href="advertisers" class="underline_link">Реклама на сайте</a> | <a href="about" class="underline_link">Разработано студией AksuSoftware 2018 (c)</a></div>
</b-row>

</b-container>
</template>
<script>
import { get } from './../helpers/api'
//import petrovich from 'petrovich';

export default {
  props: ["items", "auth", "count"],

  data () {
    return {

      show_categories:true,

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


  /*var person = {
    gender: 'androgynous',
    first: 'Павлодар'    
  };*/
    // вызываем Петровича как функцию, указав падеж:
    //console.log(petrovich(person, 'prepositional'));
    

    var placeName = localStorage.getItem("placeName");
    var urlRegAndPlace = localStorage.getItem("urlRegAndPlace");

    //alert(placeName);

    if(placeName==null)
      this.selectedPlaceName = "Весь казахстан";
    else 
      this.selectedPlaceName = placeName;

    if(urlRegAndPlace==null)
      this.urlRegAndPlace = "";
    else 
      this.urlRegAndPlace = urlRegAndPlace;
      
  },
  mounted() {

    /*get('/getCategoryCounts').then((res) => {
          this.regions=res.data;
    }).catch((err) => {});*/
      
  },

  computed: {
  },

  methods: {
    showSubcat(e) {
      e.preventDefault();
      this.show_categories=false;
    },
    closeSubCats() {
      this.show_categories=true;
    },
    getCategoryCountById(id) {
      /*get('getCategoryCountById?category_id='+id).then((res) => {
          return res;
      }).catch((err) => {});*/
      return "-";
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

      //alert(this.selectedPlaceName)

      this.buttonAllCountry=true;
      this.buttonAllRegion=false;
      this.locationDialog=true;
      this.locationDialogTitle="Выберите регион"
      this.places={};
      this.regions={};

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
