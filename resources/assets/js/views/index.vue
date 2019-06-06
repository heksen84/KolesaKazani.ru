<!-- git -->
<template>
<div>

<!-- Верхнее меню -->
<div id="navbar_menu">
  <b-navbar toggleable="lg" type="dark" variant="primary">
    <!--<b-navbar-brand href="#"><b>{{ this.$store.state.str_title }}</b><div style="font-size:14px">все объявления Казахстана</div></b-navbar-brand>-->
    <b-navbar-brand href="#"><b>Дамеля</b><div style="font-size:14px">все объявления Казахстана</div></b-navbar-brand>
    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
    <b-collapse id="nav-collapse" is-nav>
      <b-navbar-nav>
        <b-nav-item href="/podat-obyavlenie">Подать объявление</b-nav-item>
        <b-nav-item href="/home" v-if="auth">Мои объявления</b-nav-item>
        <b-nav-item href="/login" v-if="!auth">Вход</b-nav-item>
        <b-nav-item href="/register" v-if="!auth">Регистрация</b-nav-item>
      </b-navbar-nav>            
    </b-collapse>
  </b-navbar>
</div>

<!-- Контейнер для контента страницы -->
<b-container fluid class="mycontainer" id="index_page">
    
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
        </b-col>        
        <b-col style="text-align:center;top:5px" v-show="!auth" id="login_register_col">
          <div class="button" id="button_login" style="margin-left:17px" @click="login">Вход</div>
          <div class="button" id="button_reg" @click="register">Регистрация</div>          
        </b-col>     
    </b-row>

    <b-row style="margin-top:2px">

        <b-col cols="12" sm="12" md="12" lg="3" xl="3" style="text-align:center">
          <!-- кнопки выбора региона и т.п.-->
          <div class="index_select_region_and_other_button_block" id="select_location_mobile">
            <b-button class="search_options_button mb-1 mr-sm-1 mb-sm-1" size="sm" @click="openLocationWindow" :title="$store.state.str_location">{{ $store.state.str_location }}: {{ selectedPlaceName }}</b-button>          
          </div>

          <!-- Логотип -->        
          <div id="logo_block" @click="closeSubCats">
            <div id="logo_block_text">{{ this.$store.state.str_title }}</div>
            <div style="font-size:16px;color:yellow;margin-top:-13px;letter-spacing:2px;">{{ this.$store.state.str_desc }}</div>
          </div>
        </b-col>

        <b-col cols="12" sm="12" md="12" lg="12" xl="6" style="text-align:center">

          <b-form @submit="search">
            <input v-model="searchString" type="text" id="search_string" :placeholder="$store.state.str_search_placeholder" required/>
            <button id="button_search" type="submit" title="Найти что требуется">{{ this.$store.state.str_button_search }}</button>
          </b-form>

          <!-- кнопки выбора региона и т.п.-->
          <div class="index_select_region_and_other_button_block" id="select_location_desktop">
            <b-button class="search_options_button mb-1 mr-sm-1 mb-sm-1" size="sm" @click="openLocationWindow" :title="$store.state.str_location">{{ $store.state.str_location }}: {{ selectedPlaceName }}</b-button>          
          </div>

        </b-col>

        <b-col cols="12" sm="12" md="12" lg="3" xl="3" style="text-align:center" title="Подать новое объявление"  id="new_advert_col">          
          <a href="/podat-obyavlenie"><div id="new_advert_block">{{ this.$store.state.str_create_advert }}</div></a>
        </b-col>

    </b-row>


    <div id="categories_line">

    <!-- КАТЕГОРИИ -->
    <div v-if="show_categories" style="text-align:center">    
      <div id="categories_title" class="shadow_text" style="margin-bottom:18px">категории</div>        

      <div class="form-inline">
      <b-col cols="12" sm="12" md="12" lg="12" xl="3">
        <a :href="urlRegAndPlace+'/transport'" @click="showSubcategory(0)">
          <div class="category_item">Транспорт</div>
        </a>        
      </b-col>

      <b-col cols="12" sm="12" md="12" lg="12" xl="3">
        <a :href="urlRegAndPlace+'/nedvizhimost'" @click="showSubcategory(1)">        
          <div class="category_item">Недвижимость</div>
        </a>
      </b-col>

      <b-col cols="12" sm="12" md="12" lg="12" xl="3">        
        <a :href="urlRegAndPlace+'/elektronika'" @click="showSubcategory(2)">        
          <div class="category_item">Электроника</div>
        </a>        
      </b-col>
      
      <b-col cols="12" sm="12" md="12" lg="12" xl="3">
        <a href="/rabota-i-biznes" >
          <div class="category_item">Работа и бизнес</div>
        </a>
      </b-col>

      <b-col cols="12" sm="12" md="12" lg="12" xl="3">
        <a href="/dlya-doma-i-dachi">
          <div class="category_item">Для дома и дачи</div>
        </a>           
      </b-col>

      <b-col cols="12" sm="12" md="12" lg="12" xl="3">
        <a href="/lichnye-veschi">
          <div class="category_item">Личные вещи</div>
        </a>          
      </b-col>

      <b-col cols="12" sm="12" md="12" lg="12" xl="3">
        <a href="/zhivotnye">
          <div class="category_item">Животные</div>
        </a>          
      </b-col>

      <b-col cols="12" sm="12" md="12" lg="12" xl="3">
        <a href="/hobbi-i-otdyh">
          <div class="category_item">Хобби и отдых</div>
        </a>          
      </b-col>

      <b-col cols="12" sm="12" md="12" lg="12" xl="3">
        <a href="/uslugi">
          <div class="category_item">Услуги</div>
        </a>          
      </b-col>

      <b-col cols="12" sm="12" md="12" lg="12" xl="3">
        <a href="/drugoe">
          <div class="category_item">Другое</div>
        </a>          
      </b-col>

    </div>
    </div>
    </div>    

  </b-container>

