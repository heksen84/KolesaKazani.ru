require('./bootstrap');

import Vue from 'vue/dist/vue.js'

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-vue/dist/bootstrap-vue.min.css';

import layout from 'bootstrap-vue/src/components/layout';
import form from 'bootstrap-vue/src/components/form';
import button from 'bootstrap-vue/src/components/button';
import navbar from 'bootstrap-vue/src/components/navbar';
//import input from 'bootstrap-vue/src/components/form-input';
//import alert2 from 'bootstrap-vue/src/components/alert';
//import dropdown from 'bootstrap-vue/src/components/dropdown';
import modal from 'bootstrap-vue/src/components/modal';

Vue.use(layout)
Vue.use(form)
Vue.use(button)
Vue.use(navbar)
//Vue.use(alert2)
//Vue.use(input)
//Vue.use(dropdown)
Vue.use(modal);

import index from './views/index.vue';
//import index from './components/App.vue';
import Vuex from 'vuex';

Vue.use(Vuex);

// -----------------------------------
// Реактивное хранилище
// -----------------------------------
const store = new Vuex.Store({

    state: {       
      str_login: "",
      str_register: "",
      str_my_adverts: "",
      str_title: "---",
      str_desc: "",
      str_search_placeholder: "",
      str_button_search: "",
      str_create_advert: "",
      str_my_adverts: "",
      str_location: "",     
      str_realestate_area_label_text: ""
    },

    mutations: {      
      // установить язык
      SetLang (state, lang) {        
        if (lang == "ru") { // русский
          state.str_title = "Дамеля"
          state.str_desc = "доска объявлений"
          state.str_search_placeholder = "поиск по объявлениям"
          state.str_button_search = "найти"
          state.str_create_advert = "подать объявление"
          state.str_my_adverts = "мои объявления"
          state.str_location = "расположение"          
        }
        if (lang == "kz") { // казахский
          state.str_title = "Дамеля"
          state.str_desc = "хабарландыру тақтасы"
          state.str_search_placeholder = "хабарландыруларда іздеу"
          state.str_button_search = "іздеу"
          state.str_create_advert = "хабарландыру орналастырыңыз"
          state.str_my_adverts = "менің хабарландыруларым"
          state.str_location = "орналасқан"          
        }
      }
    }
})

export default new Vue({
    store,
    el: '#app',
    render: h => h(index)    
});