</div>
</template>

<!-- ЛОГИКА -->
<script>
import { get } from './../helpers/api'
export default {
  
  // Входящие данные
  //props: ["items", "auth", "count", "subcats"],

  // переменные
  data () {      
    return {

      auth:false,

      lang: "русский",
      show_categories: true,
      selected_category_id: null,
      selectedPlaceName: "",
      regions: [],
      places: [],
      location: null,
      locationDialog: false,
      locationDialogTitle: "",
      urlRegAndPlace: "",
      buttonAllCountry: true,
      buttonAllRegion: false,
      regionName: "",
      searchString: "",
    }
  },

  // Компонент создан
  created() {
    
    console.log("hello")

    this.lang="ru";
    this.setLang();

    this.selectedPlaceName = "Весь казахстан";

 /*   var lang = localStorage.getItem("lang")
    console.log(lang)

    if (lang!=null) {
      this.$store.commit("SetLang", lang)
      lang=="ru"?this.lang="русский":this.lang="казакша";
    }
    else {
      this.$store.commit("SetLang", "ru")
      this.lang="русский";
    }
    
    var placeName = localStorage.getItem("placeName");
    var urlRegAndPlace = localStorage.getItem("urlRegAndPlace");

    placeName==null?this.selectedPlaceName = "Весь казахстан": this.selectedPlaceName = placeName;
    urlRegAndPlace==null?this.urlRegAndPlace = "":this.urlRegAndPlace = urlRegAndPlace;*/
    

  },

  // Методы компонента
  methods: {

    // Найти
    search(evt) {
      evt.preventDefault()
      var str = this.searchString.split(" ").join("+");
      window.location="/search?str="+str;
    },

    // Установить язык
    setLang() {
      var ru = "русский";
      if (this.lang==ru) {
        this.$store.commit("SetLang", "kz")
        this.lang="казакша";
        //localStorage.setItem("lang", "kz")
      }
      else {
        this.$store.commit("SetLang", "ru")
        this.lang=ru;
        //localStorage.setItem("lang", "ru")
      }
    },

    displaySubItem: function (item) {         
      if (item==this.selected_category_id) return true;          
      return false;
    },


    // Показать подкатегории    
    showSubcategory(category_index) {
    },
        
    // Показать подкатегории    
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
    
    // Скрыть подкатегории
    closeSubCats() {
      if (!this.show_categories) 
        this.show_categories=true;
    },

    // Авторизация
    login() {
      window.location='/login';
    },

    // Регистрация
    register() {
      window.location="/register";
    },    
    
    // Показать окно расположения
    openLocationWindow() {
      this.buttonAllCountry=true;
      this.buttonAllRegion=false;
      this.locationDialog=true;
      this.locationDialogTitle="Выберите регион"
      this.places={};
      this.regions={};

      // получаю регионы
      get("/getRegions").then((res) => {
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
      get("getPlaces?region_id="+e.region_id).then((res) => {
          this.places=res.data;
          console.log(res.data);
      }).catch((err) => {
        console.log(err)
      });

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